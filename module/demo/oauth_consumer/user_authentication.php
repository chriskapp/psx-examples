<?php

class user_authentication extends PSX_Module_ViewAbstract
{
	private $http;
	private $oauth;
	private $session;

	public function onLoad()
	{
		$this->http     = new PSX_Http(new PSX_Http_Handler_Curl());
		$this->oauth    = new PSX_Oauth($this->http);

		$this->session  = new PSX_Session('oc');
		$this->session->start();

		$this->template->set('demo/oauth_consumer/' . __CLASS__ . '.tpl');
	}

	public function onGet()
	{
		$token = $this->session->get('oc_token');

		if($token !== false)
		{
			$this->template->assign('oc_token', $token);
			$this->template->assign('ui_status', 0x0);
		}
		else
		{
			$this->template->assign('ui_status', 0x1);
			$this->template->assign('error', array('You dont have received an request token'));
		}
	}
}
