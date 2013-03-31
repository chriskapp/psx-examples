<?php

namespace demo\oauth_consumer;

use PSX\Http;
use PSX\Module\ViewAbstract;
use PSX\Oauth;
use PSX\Session;

class user_authentication extends ViewAbstract
{
	protected $http;
	protected $oauth;
	protected $session;

	public function onLoad()
	{
		$this->http     = new Http();
		$this->oauth    = new Oauth($this->http);

		$this->session  = new Session('oc');
		$this->session->start();

		$this->template->set(str_replace('\\', DIRECTORY_SEPARATOR, __CLASS__) . '.tpl');
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
