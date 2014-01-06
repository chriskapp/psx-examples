<?php

namespace PSX\Demo\Application\Api;

use PSX\Sql\TableAbstract;
use PSX\Sql\TableInterface;

/**
 * Class wich contains meta data about an table. These informations are used by
 * the handler to select all fields
 */
class Table extends TableAbstract
{
	public function getName()
	{
		return 'psx_example';
	}

	public function getColumns()
	{
		return array(
			'id'          => TableInterface::TYPE_INT | 10 | TableInterface::PRIMARY_KEY | TableInterface::AUTO_INCREMENT,
			'place'       => TableInterface::TYPE_INT | 10,
			'region'      => TableInterface::TYPE_VARCHAR | 64,
			'population'  => TableInterface::TYPE_INT | 10,
			'users'       => TableInterface::TYPE_INT | 10,
			'world_users' => TableInterface::TYPE_FLOAT,
			'datetime'    => TableInterface::TYPE_DATETIME,
		);
	}
}
