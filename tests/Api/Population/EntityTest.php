<?php

namespace Sample\Tests\Api\Population;

use PSX\Framework\Test\Environment;
use Sample\Tests\ApiTestCase;

class EntityTest extends ApiTestCase
{
    public function testGet()
    {
        $response = $this->sendRequest('http://127.0.0.1/population/1', 'GET');

        $body   = (string) $response->getBody();
        $expect = <<<JSON
{
    "id": 1,
    "place": 1,
    "region": "China",
    "population": 1338612968,
    "users": 360000000,
    "worldUsers": 20.8,
    "datetime": "2009-11-29T15:21:49Z"
}
JSON;

        $this->assertEquals(200, $response->getStatusCode(), $body);
        $this->assertJsonStringEqualsJsonString($expect, $body, $body);
    }

    public function testGetNotFound()
    {
        $response = $this->sendRequest('http://127.0.0.1/population/16', 'GET');

        $body = (string) $response->getBody();

        $this->assertEquals(404, $response->getStatusCode(), $body);
    }

    public function testPost()
    {
        $response = $this->sendRequest('http://127.0.0.1/population/1', 'POST');

        $body = (string) $response->getBody();

        $this->assertEquals(405, $response->getStatusCode(), $body);
    }

    public function testPut()
    {
        $payload = json_encode([
            'id'         => 1,
            'place'      => 11,
            'region'     => 'Foo',
            'population' => 1024,
            'users'      => 512,
            'worldUsers' => 0.6,
        ]);

        $response = $this->sendRequest('http://127.0.0.1/population/1', 'PUT', ['Content-Type' => 'application/json'], $payload);

        $body   = (string) $response->getBody();
        $expect = <<<JSON
{
    "success": true,
    "message": "Update successful"
}
JSON;

        $this->assertEquals(200, $response->getStatusCode(), $body);
        $this->assertJsonStringEqualsJsonString($expect, $body, $body);

        // check database
        $sql = Environment::getService('connection')->createQueryBuilder()
            ->select('id', 'place', 'region', 'population', 'users', 'worldUsers')
            ->from('population')
            ->where('id = :id')
            ->getSQL();

        $result = Environment::getService('connection')->fetchAssoc($sql, ['id' => 1]);
        $expect = [
            'id' => 1,
            'place' => 11,
            'region' => 'Foo',
            'population' => 1024,
            'users' => 512,
            'worldUsers' => 0.6
        ];

        $this->assertEquals($expect, $result);
    }

    public function testDelete()
    {
        $response = $this->sendRequest('http://127.0.0.1/population/1', 'DELETE');

        $body   = (string) $response->getBody();
        $expect = <<<JSON
{
    "success": true,
    "message": "Delete successful"
}
JSON;

        $this->assertEquals(200, $response->getStatusCode(), $body);
        $this->assertJsonStringEqualsJsonString($expect, $body, $body);

        // check database
        $sql = Environment::getService('connection')->createQueryBuilder()
            ->select('id', 'place', 'region', 'population', 'users', 'worldUsers')
            ->from('population')
            ->where('id = :id')
            ->getSQL();

        $result = Environment::getService('connection')->fetchAssoc($sql, ['id' => 1]);

        $this->assertEmpty($result);
    }
}
