<?php

namespace demo\rss_feed;

use PSX_Module_ViewAbstract;
use PSX_Rss;

class index extends PSX_Module_ViewAbstract
{
	public function onLoad()
	{
		$url = 'http://test.phpsx.org/index.php/rss/feed';
		$rss = PSX_Rss::request($url);

		$this->template->assign('result', $rss);
		$this->template->assign('feedUrl', $url);
		$this->template->set(str_replace('\\', DIRECTORY_SEPARATOR, __CLASS__) . '.tpl');
	}
}
