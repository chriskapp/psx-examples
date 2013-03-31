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
	private $sql;
	private $table;

	public function onLoad()
	{
		// create sql connection
		$this->sql = new Sql($this->config['psx_sql_host'],
			$this->config['psx_sql_user'],
			$this->config['psx_sql_pw'],
			$this->config['psx_sql_db']);

		// get table
		$this->table = new Table($this->sql);
	}

	public function onGet()
	{
		// get default params
		$params = $this->getRequestParams();

		// selected fields
		$availableFields = $this->table->getColumns();
		$selectedFields  = array();

		if(isset($params['fields']))
		{
			foreach($params['fields'] as $field)
			{
				if(isset($availableFields[$field]))
				{
					$selectedFields[] = $field;
				}
			}
		}

		if(empty($selectedFields))
		{
			$selectedFields = array_keys($availableFields);
		}

		// get resultset
		$resultSet = $this->table->select($selectedFields)
			->getResultSet($params['startIndex'],
				$params['count'],
				$params['sortBy'],
				$params['sortOrder'],
				$params['filterBy'],
				$params['filterOp'],
				$params['filterValue'],
				$params['updatedSince'],
				Sql::FETCH_OBJECT,
				'\Example\Record',
				array($this->table, $this->config)
			);

		// set response
		$this->setResponse($resultSet);
	}

	public function onPost()
	{
		try
		{
			$record = $this->table->getRecord();
			$record->import($this->getRequest());

			$handler = new Handler($this->table);

			// Because of security reasons we cant insert here an actual record
			//$handler->insert($record);

			$this->setResponse(new Message('You have successful inserted a new record', true));
		}
		catch(\Exception $e)
		{
			$this->setResponse(new Message($e->getMessage(), false));
		}
	}

	protected function setWriterConfig(WriterResult $writer)
	{
		switch($writer->getType())
		{
			case WriterInterface::RSS:

				$updated = $this->sql->getField('SELECT `datetime` FROM ' . $this->config['tbl_example'] . ' ORDER BY `datetime` DESC');

				$title       = 'Internet Population';
				$link        = $this->config['psx_url'];
				$description = '';

				$writer = $writer->getWriter();
				$writer->setConfig($title, $link, $description);
				$writer->setGenerator('psx ' . Base::getVersion());

				break;

			case WriterInterface::ATOM:

				$updated = $this->sql->getField('SELECT `datetime` FROM ' . $this->config['tbl_example'] . ' ORDER BY `datetime` DESC');

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
