<?php

class Example_Table extends PSX_Sql_TableAbstract
{
	public function getConnections()
	{
		return array();
	}

	public function getName()
	{
		return 'psx_example';
	}

	public function getColumns()
	{
		return array(

			'id' => self::TYPE_INT | 10 | self::PRIMARY_KEY,
			'place' => self::TYPE_INT | 10,
			'region' => self::TYPE_VARCHAR | 64,
			'population' => self::TYPE_INT | 10,
			'users' => self::TYPE_INT | 10,
			'world_users' => self::TYPE_FLOAT,
			'datetime' => self::TYPE_DATETIME,

		);
	}
}

