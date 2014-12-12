<?php

namespace PSX\Example\Schema;

use PSX\Data\SchemaAbstract;
use PSX\Data\Schema\Property;

class Collection extends SchemaAbstract
{
	public function getDefinition()
	{
		$sb = $this->getSchemaBuilder('collection');
		$sb->arrayType('entry')
			->setPrototype($this->getSchema('PSX\Example\Schema\Entry'));

		return $sb->getProperty();
	}
}
