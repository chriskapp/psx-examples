<?php

namespace demo\oauth_consumer;

use PSX\Filter;
use PSX\Http;
use PSX\Module\ViewAbstract;
use PSX\Oauth;
use PSX\Session;
use PSX\Url;

class index extends ViewAbstract
{
	protected $http;
	protected $oauth;
	protected $session;
	protected $post;

	public function onLoad()
	{
		$this->http     = new Http();
		$this->oauth    = new Oauth($this->http);
		$this->validate = $this->getValidator();
		$this->post     = $this->getBody();

		$this->session  = new Session('oc');
		$this->session->start();

		$this->template->set(str_replace('\\', DIRECTORY_SEPARATOR, __CLASS__) . '.tpl');
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
		$url            = $this->post->url('string', array(new Filter\Length(3, 256), new Filter\Url()));
		$consumerKey    = $this->post->consumer_key('string', array(new Filter\Length(4, 128)));
		$consumerSecret = $this->post->consumer_secret('string', array(new Filter\Length(4, 128)));
		$method         = $this->post->method('string', array(new Filter\InArray(array('HMAC-SHA1', 'PLAINTEXT'))));
		$callback       = $this->post->callback('string', array(new Filter\Length(3, 256), new Filter\Url()));

		if(!$this->validate->hasError())
		{
			$this->session->set('oc_consumer_key', $consumerKey);
			$this->session->set('oc_consumer_secret', $consumerSecret);

			$url = new Url($url);

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
