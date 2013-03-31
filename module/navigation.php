<?php

use PSX\ModuleAbstract;
use PSX\Cache;
use PSX\Json;
use PSX\Util\Uuid;

class navigation extends ModuleAbstract
{
	public function onLoad()
	{
		$cache = new Cache('[navigation]', 1);

		if(($content = $cache->load()) === false)
		{
			$path  = PSX_PATH_MODULE . '/demo';
			$demos = $this->scanRecDir($path);


			$content = Json::encode($demos);

			if(!$this->config['psx_debug'])
			{
				$cache->write($content);
			}
		}

		echo $content;
	}

	private function scanRecDir($path, $deep = 0)
	{
		if(!is_dir($path))
		{
			return array();
		}

		$demos = array();
		$files = scandir($path);

		foreach($files as $file)
		{
			$item = $path . '/' . $file;

			if($file[0] == '.')
			{
				continue;
			}

			if($deep == 0)
			{
				if(is_dir($item))
				{
					$text   = str_replace('_', ' ', $file);
					$module = array(

						'text'     => ucfirst($text),
						'source'   => $this->config['psx_url'] . '/' . $this->config['psx_dispatch'] . 'demo/' . $file,
						'leaf'     => false,
						'children' => array(),

					);

					$module['children'][] = array(

						'text'     => 'Run Example',
						'source'   => $this->config['psx_url'] . '/' . $this->config['psx_dispatch'] . 'demo/' . $file,
						'iconCls'  => 'example-run',
						'leaf'     => true,

					);

					// default module
					$defaultModule = $item . '/index.php';

					if(is_file($defaultModule))
					{
						$module['children'][] = array(

							'text'     => 'Module',
							'source'   => $this->config['psx_url'] . '/' . $this->config['psx_dispatch'] . 'source/module/' . Uuid::nameBased($defaultModule),
							'iconCls'  => 'example-module',
							'leaf'     => false,
							'children' => $this->scanRecDir($item, $deep + 1)

						);
					}

					// default template
					$defaultTemplate = PSX_PATH_TEMPLATE . '/default/demo/' . $file . '/index.tpl';

					if(is_file($defaultTemplate))
					{
						$module['children'][] = array(

							'text'     => 'Template',
							'source'   => $this->config['psx_url'] . '/' . $this->config['psx_dispatch'] . 'source/template/' . Uuid::nameBased($defaultTemplate),
							'iconCls'  => 'example-template',
							'leaf'     => false,
							'children' => $this->scanRecDir(PSX_PATH_TEMPLATE . '/default/demo/' . $file, $deep + 1)

						);
					}

					array_push($demos, $module);
				}
			}
			else if($deep == 1)
			{
				if(is_file($item))
				{
					$name = pathinfo($item, PATHINFO_FILENAME);
					$text = str_replace('_', ' ', $name);

					if(strpos($item, PSX_PATH_TEMPLATE) === false)
					{
						$href = $this->config['psx_url'] . '/' . $this->config['psx_dispatch'] . 'source/module/' . Uuid::nameBased($item);
					}
					else
					{
						$href = $this->config['psx_url'] . '/' . $this->config['psx_dispatch'] . 'source/template/' . Uuid::nameBased($item);
					}

					array_push($demos, array(

						'text'   => ucfirst($text),
						'source' => $href,
						'leaf'   => true,

					));
				}
			}
		}

		return $demos;
	}
}
