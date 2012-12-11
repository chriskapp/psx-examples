<?php

namespace demo\sql_operations;

use PSX_Module_ViewAbstract;
use PSX_Sql;
use PSX_Sql_Condition;

class index extends PSX_Module_ViewAbstract
{
	private $sql;

	public function onLoad()
	{
		$this->sql = new PSX_Sql($this->config['psx_sql_host'], 
			$this->config['psx_sql_user'], 
			$this->config['psx_sql_pw'], 
			$this->config['psx_sql_db']);

		// The assoc method retrieves the result as associative array where the
		// columns are the keys and the values are the value of the column
		$assoc = array();
		$sql   = 'SELECT * FROM ' . $this->config['tbl_example'] . ' WHERE id < ? ORDER BY id ASC';

		$result = $this->sql->assoc($sql, array(8));

		foreach($result as $row)
		{
			array_push($assoc, $row);
		}

		$this->template->assign('assoc', $assoc);

		// The object method retrieves the result as object where the columns
		// are the properties and the value are the value of the property. By
		// default the stdClass is used
		$object = array();
		$sql    = 'DESCRIBE ' . $this->config['tbl_example'];

		$result = $this->sql->object($sql);

		foreach($result as $row)
		{
			array_push($object, $row);
		}

		$this->template->assign('object', $object);

		// Returns all results of the query as associative array
		$this->sql->getAll('SELECT id, region FROM ' . $this->config['tbl_example']);

		// Returns an associative array containing the row
		$this->sql->getRow('SELECT id, region FROM ' . $this->config['tbl_example'] . ' WHERE id = 10');

		// Returns an array with all values of the first column
		$regions = $this->sql->getCol('SELECT region FROM ' . $this->config['tbl_example']);

		$this->template->assign('regions', $regions);

		// Returns the value of the first row and column
		$region = $this->sql->getField('SELECT region FROM ' . $this->config['tbl_example'] . ' WHERE id = 2');

		$this->template->assign('region', $region);

		// Select the row with the id 4 and returns an associative array
		$condition = new PSX_Sql_Condition(array('id', '=', 4));

		$this->sql->select($this->config['tbl_example'], array('region', 'users', 'datetime'), $condition, PSX_Sql::SELECT_ROW);

		// Counts all entries from the table
		$count = $this->sql->count($this->config['tbl_example']);

		$this->template->assign('count', $count);

		// Because of security reasons we cant use all methods of the sql
		// library because of that here some fictive examples

		// insert
		/*
		$this->sql->insert($this->config['tbl_example'], array(

			'place'       => '',
			'region'      => '',
			'population'  => '',
			'users'       => '',
			'world_users' => '',
			'date'        => '',

		));
		*/

		// update
		/*
		$condition = new PSX_Sql_Condition(array('id', '=', 4));

		$this->sql->update($this->config['tbl_example'], $condition, array(

			'title' => 'bar',

		));

		// delete
		/*
		$condition = new PSX_Sql_Condition(array('id', '=', 4));

		$this->sql->delete($this->config['tbl_example'], $condition);
		*/


		$this->template->set(str_replace('\\', DIRECTORY_SEPARATOR, __CLASS__) . '.tpl');
	}
}
