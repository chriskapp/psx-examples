<?php

namespace App\Api\Population;

use PSX\Framework\Controller\SchemaApiAbstract;
use PSX\Http\Environment\HttpContextInterface;
use PSX\Http\Exception as StatusCode;
use App\Model\Message;

class Collection extends SchemaApiAbstract
{
    /**
     * @Inject
     * @var \App\Service\Population
     */
    protected $populationService;

    /**
     * @QueryParam(name="startIndex", type="integer")
     * @QueryParam(name="count", type="integer")
     * @Outgoing(code=200, schema="App\Model\Collection")
     */
    protected function doGet(HttpContextInterface $context)
    {
        return $this->populationService->getAll(
            $context->getParameter('startIndex'),
            $context->getParameter('count')
        );
    }

    /**
     * @Incoming(schema="App\Model\Population")
     * @Outgoing(code=201, schema="App\Model\Message")
     * @param \App\Model\Population $record
     */
    protected function doPost($record, HttpContextInterface $context)
    {
        throw new StatusCode\NotImplementedException('Not available in demo');

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
