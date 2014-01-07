<?php

namespace PSX\Demo\Application\RssFeedParser;

use PSX\Rss;
use PSX\Rss\Importer;
use PSX\Data\Reader;
use PSX\Http\GetRequest;
use PSX\Module\ViewAbstract;
use PSX\Filter;

class Index extends ViewAbstract
{
	public function onLoad()
	{
	}

	public function onPost()
	{
		$url = $this->getInputPost()->url('string', array(new Filter\Length(3, 256), new Filter\Url()));

		if(!$this->getValidate()->hasError())
		{
			$http     = $this->getHttp();
			$reader   = new Reader\Dom();
			$request  = new GetRequest($url);
			$response = $http->request($request);

			$rss      = new Rss();
			$importer = new Importer();
			$rss      = $importer->import($rss, $reader->read($response));

			$this->getTemplate()->assign('response', $rss);
			$this->getTemplate()->assign('feedUrl', $url);
		}
		else
		{
			$this->getTemplate()->assign('error', $this->getValidate()->getError());
		}
	}
}
