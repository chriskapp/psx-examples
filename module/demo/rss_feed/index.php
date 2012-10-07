<?php

class index extends PSX_Module_ViewAbstract
{
	public function onLoad()
	{
		$url = 'http://test.phpsx.org/index.php/rss/feed';
		$rss = PSX_Rss::request($url);

		$this->template->assign('result', $rss);
		$this->template->assign('feedUrl', $url);
		$this->template->set('demo/rss_feed/' . __CLASS__ . '.tpl');
	}
}
