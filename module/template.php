<?php

class template extends PSX_Module_ViewAbstract
{
	public function onLoad()
	{
		$this->template->set('template.tpl');
	}
}
