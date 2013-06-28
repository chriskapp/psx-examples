<?php

namespace demo\html_filter;

use PSX\Filter\Length;
use PSX\Html\Filter;
use PSX\Html\Filter\Collection\Html5Text;
use PSX\Module\ViewAbstract;

class index extends ViewAbstract
{
	private $collection;

	public function onLoad()
	{
		$this->collection = new Html5Text();

		$this->getTemplate()->assign('collection', $this->collection);
	}

	public function onPost()
	{
		$input = $this->getBody()->input('string', array(new Length(0, 1024)));

		if(!$this->getValidate()->hasError())
		{
			$filter = new Filter($input, $this->collection);
			$input  = $filter->filter();

			$this->getTemplate()->assign('input', $input);
		}
		else
		{
			$this->getTemplate()->assign('error', $this->getValidate()->getError());
		}
	}
}
