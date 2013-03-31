<?php

use PSX\Module\ViewAbstract;

class module extends ViewAbstract
{
	public function onLoad()
	{
		$this->template->set('module.tpl');
	}
}
