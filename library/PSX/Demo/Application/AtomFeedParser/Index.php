<?php

namespace PSX\Demo\Application\AtomFeedParser;

use PSX\Atom;
use PSX\Atom\Importer;
use PSX\Data\Reader;
use PSX\Http\GetRequest;
use PSX\Module\ViewAbstract;

class Index extends ViewAbstract
{
	public function onLoad()
	{
		$url = 'http://news.google.com/news?pz=1&cf=all&topic=t&output=atom';

		$http     = $this->getHttp();
		$reader   = new Reader\Dom();
		$request  = new GetRequest($url);
		$response = $http->request($request);

		$atom     = new Atom();
		$importer = new Importer();
		$atom     = $importer->import($atom, $reader->read($response));

		$this->getTemplate()->assign('result', $atom);
		$this->getTemplate()->assign('feedUrl', $url);
	}
}