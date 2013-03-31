<?php

namespace demo\oauth_consumer;

use PSX\Filter;
use PSX\Http;
use PSX\Http\Handler\Curl;
use PSX\Module\ViewAbstract;
use PSX\Oauth;
use PSX\Session;

class callback extends ViewAbstract
{
	protected $http;
	protected $oauth;
	protected $session;
	protected $validate;
	protected $get;

	public function onLoad()
	{
		$this->http     = new Http();
		$this->oauth    = new Oauth($this->http);
		$this->validate = $this->getValidator();
		$this->get      = $this->getParameter();

		$this->session  = new Session('oc');
		$this->session->start();

		$this->template->set(str_replace('\\', DIRECTORY_SEPARATOR, __CLASS__) . '.tpl');
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

			$this->template->assign('token', $token);
			$this->template->assign('verifier', $verifier);
		}
		else
		{
			$this->template->assign('error', $this->validate->getError());
		}

		$this->template->assign('ui_status', 0x0);
	}

	public function onPost()
	{
		$this->template->assign('ui_status', 0x1);
	}
}
