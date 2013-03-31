<?php

namespace demo\hello_world;

use PSX\ModuleAbstract;

class index extends ModuleAbstract
{
	public function onLoad()
	{
		echo 'Hello World!';
	}
}
