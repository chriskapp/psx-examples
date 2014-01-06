<?php

namespace PSX\Demo\Application\OauthConsumer;

use PSX\Filter;
use PSX\Http;
use PSX\Module\ViewAbstract;
use PSX\Oauth;
use PSX\Session;
use PSX\Url;

class Index extends ViewAbstract
{
	protected $http;
	protected $oauth;
	protected $session;
	protected $post;

	public function onLoad()
	{
		$this->getContainer()->setParameter('session.name', 'oc');

		$this->http     = $this->getHttp();
		$this->oauth    = new Oauth($this->http);
		$this->validate = $this->getValidate();
		$this->post     = $this->getInputPost();
		$this->session  = $this->getSession();
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
		$this->getTemplate()->assign('oc_consumer_key', $this->session->get('oc_consumer_key'));
		$this->getTemplate()->assign('oc_consumer_secret', $this->session->get('oc_consumer_secret'));

		$this->getTemplate()->assign('ui_status', 0x0);
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

			$this->getTemplate()->assign('request', $this->http->getRequest());
			$this->getTemplate()->assign('response', $this->http->getResponse());

			$token       = $response->getToken();
			$tokenSecret = $response->getTokenSecret();

			if(!empty($token) && !empty($tokenSecret))
			{
				$this->session->set('oc_token', $token);
				$this->session->set('oc_token_secret', $tokenSecret);

				$this->getTemplate()->assign('token', $token);
				$this->getTemplate()->assign('token_secret', $tokenSecret);
			}
			else
			{
				$this->getTemplate()->assign('token', '');
				$this->getTemplate()->assign('token_secret', '');
			}
		}
		else
		{
			$this->getTemplate()->assign('error', $this->validate->getError());
		}

		$this->getTemplate()->assign('ui_status', 0x1);
	}
}
