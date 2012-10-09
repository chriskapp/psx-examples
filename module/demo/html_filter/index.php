<?php

class index extends PSX_Module_ViewAbstract
{
	private $collection;

	public function onLoad()
	{
		$this->collection = new PSX_Html_Filter_Collection_Html5Basic();

		$this->template->assign('collection', $this->collection);

		$this->template->set('demo/html_filter/' . __CLASS__ . '.tpl');
	}

	public function onPost()
	{
		$input = $this->getBody()->input('string', array(new PSX_Filter_Length(0, 1024)));

		if(!$this->getValidator()->hasError())
		{
			$filter = new PSX_Html_Filter($input, $this->collection);
			$input  = $filter->filter();

			$this->template->assign('input', $input);
		}
		else
		{
			$this->template->assign('error', $this->getValidator()->getError());
		}
	}
}
