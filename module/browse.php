<?php

use PSX\Module\ViewAbstract;

class browse extends ViewAbstract
{
	public function onLoad()
	{
		$this->template->set('browse.tpl');
	}
}
