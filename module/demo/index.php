<?php

namespace demo;

use PSX\Module\ViewAbstract;

class index extends ViewAbstract
{
	public function onLoad()
	{
		$this->template->set('demo/index.tpl');
	}
}