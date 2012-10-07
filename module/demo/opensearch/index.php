<?php

class index extends PSX_Opensearch_ProviderAbstract
{
	public function onLoad()
	{
		$this->setConfig('PSX Search', 'And a more detailed description');

		$this->addUrl('http://example.com/?q={searchTerms}&pw={startPage?}&format=atom', 'application/atom+xml');

		$this->close();
	}
}

