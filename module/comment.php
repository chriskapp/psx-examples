<?php

class comment extends PSX_ModuleAbstract
{
	public function onLoad()
	{
		$validate  = new PSX_Validate();
		$get       = new PSX_Get($validate);
		$module    = $get->module('string', array(new PSX_Filter_Regexp('/^([A-Za-z0-9_]{3,32})$/')));

		echo 'Loading comments for module: ' . $module;
	}
}
