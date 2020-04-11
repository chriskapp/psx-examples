<?php

namespace App\Dependency;

use PSX\Framework\Dependency\DefaultContainer;
use App\Service;
use App\Table;

class Container extends DefaultContainer
{
    /**
     * @return \App\Service\Population
     */
    public function getPopulationService(): Service\Population
    {
        return new Service\Population(
            $this->get('table_manager')->getTable(Table\Population::class)
        );
    }
}
