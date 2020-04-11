<?php

require(__DIR__ . '/../vendor/autoload.php');

\PSX\Framework\Test\Environment::setup(__DIR__ . '/..', function ($fromSchema) {
    return App\Tests\TestSchema::getSchema();
});
