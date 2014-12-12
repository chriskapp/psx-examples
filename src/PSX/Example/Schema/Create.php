<?php

namespace PSX\Example\Schema;

use PSX\Data\SchemaAbstract;

class Create extends SchemaAbstract
{
	public function getDefinition()
	{
		$entry = $this->getSchema('PSX\Example\Schema\Entry');
		$entry->getChild('place')->setRequired(true);
		$entry->getChild('region')->setRequired(true);
		$entry->getChild('population')->setRequired(true);
		$entry->getChild('population')->getChild('complete')->setRequired(true);
		$entry->getChild('population')->getChild('users')->setRequired(true);
		$entry->getChild('population')->getChild('world')->setRequired(true);

		return $entry;
	}
}
