<?php

namespace PSX\Demo\Application\Api;

use PSX\Data\RecordAbstract;

/**
 * The record represents an row entry. When a new record is imported through the
 * API the @param annotations are parsed and the field gets converted in the 
 * defined type 
 */
class Record extends RecordAbstract
{
	protected $id;
	protected $place;
	protected $region;
	protected $population;
	protected $users;
	protected $worldUsers;
	protected $datetime;

	/**
	 * @param integer $id
	 */
	public function setId($id)
	{
		$this->id = $id;
	}

	/**
	 * @param integer $place
	 */
	public function setPlace($place)
	{
		$this->place = $place;
	}

	/**
	 * @param string $region
	 */
	public function setRegion($region)
	{
		$this->region = $region;
	}

	/**
	 * @param integer $population
	 */
	public function setPopulation($population)
	{
		$this->population = $population;
	}

	/**
	 * @param integer $users
	 */
	public function setUsers($users)
	{
		$this->users = $users;
	}

	/**
	 * @param float $worldUsers
	 */
	public function setWorldUsers($worldUsers)
	{
		$this->worldUsers = $worldUsers;
	}

	/**
	 * @param DateTime $datetime
	 */
	public function setDatetime(DateTime $datetime)
	{
		$this->datetime = $datetime;
	}
}
