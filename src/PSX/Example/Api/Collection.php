<?php

namespace PSX\Example\Api;

use PSX\Api\Parser\Raml;
use PSX\Framework\Controller\SchemaApiAbstract;
use PSX\Framework\Loader\Context;
use PSX\Record\RecordInterface;

class Collection extends SchemaApiAbstract
{
	/**
	 * @Inject
	 * @var \PSX\Sql\TableManager
	 */
	protected $tableManager;

	public function getDocumentation($version = null)
	{
		return Raml::fromFile(__DIR__ . '/../Resource/population.raml', $this->context->get(Context::KEY_PATH));
	}

	protected function doGet()
	{
		return array(
			'totalResults' => $this->tableManager->getTable('PSX\Example\Table')->getCount(),
			'entry' => $this->tableManager->getTable('PSX\Example\Table')->getPopulations(),
		);
	}

	protected function doCreate($record)
	{
		// @TODO insert record

		return array(
			'success' => true,
			'message' => 'Create successful',
		);
	}

	protected function doUpdate($record)
	{
	}

	protected function doDelete($record)
	{
	}
}
