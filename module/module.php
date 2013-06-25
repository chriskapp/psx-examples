<?php

use PSX\Module\ViewAbstract;

class module extends ViewAbstract
{
	public function onLoad()
	{
		$this->getTemplate()->set('module.tpl');
	}
}
