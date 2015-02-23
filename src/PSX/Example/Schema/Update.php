<?php

namespace PSX\Example\Schema;

use PSX\Data\SchemaAbstract;

class Update extends SchemaAbstract
{
	public function getDefinition()
	{
		$entry = $this->getSchema('PSX\Example\Schema\Entry');
		$entry->get('id')->setRequired(true);

		return $entry;
	}
}
