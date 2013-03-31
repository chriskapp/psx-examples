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

		$this->template->assign('result', $rss);
		$this->template->assign('feedUrl', $url);
		$this->template->set(str_replace('\\', DIRECTORY_SEPARATOR, __CLASS__) . '.tpl');
	}
}
