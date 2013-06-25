<?php

namespace demo\rss_feed;

use PSX\Module\ViewAbstract;
use PSX\Rss;

class index extends ViewAbstract
{
	public function onLoad()
	{
		$url = 'http://test.phpsx.org/index.php/rss/feed';
		$rss = Rss::request($url);

		$this->getTemplate()->assign('result', $rss);
		$this->getTemplate()->assign('feedUrl', $url);
	}
}
