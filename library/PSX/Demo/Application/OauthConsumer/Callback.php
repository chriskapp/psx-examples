<?php

namespace PSX\Demo\Application\OauthConsumer;

use PSX\Filter;
use PSX\Http;
use PSX\Http\Handler\Curl;
use PSX\Module\ViewAbstract;
use PSX\Oauth;
use PSX\Session;

class Callback extends ViewAbstract
{
	protected $http;
	protected $oauth;
	protected $session;
	protected $validate;
	protected $get;

	public function onLoad()
	{
		$this->getContainer()->setParameter('session.name', 'oc');

		$this->http     = $this->getHttp();
		$this->oauth    = new Oauth($this->http);
		$this->validate = $this->getValidate();
		$this->get      = $this->getInputGet();
		$this->session  = $this->getSession();
	}

	public function onGet()
	{
		$token    = $this->get->oauth_token('string', array(new Filter\Length(4, 64)));
		$verifier = $this->get->oauth_verifier('string', array(new Filter\Length(4, 64)));

		if($token === false || $this->session->get('oc_token') != $token)
		{
			$this->validate->addError('oauth_token', 'Invalid token');
		}

		if(!$this->validate->hasError())
		{
			$this->session->set('oc_verifier', $verifier);

			$this->getTemplate()->assign('token', $token);
			$this->getTemplate()->assign('verifier', $verifier);
		}
		else
		{
			$this->getTemplate()->assign('error', $this->validate->getError());
		}

		$this->getTemplate()->assign('ui_status', 0x0);
	}

	public function onPost()
	{
		$this->getTemplate()->assign('ui_status', 0x1);
	}
}
