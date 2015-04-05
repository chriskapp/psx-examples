<?php

namespace PSX\Example\Application;

use PSX\Api\Resource\Generator;
use PSX\Api\Resource\Generator\Html\Sample\Loader;
use PSX\Controller\Tool\DocumentationController;
use PSX\Data\Schema\Generator as SchemaGenerator;

class Documentation extends DocumentationController
{
	protected function getViewGenerators()
	{
		return array(
			'Schema'  => new Generator\Html\Schema(new SchemaGenerator\Html()),
			'Example' => new Generator\Html\Sample(new Loader\XmlFile(__DIR__ . '/../Resource/sample.xml')),
		);
	}
}
