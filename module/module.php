<?php

class module extends PSX_Module_ViewAbstract
{
	public function onLoad()
	{
		$this->template->set('module.tpl');
	}
}
