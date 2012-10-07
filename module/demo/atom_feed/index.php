<?php

class index extends PSX_Module_ViewAbstract
{
	public function onLoad()
	{
		$url  = 'http://test.phpsx.org/index.php/atom/feed';
		$atom = PSX_Atom::request($url);

		$this->template->assign('result', $atom);
		$this->template->assign('feedUrl', $url);
		$this->template->set('demo/atom_feed/' . __CLASS__ . '.tpl');
	}
}