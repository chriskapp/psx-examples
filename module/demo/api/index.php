<?php

namespace demo\api;

use DateTime;
use Example_Handler;
use Example_Table;
use Exception;
use PSX_Data_Message;
use PSX_Data_WriterInterface;
use PSX_Data_WriterResult;
use PSX_Module_ApiAbstract;
use PSX_Sql;

/**
 * This is an example howto create an REST API endpoint where you can GET and 
 * POST PUT and DELETE an record. The API supports XML, JSON, Atom and Rss. You 
 * can specify the format with the GET parameter "format". By default we check 
 * the Accept header and choose the appropriated format. We use the class 
 * Example_Record as Record class.
 */
class index extends PSX_Module_ApiAbstract
{
	private $sql;
	private $table;

	public function onLoad()
	{
		// create sql connection
		$this->sql = new PSX_Sql($this->config['psx_sql_host'],
			$this->config['psx_sql_user'],
			$this->config['psx_sql_pw'],
			$this->config['psx_sql_db']);

		// get table
		$this->table = new Example_Table($this->sql);
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
				PSX_Sql::FETCH_OBJECT,
				'Example_Record',
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

			$handler = new Example_Handler($this->table);

			// Because of security reasons we cant insert here an actual record
			//$handler->insert($record);

			$this->setResponse(new PSX_Data_Message('You have successful inserted a new record', true));
		}
		catch(Exception $e)
		{
			$this->setResponse(new PSX_Data_Message($e->getMessage(), false));
		}
	}

	protected function setWriterConfig(PSX_Data_WriterResult $writer)
	{
		switch($writer->getType())
		{
			case PSX_Data_WriterInterface::RSS:

				$updated = $this->sql->getField('SELECT `datetime` FROM ' . $this->config['tbl_example'] . ' ORDER BY `datetime` DESC');

				$title       = 'Internet Population';
				$link        = $this->config['psx_url'];
				$description = '';


				$writer = $writer->getWriter();

				$writer->setConfig($title, $link, $description);

				$writer->setGenerator('psx ' . $this->config['psx_version']);

				break;

			case PSX_Data_WriterInterface::ATOM:

				$updated = $this->sql->getField('SELECT `datetime` FROM ' . $this->config['tbl_example'] . ' ORDER BY `datetime` DESC');

				$title   = 'Internet Population';
				$id      = $this->config->getUrn('psx', 'atom', 'example');
				$updated = new DateTime($updated);


				$writer = $writer->getWriter();

				$writer->setConfig($title, $id, $updated);

				$writer->setGenerator('psx ' . $this->config['psx_version']);

				break;
		}
	}
}
