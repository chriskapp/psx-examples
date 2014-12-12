<?php

namespace PSX\Example\Api;

use PSX\Api\Documentation;
use PSX\Api\Version;
use PSX\Api\View;
use PSX\Controller\SchemaApiAbstract;
use PSX\Data\RecordInterface;
use PSX\Util\Api\FilterParameter;
use PSX\Http\Exception as HttpException;

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
		$view = new View();
		$view->setGet($this->schemaManager->getSchema('PSX\Example\Schema\Entry'));

		return new Documentation\Simple($view);
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
