<?php

namespace PSX\Example\Api;

use PSX\Api\Documentation;
use PSX\Api\Version;
use PSX\Api\View;
use PSX\Controller\SchemaApiAbstract;
use PSX\Data\RecordInterface;
use PSX\Util\Api\FilterParameter;

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
		$message = $this->schemaManager->getSchema('PSX\Example\Schema\Message');

		$view = new View();
		$view->setGet($this->schemaManager->getSchema('PSX\Example\Schema\Collection'));
		$view->setPost($this->schemaManager->getSchema('PSX\Example\Schema\Create'), $message);
		$view->setPut($this->schemaManager->getSchema('PSX\Example\Schema\Update'), $message);
		$view->setDelete($this->schemaManager->getSchema('PSX\Example\Schema\Delete'), $message);

		return new Documentation\Simple($view);
	}

	protected function doGet(Version $version)
	{
		return array(
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
		// @TODO update record

		return array(
			'success' => true,
			'message' => 'Update successful',
		);
	}

	protected function doDelete(RecordInterface $record, Version $version)
	{
		// @TODO delete record

		return array(
			'success' => true,
			'message' => 'Delete successful',
		);
	}
}
