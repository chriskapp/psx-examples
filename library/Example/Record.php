<?php

namespace Example;

use PSX\Config;
use PSX\DateTime;
use PSX\Exception;
use PSX\Data\Record\TableAbstract;
use PSX\Data\WriterInterface;
use PSX\Data\WriterResult;
use PSX\Sql\TableInterface;
use PSX\Urn;

class Record extends TableAbstract
{
	protected $id;
	protected $place;
	protected $region;
	protected $population;
	protected $users;
	protected $world_users;
	protected $datetime;

	public function setId($id)
	{
		$this->id = $id;
	}

	public function setPlace($place)
	{
		$this->place = $place;
	}

	public function setRegion($region)
	{
		$this->region = $region;
	}

	public function setPopulation($population)
	{
		$this->population = $population;
	}

	public function setUsers($users)
	{
		$this->users = $users;
	}

	public function setWorld_users($world_users)
	{
		$this->world_users = $world_users;
	}

	public function setDatetime($datetime)
	{
		$this->datetime = $datetime;
	}

	public function getDate()
	{
		return new DateTime($this->datetime);
	}

	public function export(WriterResult $result)
	{
		switch($result->getType())
		{
			case WriterInterface::RSS:
				$title       = $this->region;
				$link        = 'http://example.phpsx.org/index.php/demo/api/id/' . $this->id;
				$description = sprintf('Population: %s, Users: %s', $this->population, $this->users);

				$item = $result->getWriter()->createItem();

				$item->setTitle($title);
				$item->setLink($link);
				$item->setDescription($description);
				$item->setAuthor('Foobar');

				return $item;
				break;

			case WriterInterface::ATOM:
				$title = $this->region;
				$id    = $this->id;
				$date  = $this->getDate();

				$entry = $result->getWriter()->createEntry();

				$entry->setTitle($title);
				$entry->setId($id);
				$entry->setUpdated($date);
				$entry->addAuthor('Foobar', Urn::buildUrn(array('user', '1')));
				$entry->addLink('http://example.phpsx.org/index.php/demo/api/id/' . $this->id, 'alternate', 'text/html');
				$entry->setContent(sprintf('Population: %s, Users: %s', $this->population, $this->users), 'text');

				return $entry;
				break;

			default:
				return parent::export($result);
				break;
		}
	}
}
