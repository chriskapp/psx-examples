<?php

namespace App\Tests;

use PSX\Framework\Test\ControllerDbTestCase;
use App\Api\Population;

class ApiTestCase extends ControllerDbTestCase
{
    public function getDataSet()
    {
        return $this->createFromFile(__DIR__ . '/api_fixture.php');
    }

    protected function getPaths()
    {
        return array(
            [['GET', 'POST', 'PUT', 'DELETE'], '/population', Population\Collection::class],
            [['GET', 'POST', 'PUT', 'DELETE'], '/population/:id', Population\Entity::class],
        );
    }
}
