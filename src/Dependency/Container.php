<?php

namespace Sample\Dependency;

use PSX\Framework\Dependency\DefaultContainer;
use Sample\Service;
use Sample\Table;

class Container extends DefaultContainer
{
    /**
     * @return \Sample\Service\Population
     */
    public function getPopulationService()
    {
        return new Service\Population(
            $this->get('table_manager')->getTable(Table\Population::class)
        );
    }
}
