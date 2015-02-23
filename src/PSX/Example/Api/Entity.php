<?php

namespace PSX\Example\Api;

use PSX\Api\Documentation;
use PSX\Api\Version;
use PSX\Api\View;
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
		$builder = new View\Builder(View::STATUS_ACTIVE, $this->context->get(Context::KEY_PATH));
		$builder->setGet($this->schemaManager->getSchema('PSX\Example\Schema\Entry'));

		return new Documentation\Simple($builder->getView());
	}

	protected function doGet(Version $version)
	{
		$entry = $this->tableManager->getTable('PSX\Example\Table')->getPopulation($this->getUriFragment('id'));

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
	}

	protected function doDelete(RecordInterface $record, Version $version)
	{
	}
}
