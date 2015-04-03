<?php

namespace PSX\Example\Api;

use PSX\Api\Documentation;
use PSX\Api\Documentation\Parser\Raml;
use PSX\Api\Version;
use PSX\Controller\SchemaApiAbstract;
use PSX\Data\RecordInterface;
use PSX\Loader\Context;

class Collection extends SchemaApiAbstract
{
	/**
	 * @Inject
	 * @var PSX\Sql\TableManager
	 */
	protected $tableManager;

	/**
	 * @Inject
	 * @var PSX\Data\SchemaManager
	 */
	protected $schemaManager;

	public function getDocumentation()
	{
		return Raml::fromFile(__DIR__ . '/../Resource/population.raml', $this->context->get(Context::KEY_PATH));
	}

	protected function doGet(Version $version)
	{
		return array(
			'totalResults' => $this->tableManager->getTable('PSX\Example\Table')->getCount(),
			'entry' => $this->tableManager->getTable('PSX\Example\Table')->getPopulations(),
		);
	}

	protected function doCreate(RecordInterface $record, Version $version)
	{
		// @TODO insert record

		return array(
			'success' => true,
			'message' => 'Create successful',
		);
	}

	protected function doUpdate(RecordInterface $record, Version $version)
	{
	}

	protected function doDelete(RecordInterface $record, Version $version)
	{
	}
}
