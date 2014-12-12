<?php

namespace PSX\Example\Schema;

use PSX\Data\SchemaAbstract;

class Population extends SchemaAbstract
{
	public function getDefinition()
	{
		$sb = $this->getSchemaBuilder('population');
		$sb->integer('complete')
			->setDescription('Complete number of population');
		$sb->integer('users')
			->setDescription('Number of internet users');
		$sb->float('world')
			->setMin(1)
			->setMax(100)
			->setDescription('Percentage users of the world');

		return $sb->getProperty();
	}
}
