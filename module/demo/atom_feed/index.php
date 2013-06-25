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

		$this->getTemplate()->assign('result', $atom);
		$this->getTemplate()->assign('feedUrl', $url);
	}
}