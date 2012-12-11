<?php

namespace demo\template;

use PSX_Module_ViewAbstract;

class index extends PSX_Module_ViewAbstract
{
	public function onLoad()
	{
		// by default we use the PSX_Template class but you are free to create
		// a wrapper for any template engine you like i.e. Smarty or Twig

		// The default template engine creates the assigned variables
		// also in the template scope so that you can access them with
		// i.e. $foo. Intern the data is stored in the property $data
		// so you can also acces the value with $this->data['foo']

		$this->template->assign('foo', 'bar');
		$this->template->assign('jodah', 'power');

		$this->template->set(str_replace('\\', DIRECTORY_SEPARATOR, __CLASS__) . '.tpl');
	}
}