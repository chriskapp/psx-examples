<?php

class index extends PSX_Module_ViewAbstract
{
	public function onLoad()
	{
		$this->template->set('demo/index.tpl');
	}
}