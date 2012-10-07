<?php

class browse extends PSX_Module_ViewAbstract
{
	public function onLoad()
	{
		$this->template->set('browse.tpl');
	}
}
