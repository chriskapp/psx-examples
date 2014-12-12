<?php

namespace PSX\Example;

use PSX\Sql\TableAbstract;
use PSX\Util\CurveArray;

/**
 * Table
 *
 * @see http://phpsx.org/doc/concept/table.html
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
			'id' => self::TYPE_INT | self::AUTO_INCREMENT | self::PRIMARY_KEY,
			'place' => self::TYPE_INT,
			'region' => self::TYPE_VARCHAR,
			'population' => self::TYPE_INT,
			'users' => self::TYPE_INT,
			'world_users' => self::TYPE_FLOAT,
			'datetime' => self::TYPE_VARCHAR,
		);
	}

	public function getPopulations()
	{
		$sql = "  SELECT id,
				         place,
				         region,
				         population AS population_complete,
				         users AS population_users,
				         world_users AS population_world,
				         datetime
				    FROM psx_example
				ORDER BY population DESC";

		return CurveArray::nest($this->connection->fetchAll($sql));
	}

	public function getPopulation($id)
	{
		$sql = "SELECT id,
				       place,
				       region,
				       population AS population_complete,
				       users AS population_users,
				       world_users AS population_world,
				       datetime
				  FROM psx_example
				 WHERE id = :id";

		return CurveArray::nest($this->connection->fetchAssoc($sql, array(
			'id' => $id,
		)));
	}
}
