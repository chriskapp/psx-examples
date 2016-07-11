<?php

namespace PSX\Example\Api;

use PSX\Api\Parser\Raml;
use PSX\Framework\Controller\SchemaApiAbstract;
use PSX\Framework\Loader\Context;
use PSX\Http\Exception as StatusCode;

class Entity extends SchemaApiAbstract
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
		$id    = $this->pathParameters->getProperty('id');
		$entry = $this->tableManager->getTable('PSX\Example\Table')->getPopulation($id);

		if(empty($entry))
		{
			throw new StatusCode\NotFoundException('Invalid entry');
		}

		return $entry;
	}

	protected function doCreate($record)
	{
	}

	protected function doUpdate($record)
	{
		$id = $this->pathParameters->getProperty('id');

		// @TODO update record

		return array(
			'success' => true,
			'message' => 'Update successful',
		);
	}

	protected function doDelete($record)
	{
		$id = $this->pathParameters->getProperty('id');

		// @TODO delete record

		return array(
			'success' => true,
			'message' => 'Delete successful',
		);
	}
}
