<?php

namespace App\Tests\Api\Population;

use App\Api\Index;
use PSX\Framework\Controller\Tool\Documentation\IndexController;
use PSX\Framework\Controller\Tool\RoutingController;
use PSX\Framework\Test\ControllerTestCase;
use PSX\Framework\Test\Environment;

class IndexTest extends ControllerTestCase
{
    public function testGet()
    {
        $response   = $this->sendRequest('http://127.0.0.1/api', 'GET');
        $router     = Environment::getService('reverse_router');
        $routePath  = $router->getUrl('PSX\Framework\Controller\Tool\RoutingController');
        $docPath    = $router->getUrl('PSX\Framework\Controller\Tool\DocumentationController::doIndex');
        $clientPath = $router->getBasePath() . '/documentation/';

        $body   = (string) $response->getBody();
        $expect = <<<JSON
{
    "message": "Welcome, this is a PSX sample application. It should help to bootstrap a project by providing all needed files and some examples.",
    "links": [
        {
            "rel": "routing",
            "href": "{$routePath}",
            "title": "Gives an overview of all available routing definitions"
        },
        {
            "rel": "documentation",
            "href": "{$docPath}",
            "title": "Generates an API documentation from all available endpoints"
        },
        {
            "rel": "alternate",
            "href": "{$clientPath}",
            "title": "HTML client to view the API documentation",
            "type": "text\/html"
        }
    ]
}
JSON;

        $this->assertJsonStringEqualsJsonString($expect, $body, $body);
    }

    protected function getPaths()
    {
        return array(
            [['GET'], '/api', Index::class],
            [['GET'], '/routing', RoutingController::class],
            [['GET'], '/doc', IndexController::class],
        );
    }
}
