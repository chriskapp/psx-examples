<?php

namespace PSX\Demo\Application\RssFeedParser;

use PSX\Rss;
use PSX\Rss\Importer;
use PSX\Data\Reader;
use PSX\Http\GetRequest;
use PSX\Module\ViewAbstract;

class Index extends ViewAbstract
{
	public function onLoad()
	{
		$url = 'http://news.google.com/news?pz=1&cf=all&topic=t&output=rss';

		$http     = $this->getHttp();
		$reader   = new Reader\Dom();
		$request  = new GetRequest($url);
		$response = $http->request($request);

		$rss      = new Rss();
		$importer = new Importer();
		$rss      = $importer->import($rss, $reader->read($response));

		$this->getTemplate()->assign('result', $rss);
		$this->getTemplate()->assign('feedUrl', $url);
	}
}
