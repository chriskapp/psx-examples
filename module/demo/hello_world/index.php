<?php

namespace demo\hello_world;

use PSX_ModuleAbstract;

class index extends PSX_ModuleAbstract
{
	public function onLoad()
	{
		echo 'Hello World!';
	}
}
