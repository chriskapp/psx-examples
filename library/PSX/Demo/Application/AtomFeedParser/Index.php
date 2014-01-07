<?php

namespace PSX\Demo\Application\AtomFeedParser;

use PSX\Atom;
use PSX\Atom\Importer;
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

			$atom     = new Atom();
			$importer = new Importer();
			$atom     = $importer->import($atom, $reader->read($response));

			$this->getTemplate()->assign('response', $atom);
			$this->getTemplate()->assign('feedUrl', $url);
		}
		else
		{
			$this->getTemplate()->assign('error', $this->getValidate()->getError());
		}
	}
}