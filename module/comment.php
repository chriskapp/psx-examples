<?php

use PSX\ModuleAbstract;
use PSX\Validate;
use PSX\Input;
use PSX\Filter;

class comment extends ModuleAbstract
{
	public function onLoad()
	{
		$validate  = new Validate();
		$get       = new Input\Get($validate);
		$module    = $get->module('string', array(new Filter\Regexp('/^([A-Za-z0-9_]{3,32})$/')));

		echo 'Loading comments for module: ' . $module;
	}
}
