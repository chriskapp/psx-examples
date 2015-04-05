<?php

namespace PSX\Example;

use PSX\Sql\TableAbstract;
use PSX\Sql\NestRule;

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
				         population AS complete,
				         users AS users,
				         world_users AS world,
				         datetime
				    FROM psx_example
				ORDER BY population DESC";

		$rule = new NestRule();
		$rule->add('population', ['complete', 'users', 'world']);

		return $this->project($sql, [], null, $rule);
	}

	public function getPopulation($id)
	{
		$sql = "SELECT id,
				       place,
				       region,
				       population AS complete,
				       users AS users,
				       world_users AS world,
				       datetime
				  FROM psx_example
				 WHERE id = :id";

		$rule = new NestRule();
		$rule->add('population', ['complete', 'users', 'world']);

		return current($this->project($sql, ['id' => $id], null, $rule));
	}
}
