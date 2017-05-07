<?php

namespace Sample\Api\Population;

use PSX\Framework\Controller\SchemaApiAbstract;
use Sample\Model\Message;

class Collection extends SchemaApiAbstract
{
    /**
     * @Inject
     * @var \Sample\Service\Population
     */
    protected $populationService;

    /**
     * @QueryParam(name="startIndex", type="integer")
     * @QueryParam(name="count", type="integer")
     * @Outgoing(code=200, schema="Sample\Model\Collection")
     */
    protected function doGet()
    {
        return $this->populationService->getAll(
            $this->queryParameters->getProperty('startIndex'),
            $this->queryParameters->getProperty('count')
        );
    }

    /**
     * @Incoming(schema="Sample\Model\Population")
     * @Outgoing(code=201, schema="Sample\Model\Message")
     * @param \Sample\Model\Population $record
     */
    protected function doPost($record)
    {
        $this->populationService->create(
            $record->getPlace(),
            $record->getRegion(),
            $record->getPopulation(),
            $record->getUsers(),
            $record->getWorldUsers()
        );

        return new Message(true, 'Create population successful');
    }
}
