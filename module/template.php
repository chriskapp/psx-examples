<?php

use PSX\Module\ViewAbstract;

class template extends ViewAbstract
{
	public function onLoad()
	{
		$this->template->set('template.tpl');
	}
}
