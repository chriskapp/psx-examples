<?php

class callback extends PSX_Module_ViewAbstract
{
	private $http;
	private $oauth;
	private $session;
	private $validate;
	private $get;

	public function onLoad()
	{
		$this->http     = new PSX_Http(new PSX_Http_Handler_Curl());
		$this->oauth    = new PSX_Oauth($this->http);
		$this->validate = $this->getValidator();
		$this->get      = $this->getParameter();

		$this->session  = new PSX_Session('oc');
		$this->session->start();

		$this->template->set('demo/oauth_consumer/' . __CLASS__ . '.tpl');
	}

	public function onGet()
	{
		$token    = $this->get->oauth_token('string', array(new PSX_Filter_Length(4, 64)));
		$verifier = $this->get->oauth_verifier('string', array(new PSX_Filter_Length(4, 64)));

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
