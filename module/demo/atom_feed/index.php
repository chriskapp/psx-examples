<?php

namespace demo\atom_feed;

use PSX_Atom;
use PSX_Module_ViewAbstract;

class index extends PSX_Module_ViewAbstract
{
	public function onLoad()
	{
		$url  = 'http://test.phpsx.org/index.php/atom/feed';
		$atom = PSX_Atom::request($url);

		$this->template->assign('result', $atom);
		$this->template->assign('feedUrl', $url);
		$this->template->set(str_replace('\\', DIRECTORY_SEPARATOR, __CLASS__) . '.tpl');
	}
}