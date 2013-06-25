<?php

namespace demo\opensearch;

use PSX\ModuleAbstract;
use PSX\Opensearch\Writer;

class index extends ModuleAbstract
{
	public function onLoad()
	{
		$writer = new Writer('PSX Search', 'And a more detailed description');
		$writer->addUrl('http://example.com/?q={searchTerms}&pw={startPage?}&format=atom', 'application/atom+xml');
		$writer->output();
	}
}

