<?php

namespace PSX\Demo\Application\Api;

use PSX\Atom;
use PSX\Atom\Entry;
use PSX\Atom\Text;
use PSX\Base;
use PSX\DateTime;
use PSX\Data\Message;
use PSX\Data\WriterInterface;
use PSX\Data\WriterResult;
use PSX\Data\RecordInterface;
use PSX\Data\Record\Mapper;
use PSX\Data\Record\Mapper\Rule;
use PSX\Module\ApiAbstract;
use PSX\Sql;
use PSX\Urn;
use PSX\Util\Uuid;
use PSX\Filter\FilterDefinition;
use PSX\Filter\Definition\Property;
use PSX\Validate;

/**
 * This is an example howto create an REST API endpoint. The API supports XML, 
 * JSON and Atom. You can specify the format with the GET parameter "format". 
 * By default we check the Accept header and choose the appropriated format. 
 */
class Api extends ApiAbstract
{
	/**
	 * @httpMethod GET
	 * @path /
	 */
	public function getNews()
	{
		try
		{
			$params = $this->getRequestParams();
			$result = $this->getDatabaseManager()
				->getHandler('PSX\Demo\Application\Api\Handler')
				->getCollection($params['fields'], 
					$params['startIndex'], 
					$params['count'], 
					$params['sortBy'], 
					$params['sortOrder'], 
					$this->getRequestCondition());

			if($this->isWriter(WriterInterface::ATOM))
			{
				$this->setResponse($this->getAtomRecord($result));
			}
			else
			{
				$this->setResponse($result);
			}
		}
		catch(\Exception $e)
		{
			if($this->isWriter(WriterInterface::ATOM))
			{
				$msg = new Entry();
				$msg->setId(Uuid::nameBased($e->getMessage()));
				$msg->setTitle($e->getMessage());
				$msg->setUpdated(new DateTime());
			}
			else
			{
				$msg = new Message($e->getMessage(), false);
			}

			$this->setResponse($msg);
		}
	}

	/**
	 * @httpMethod POST
	 * @path /
	 */
	public function insertNews()
	{
		/*
		try
		{
			$record = $this->handler->getRecord();
			$record = $this->import($record);

			// validate
			$this->getFilterDefinition()->validate($record);

			// insert
			$this->handler->create($record);


			$msg = new Message('You have successful create a ' . $record->getName(), true);

			$this->setResponse($msg);
		}
		catch(\Exception $e)
		{
			$msg = new Message($e->getMessage(), false);

			$this->setResponse($msg);
		}
		*/
	}

	/**
	 * If we want display an atom feed we need to convert our record to an 
	 * Atom\Record. This method does the mapping
	 *
	 * @return PSX\Atom
	 */
	protected function getAtomRecord(RecordInterface $result)
	{
		$atom = new Atom();
		$atom->setTitle('Internet population');
		$atom->setId(Uuid::nameBased($this->config['psx_url']));
		$atom->setUpdated($result->current()->getDatetime());

		$mapper = new Mapper();
		$mapper->setRule(array(
			'id'       => 'id',
			'region'   => 'title',
			'users'    => new Rule('summary', function($text, array $row){
				return new Text(sprintf('%s has a population of %s people %s of them are internet users', $row['region'], $row['population'], $row['users']), 'text');
			}),
			'datetime' => 'updated',
		));

		foreach($result as $row)
		{
			$entry = new Atom\Entry();
			$mapper->map($row, $entry);

			$atom->add($entry);
		}

		return $atom;
	}

	protected function getFilterDefinition()
	{
		return new FilterDefinition($this->getValidate(), array(
			new Property('id', Validate::TYPE_INTEGER),
			new Property('place', Validate::TYPE_INTEGER, array(new Filter\Html())),
			new Property('region', Validate::TYPE_STRING),
			new Property('population', Validate::TYPE_INTEGER),
			new Property('users', Validate::TYPE_INTEGER),
			new Property('world_users', Validate::TYPE_FLOAT),
			new Property('datetime', Validate::TYPE_STRING, array(new Filter\DateTime())),
		));
	}
}
