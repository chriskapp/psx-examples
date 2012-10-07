<?php

class Example_Record extends PSX_Data_Record_TableAbstract
{
	public $id;
	public $place;
	public $region;
	public $population;
	public $users;
	public $world_users;
	public $datetime;

	protected $_config;

	public function __construct(PSX_Sql_TableInterface $table, PSX_Config $config)
	{
		parent::__construct($table);
		
		$this->_config = $config;
	}

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

	public function export(PSX_Data_WriterResult $result)
	{
		switch($result->getType())
		{
			case PSX_Data_WriterInterface::JSON:
			case PSX_Data_WriterInterface::XML:

				return $this->getFields();

				break;

			case PSX_Data_WriterInterface::RSS:

				$title       = $this->region;
				$link        = $this->_config['psx_url'] . '/index.php/demo/api/id/' . $this->id;
				$description = sprintf('Population: %s, Users: %s', $this->population, $this->users);

				$item = $result->getWriter()->createItem();

				$item->setTitle($title);
				$item->setLink($link);
				$item->setDescription($description);
				$item->setAuthor('Foobar');

				return $item;

				break;

			case PSX_Data_WriterInterface::ATOM:

				$title = $this->region;
				$id    = $this->id;
				$date  = $this->getDate();

				$entry = $result->getWriter()->createEntry();

				$entry->setTitle($title);
				$entry->setId($id);
				$entry->setUpdated($date);
				$entry->addAuthor('Foobar', $this->_config->getUrn('user', '1'));
				$entry->addLink($this->_config['psx_url'] . '/index.php/demo/api/id/' . $this->id, 'alternate', 'text/html');
				$entry->setContent(sprintf('Population: %s, Users: %s', $this->population, $this->users), 'text');

				return $entry;

				break;

			default:

				throw new PSX_Data_Exception('Writer is not supported');

				break;
		}
	}
}
