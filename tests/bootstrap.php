<?php

require(__DIR__ . '/../vendor/autoload.php');

\PSX\Framework\Test\Environment::setup(__DIR__ . '/..', function ($fromSchema) {
    return Sample\Tests\TestSchema::getSchema();
});
