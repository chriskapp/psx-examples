<?php

namespace PSX\Example\Api;

use PSX\Api\Documentation;
use PSX\Api\Version;
use PSX\Api\View;
use PSX\Controller\SchemaApiAbstract;
use PSX\Data\RecordInterface;
use PSX\Loader\Context;
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

		$builder = new View\Builder(View::STATUS_ACTIVE, $this->context->get(Context::KEY_PATH));
		$builder->setGet($this->schemaManager->getSchema('PSX\Example\Schema\Collection'));
		$builder->setPost($this->schemaManager->getSchema('PSX\Example\Schema\Create'), $message);
		$builder->setPut($this->schemaManager->getSchema('PSX\Example\Schema\Update'), $message);
		$builder->setDelete($this->schemaManager->getSchema('PSX\Example\Schema\Delete'), $message);

		return new Documentation\Simple($builder->getView());
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
