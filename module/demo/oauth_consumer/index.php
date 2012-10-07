<?php

class index extends PSX_Module_ViewAbstract
{
	private $http;
	private $oauth;
	private $session;
	private $validate;
	private $post;

	public function onLoad()
	{
		$this->http     = new PSX_Http(new PSX_Http_Handler_Curl());
		$this->oauth    = new PSX_Oauth($this->http);
		$this->validate = $this->getValidator();
		$this->post     = $this->getBody();

		$this->session  = new PSX_Session('oc');
		$this->session->start();

		$this->template->set('demo/oauth_consumer/' . __CLASS__ . '.tpl');
	}

	public function __index()
	{
		if($this->session->get('oc_authed') == true)
		{
			$url = $this->config['psx_url'] . '/' . $this->config['psx_dispatch'] . 'demo/oauth_consumer/request_api';

			header('Location: ' . $url);
			exit;
		}
	}

	public function onGet()
	{
		$this->template->assign('oc_consumer_key', $this->session->get('oc_consumer_key'));
		$this->template->assign('oc_consumer_secret', $this->session->get('oc_consumer_secret'));

		$this->template->assign('ui_status', 0x0);
	}

	public function onPost()
	{
		$url            = $this->post->url('string', array(new PSX_Filter_Length(3, 256), new PSX_Filter_Url()));
		$consumerKey    = $this->post->consumer_key('string', array(new PSX_Filter_Length(4, 128)));
		$consumerSecret = $this->post->consumer_secret('string', array(new PSX_Filter_Length(4, 128)));
		$method         = $this->post->method('string', array(new PSX_Filter_InArray(array('HMAC-SHA1', 'PLAINTEXT'))));
		$callback       = $this->post->callback('string', array(new PSX_Filter_Length(3, 256), new PSX_Filter_Url()));

		if(!$this->validate->hasError())
		{
			$this->session->set('oc_consumer_key', $consumerKey);
			$this->session->set('oc_consumer_secret', $consumerSecret);

			$url = new PSX_Url($url);

			$response = $this->oauth->requestToken($url, $consumerKey, $consumerSecret, $method, $callback);

			$this->template->assign('request', $this->http->getRequest());
			$this->template->assign('response', $this->http->getResponse());

			$token       = $response->getToken();
			$tokenSecret = $response->getTokenSecret();

			if(!empty($token) && !empty($tokenSecret))
			{
				$this->session->set('oc_token', $token);
				$this->session->set('oc_token_secret', $tokenSecret);

				$this->template->assign('token', $token);
				$this->template->assign('token_secret', $tokenSecret);
			}
			else
			{
				$this->template->assign('token', '');
				$this->template->assign('token_secret', '');
			}
		}
		else
		{
			$this->template->assign('error', $this->validate->getError());
		}

		$this->template->assign('ui_status', 0x1);
	}
}
