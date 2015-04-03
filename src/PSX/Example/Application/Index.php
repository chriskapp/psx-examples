<?php

namespace PSX\Example\Application;

use PSX\Api\Resource\Generator;
use PSX\Api\Resource\Generator\Html\Sample\Loader;
use PSX\Controller\Tool\DocumentationController;
use PSX\Data\Schema\Generator as SchemaGenerator;

class Index extends DocumentationController
{
	protected function getMetaLinks()
	{
		return array(
			'Welcome' => $this->reverseRouter->getAbsolutePath('PSX\Example\Application\Welcome'),
		);
	}

	protected function getViewGenerators()
	{
		return array(
			'Schema'  => new Generator\Html\Schema(new SchemaGenerator\Html()),
			'Example' => new Generator\Html\Sample(new Loader\XmlFile(__DIR__ . '/../Resource/sample.xml')),
		);
	}
}
