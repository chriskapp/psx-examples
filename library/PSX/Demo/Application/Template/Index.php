<?php

namespace PSX\Demo\Application\Template;

use PSX\Module\ViewAbstract;

class Index extends ViewAbstract
{
	public function onLoad()
	{
		// by default we use the PSX\Template class but you are free to create
		// a wrapper for any template engine you like i.e. Smarty or Twig

		// The default template engine creates the assigned variables also in 
		// the template scope so that you can access them with i.e. $foo

		$this->getTemplate()->assign('foo', 'bar');
		$this->getTemplate()->assign('jodah', 'power');
	}
}