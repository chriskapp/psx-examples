<?php

namespace demo\api;

use Example\Handler;
use Example\Table;
use Exception;
use PSX\Base;
use PSX\DateTime;
use PSX\Data\Message;
use PSX\Data\WriterInterface;
use PSX\Data\WriterResult;
use PSX\Module\ApiAbstract;
use PSX\Sql;
use PSX\Urn;

/**
 * This is an example howto create an REST API endpoint where you can GET and 
 * POST PUT and DELETE an record. The API supports XML, JSON, Atom and Rss. You 
 * can specify the format with the GET parameter "format". By default we check 
 * the Accept header and choose the appropriated format. We use the class 
 * Example_Record as Record class.
 */
class example extends ApiAbstract
{
	protected $handler;

	public function onLoad()
	{
		// get handler
		$this->handler = new Handler(new Table($this->getSql()));
	}

	/**
	 * @httpMethod GET
	 * @path /
	 */
	public function getNews()
	{
		try
		{
			$params    = $this->getRequestParams();
			$fields    = (array) $params['fields'];
			$resultSet = $this->handler->getResultSet($fields, 
				$params['startIndex'], 
				$params['count'], 
				$params['sortBy'], 
				$params['sortOrder'], 
				$this->getRequestCondition(),
				$this->getMode());

			$this->setResponse($resultSet);
		}
		catch(\Exception $e)
		{
			$msg = new Message($e->getMessage(), false);

			$this->setResponse($msg);
		}
	}

	/**
	 * @httpMethod GET
	 * @path /@supportedFields
	 */
	public function getSupportedFields()
	{
		try
		{
			$array = new ArrayList($this->handler->getSupportedFields());

			$this->setResponse($array);
		}
		catch(\Exception $e)
		{
			$msg = new Message($e->getMessage(), false);

			$this->setResponse($msg);
		}
	}

	/**
	 * @httpMethod POST
	 * @path /
	 */
	public function insertNews()
	{
		try
		{
			$record = $this->handler->getRecord();
			$record->import($this->getRequest());

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
	}

	protected function setWriterConfig(WriterResult $writer)
	{
		switch($writer->getType())
		{
			case WriterInterface::RSS:
				$updated = $this->getSql()->getField('SELECT `datetime` FROM ' . $this->config['tbl_example'] . ' ORDER BY `datetime` DESC');

				$title       = 'Internet Population';
				$link        = $this->config['psx_url'];
				$description = '';

				$writer = $writer->getWriter();
				$writer->setConfig($title, $link, $description);
				$writer->setGenerator('psx ' . Base::getVersion());
				break;

			case WriterInterface::ATOM:
				$updated = $this->getSql()->getField('SELECT `datetime` FROM ' . $this->config['tbl_example'] . ' ORDER BY `datetime` DESC');

				$title   = 'Internet Population';
				$id      = Urn::buildUrn(array('psx', 'atom', 'example'));
				$updated = new DateTime($updated);

				$writer = $writer->getWriter();
				$writer->setConfig($title, $id, $updated);
				$writer->setGenerator('psx ' . Base::getVersion());
				break;
		}
	}
}
