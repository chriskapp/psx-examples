<?php

namespace PSX\Example\Schema;

use PSX\Data\SchemaAbstract;

class Create extends SchemaAbstract
{
	public function getDefinition()
	{
		$entry = $this->getSchema('PSX\Example\Schema\Entry');
		$entry->get('place')->setRequired(true);
		$entry->get('region')->setRequired(true);
		$entry->get('population')->setRequired(true);
		$entry->get('population')->get('complete')->setRequired(true);
		$entry->get('population')->get('users')->setRequired(true);
		$entry->get('population')->get('world')->setRequired(true);

		return $entry;
	}
}
