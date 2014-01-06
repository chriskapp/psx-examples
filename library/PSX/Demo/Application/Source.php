<?php

namespace PSX\Demo\Application;

use PSX\ModuleAbstract;
use PSX\Cache;
use PSX\Util\Uuid;

class Source extends ModuleAbstract
{
	const CACHE_EXPIRE = 604800; // ca 1 week
	const CACHE_UUID_MAP_EXPIRE = 2419200; // ca 1 month

	/**
	 * @httpMethod GET
	 * @path /{uuid}
	 */
	public function library()
	{
		$uuid  = $this->getUriFragments('uuid');
		$cache = new Cache('library-' . $uuid, self::CACHE_EXPIRE);

		if(($content = $cache->load()) === false)
		{
			$content = $this->loadContent(PSX_PATH_LIBRARY . '/PSX/Demo', $uuid);

			if($content !== false)
			{
				if(!$this->config['psx_debug'])
				{
					$cache->write($content);
				}
			}
			else
			{
				echo 'No source available';
			}
		}

		echo $content;
	}

	private function loadContent($uuidMapPath, $uuid)
	{
		$cache = new Cache($uuidMapPath . '-uuid-map', self::CACHE_UUID_MAP_EXPIRE);
		$data  = $cache->load();

		if($data === false)
		{
			$uuidMap = $this->buildUuidMap($uuidMapPath);

			$cache->write(serialize($uuidMap));
		}
		else
		{
			$uuidMap = unserialize($data);			
		}

		if(isset($uuidMap[$uuid]))
		{
			$content = highlight_file($uuidMap[$uuid], true);
			$content = $this->classParser($content);

			return $content;
		}
		else
		{
			return false;
		}
	}

	private function buildUuidMap($path)
	{
		$files = scandir($path);
		$map   = array();

		foreach($files as $f)
		{
			$item = $path . '/' . $f;

			if($f[0] != '.')
			{
				if(is_dir($item))
				{
					$map = array_merge($map, $this->buildUuidMap($item));
				}

				if(is_file($item))
				{
					$map[Uuid::nameBased(realpath($item))] = $item;
				}
			}
		}

		return $map;
	}

	private function classParser($content)
	{
		return $content;
		//return preg_replace_callback('/([a-zA-Z_\x7f-\xff][a-zA-Z0-9_\x7f-\xff]{6,40})/ims', array($this, 'classParserCallback'), $content);
	}

	private function classParserCallback($matches)
	{
		$file = PSX_PATH_LIBRARY . '/' . str_replace('_', '/', $matches[0]) . '.php';

		if(is_file($file) && class_exists($matches[0]))
		{
			$uuid = Uuid::nameBased($file);
			$url  = $this->config['psx_url'] . '/' . $this->config['psx_dispatch'] . 'source/library/' . $uuid;

			return '<a href="' . $url . '">' . $matches[0] . '</a>';
		}

		return $matches[0];
	}
}
