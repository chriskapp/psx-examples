<?php

namespace Sample\Api\Population;

use PSX\Framework\Controller\SchemaApiAbstract;
use Sample\Model\Message;

/**
 * @Title("Population")
 * @Description("and some more long description")
 * @PathParam(name="id", type="integer")
 */
class Entity extends SchemaApiAbstract
{
    /**
     * @Inject
     * @var \Sample\Service\Population
     */
    protected $populationService;

    /**
     * @Outgoing(code=200, schema="Sample\Model\Population")
     */
    protected function doGet()
    {
        return $this->populationService->get(
            $this->pathParameters['id']
        );
    }

    /**
     * @Incoming(schema="Sample\Model\Population")
     * @Outgoing(code=200, schema="Sample\Model\Message")
     * @param \Sample\Model\Population $record
     */
    protected function doPut($record)
    {
        $this->populationService->update(
            $this->pathParameters['id'],
            $record->getPlace(),
            $record->getRegion(),
            $record->getPopulation(),
            $record->getUsers(),
            $record->getWorldUsers()
        );

        return new Message(true, 'Update successful');
    }

    /**
     * @Outgoing(code=200, schema="Sample\Model\Message")
     */
    protected function doDelete($record)
    {
        $this->populationService->delete(
            $this->pathParameters['id']
        );

        return new Message(true, 'Delete successful');
    }
}
