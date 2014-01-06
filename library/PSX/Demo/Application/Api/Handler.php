<?php

namespace PSX\Demo\Application\Api;

use PSX\Handler\DatabaseHandlerAbstract;

/**
 * The handler is the main class to build an API from an datasource. PSX 
 * supports many handler types like database, mongodb, dom, doctrine, pdo etc.
 * all these handlers offers PSX the possibility to create an API from an 
 * datasource. In our case we use an mysql database therefor we use the database
 * handler.
 */
class Handler extends DatabaseHandlerAbstract
{
	protected function getDefaultSelect()
	{
		return $this->manager->getTable('PSX\Demo\Application\Api\Table')
			->select(array('id', 'place', 'region', 'population', 'users', 'world_users', 'datetime'));
	}
}
