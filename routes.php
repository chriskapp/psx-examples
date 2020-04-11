<?php

return [
    # API
    [['GET'], '/',                            App\Api\Index::class],
    [['ANY'], '/population',                  App\Api\Population\Collection::class],
    [['ANY'], '/population/:id',              App\Api\Population\Entity::class],

    # tool controller
    [['GET'], '/tool/discovery',              PSX\Framework\Controller\Tool\DiscoveryController::class],
    [['GET'], '/tool/routing',                PSX\Framework\Controller\Tool\RoutingController::class],
    [['GET'], '/tool/doc',                    PSX\Framework\Controller\Tool\Documentation\IndexController::class],
    [['GET'], '/tool/doc/:version/*path',     PSX\Framework\Controller\Tool\Documentation\DetailController::class],
    [['GET'], '/tool/raml/:version/*path',    PSX\Framework\Controller\Generator\RamlController::class],
    [['GET'], '/tool/swagger/:version/*path', PSX\Framework\Controller\Generator\SwaggerController::class],
    [['GET'], '/tool/openapi/:version/*path', PSX\Framework\Controller\Generator\OpenAPIController::class],
    [['ANY'], '/tool/soap',                   PSX\Framework\Controller\Proxy\SoapController::class],
];
