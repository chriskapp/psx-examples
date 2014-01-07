<?php

namespace PSX\Demo\Application\OauthConsumer;

use PSX\Http;
use PSX\Module\ViewAbstract;
use PSX\Oauth;
use PSX\Session;

class Authentication extends ViewAbstract
{
	protected $http;
	protected $oauth;
	protected $session;

	public function onLoad()
	{
		$this->getContainer()->setParameter('session.name', 'oc');

		$this->http     = $this->getHttp();
		$this->oauth    = new Oauth($this->http);
		$this->session  = $this->getSession();
	}

	public function onGet()
	{
		$token = $this->session->get('oc_token');

		if($token !== false)
		{
			$this->getTemplate()->assign('oc_token', $token);
			$this->getTemplate()->assign('ui_status', 0x0);
		}
		else
		{
			$this->getTemplate()->assign('ui_status', 0x1);
			$this->getTemplate()->assign('error', array('You dont have received an request token'));
		}
	}
}
