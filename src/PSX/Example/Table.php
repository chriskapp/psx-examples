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
        $definition = $this->doCollection([$this, 'getAll'], [], [
            'id' => 'id',
            'place' => 'place',
            'region' => 'region',
            'population' => [
                'complete' => 'population',
                'users' => 'users',
                'world' => 'world_users',
            ],
            'datetime' => 'datetime',
        ]);

		return $this->build($definition);
	}

	public function getPopulation($id)
	{
        $definition = $this->doEntity([$this, 'get'], [$id], [
            'id' => 'id',
            'place' => 'place',
            'region' => 'region',
            'population' => [
                'complete' => 'population',
                'users' => 'users',
                'world' => 'world_users',
            ],
            'datetime' => 'datetime',
        ]);

        return $this->build($definition);
	}
}
