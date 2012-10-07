<?php

class request_api extends PSX_Module_ViewAbstract
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
		$this->template->assign('ui_status', 0x0);
	}

	public function onPost()
	{
		$consumerKey    = $this->session->get('oc_consumer_key');
		$consumerSecret = $this->session->get('oc_consumer_secret');
		$token          = $this->session->get('oc_token');
		$tokenSecret    = $this->session->get('oc_token_secret');

		$url    = $this->post->url('string', array(new PSX_Filter_Length(3, 256), new PSX_Filter_Url()));
		$method = $this->post->method('string', array(new PSX_Filter_InArray(array('HMAC-SHA1', 'PLAINTEXT'))));
		$body   = $this->post->body('string', array(new PSX_Filter_Length(0, 1024)));

		if(!$this->validate->hasError())
		{
			$url    = new PSX_Url($url);
			$body   = trim($body);
			$header = array(

				'Authorization' => $this->oauth->getAuthorizationHeader($url, $consumerKey, $consumerSecret, $token, $tokenSecret, $method, $requestMethod = 'GET'),

			);

			if(!empty($body))
			{
				$request = new PSX_Http_PostRequest($url, $header, $body);
			}
			else
			{
				$request = new PSX_Http_GetRequest($url, $header);
			}


			$response = $this->http->request($request);

			$this->template->assign('request', htmlspecialchars($this->http->getRequest(), ENT_COMPAT, 'UTF-8'));
			$this->template->assign('response', htmlspecialchars($this->http->getResponse(), ENT_COMPAT, 'UTF-8'));
		}
		else
		{
			$this->template->assign('error', $this->validate->getError());
		}
	}

	public function logout()
	{
		$this->session->destroy();

		$url = $this->config['psx_url'] . '/' . $this->config['psx_dispatch'] . 'demo/oauth_consumer';

		header('Location: ' . $url);
		exit;
	}
}
