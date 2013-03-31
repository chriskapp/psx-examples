<?php

namespace demo\html_filter;

use PSX\Filter\Length;
use PSX\Html\Filter;
use PSX\Html\Filter\Collection\Html5Inline;
use PSX\Module\ViewAbstract;

class index extends ViewAbstract
{
	private $collection;

	public function onLoad()
	{
		$this->collection = new Html5Inline();

		$this->template->assign('collection', $this->collection);

		$this->template->set(str_replace('\\', DIRECTORY_SEPARATOR, __CLASS__) . '.tpl');
	}

	public function onPost()
	{
		$input = $this->getBody()->input('string', array(new Length(0, 1024)));

		if(!$this->getValidator()->hasError())
		{
			$filter = new Filter($input, $this->collection);
			$input  = $filter->filter();

			$this->template->assign('input', $input);
		}
		else
		{
			$this->template->assign('error', $this->getValidator()->getError());
		}
	}
}
