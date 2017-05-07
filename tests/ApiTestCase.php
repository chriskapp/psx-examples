<?php

namespace Sample\Tests;

use PSX\Framework\Test\ControllerDbTestCase;

class ApiTestCase extends ControllerDbTestCase
{
    public function getDataSet()
    {
        return $this->createFlatXMLDataSet(__DIR__ . '/api_fixture.xml');
    }

    protected function getPaths()
    {
        return array(
            [['GET', 'POST', 'PUT', 'DELETE'], '/population', 'Sample\Api\Population\Collection'],
            [['GET', 'POST', 'PUT', 'DELETE'], '/population/:id', 'Sample\Api\Population\Entity'],
        );
    }
}
