<?php

namespace App\Api\Population;

use PSX\Framework\Controller\SchemaApiAbstract;
use PSX\Http\Environment\HttpContextInterface;
use PSX\Http\Exception as StatusCode;
use App\Model\Message;

/**
 * @Title("Population")
 * @Description("and some more long description")
 * @PathParam(name="id", type="integer")
 */
class Entity extends SchemaApiAbstract
{
    /**
     * @Inject
     * @var \App\Service\Population
     */
    protected $populationService;

    /**
     * @Outgoing(code=200, schema="App\Model\Population")
     */
    protected function doGet(HttpContextInterface $context)
    {
        return $this->populationService->get(
            $context->getUriFragment('id')
        );
    }

    /**
     * @Incoming(schema="App\Model\Population")
     * @Outgoing(code=200, schema="App\Model\Message")
     * @param \App\Model\Population $record
     */
    protected function doPut($record, HttpContextInterface $context)
    {
        throw new StatusCode\NotImplementedException('Not available in demo');

        $this->populationService->update(
            $context->getUriFragment('id'),
            $record->getPlace(),
            $record->getRegion(),
            $record->getPopulation(),
            $record->getUsers(),
            $record->getWorldUsers()
        );

        return new Message(true, 'Update successful');
    }

    /**
     * @Outgoing(code=200, schema="App\Model\Message")
     */
    protected function doDelete($record, HttpContextInterface $context)
    {
        throw new StatusCode\NotImplementedException('Not available in demo');

        $this->populationService->delete(
            $context->getUriFragment('id')
        );

        return new Message(true, 'Delete successful');
    }
}
