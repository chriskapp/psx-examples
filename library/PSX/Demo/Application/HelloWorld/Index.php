<?php

namespace PSX\Demo\Application\HelloWorld;

use PSX\ModuleAbstract;

class Index extends ModuleAbstract
{
	public function onLoad()
	{
		echo 'Hello World!';
	}
}
