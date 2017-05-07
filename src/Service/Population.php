<?php

namespace Sample\Service;

use PSX\Http\Exception as StatusCode;
use Sample\Model\Collection;
use Sample\Table\Population as TablePopulation;

class Population
{
    protected $populationTable;

    public function __construct(TablePopulation $populationTable)
    {
        $this->populationTable = $populationTable;
    }

    public function getAll($startIndex = 0, $count = 16)
    {
        return new Collection(
            $this->populationTable->getCount(),
            $this->populationTable->getAll($startIndex, $count)
        );
    }

    public function get($id)
    {
        $population = $this->populationTable->get($id);

        if (empty($population)) {
            throw new StatusCode\NotFoundException('Internet population not found');
        }

        return $population;
    }

    public function create($place, $region, $count, $users, $worldUsers)
    {
        $this->populationTable->create([
            'place'      => $place,
            'region'     => $region,
            'population' => $count,
            'users'      => $users,
            'worldUsers' => $worldUsers,
            'datetime'   => new \DateTime(),
        ]);
    }

    public function update($id, $place, $region, $count, $users, $worldUsers)
    {
        $population = $this->get($id);

        $this->populationTable->update([
            'id'         => $population['id'],
            'place'      => $place,
            'region'     => $region,
            'population' => $count,
            'users'      => $users,
            'worldUsers' => $worldUsers,
        ]);
    }

    public function delete($id)
    {
        $population = $this->get($id);

        $this->populationTable->delete([
            'id' => $population['id']
        ]);
    }
}
