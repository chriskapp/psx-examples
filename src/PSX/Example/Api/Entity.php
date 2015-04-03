<?php

namespace PSX\Example\Api;

use PSX\Api\Documentation;
use PSX\Api\Documentation\Parser\Raml;
use PSX\Api\Version;
use PSX\Controller\SchemaApiAbstract;
use PSX\Data\RecordInterface;
use PSX\Http\Exception as HttpException;
use PSX\Loader\Context;
use PSX\Util\Api\FilterParameter;

class Entity extends SchemaApiAbstract
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
		$id    = $this->pathParameters->getProperty('id');
		$entry = $this->tableManager->getTable('PSX\Example\Table')->getPopulation($id);

		if(empty($entry))
		{
			throw new HttpException\NotFoundException('Invalid entry');
		}

		return $entry;
	}

	protected function doCreate(RecordInterface $record, Version $version)
	{
	}

	protected function doUpdate(RecordInterface $record, Version $version)
	{
		$id = $this->pathParameters->getProperty('id');

		// @TODO update record

		return array(
			'success' => true,
			'message' => 'Update successful',
		);
	}

	protected function doDelete(RecordInterface $record, Version $version)
	{
		$id = $this->pathParameters->getProperty('id');

		// @TODO delete record

		return array(
			'success' => true,
			'message' => 'Delete successful',
		);
	}
}
