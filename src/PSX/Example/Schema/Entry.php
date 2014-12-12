<?php

namespace PSX\Example\Schema;

use PSX\Data\SchemaAbstract;

class Entry extends SchemaAbstract
{
	public function getDefinition()
	{
		$sb = $this->getSchemaBuilder('entry');
		$sb->integer('id')
			->setDescription('Unique id for each entry');
		$sb->integer('place')
			->setDescription('Position in the top list');
		$sb->string('region')
			->setPattern('[A-z]+')
			->setDescription('Name of the region');
		$sb->complexType('population', $this->getSchema('PSX\Example\Schema\Population'))
			->setDescription('Details about the population');
		$sb->dateTime('datetime')
			->setDescription('Date when the entry was created');

		return $sb->getProperty();
	}
}
