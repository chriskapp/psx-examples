<?php

namespace demo\atom_feed;

use PSX\Atom;
use PSX\Module\ViewAbstract;

class index extends ViewAbstract
{
	public function onLoad()
	{
		$url  = 'http://test.phpsx.org/index.php/atom/feed';
		$atom = Atom::request($url);

		$this->template->assign('result', $atom);
		$this->template->assign('feedUrl', $url);
		$this->template->set(str_replace('\\', DIRECTORY_SEPARATOR, __CLASS__) . '.tpl');
	}
}