<?php

namespace demo\oauth_consumer;

use PSX\Filter;
use PSX\Http;
use PSX\Http\Handler\Curl;
use PSX\Module\ViewAbstract;
use PSX\Oauth;
use PSX\Session;
use PSX\Url;

class access_token extends ViewAbstract
{
	protected $http;
	protected $oauth;
	protected $session;
	protected $validate;
	protected $post;

	public function onLoad()
	{
		$this->getContainer()->setParameter('session.name', 'oc');

		$this->http     = $this->getHttp();
		$this->oauth    = new Oauth($this->http);
		$this->validate = $this->getValidate();
		$this->post     = $this->getBody();
		$this->session  = $this->getSession();
	}

	public function onGet()
	{
		$this->getTemplate()->assign('oc_consumer_key', $this->session->get('oc_consumer_key'));
		$this->getTemplate()->assign('oc_consumer_secret', $this->session->get('oc_consumer_secret'));
		$this->getTemplate()->assign('oc_token', $this->session->get('oc_token'));
		$this->getTemplate()->assign('oc_token_secret', $this->session->get('oc_token_secret'));
		$this->getTemplate()->assign('oc_verifier', $this->session->get('oc_verifier'));

		$this->getTemplate()->assign('ui_status', 0x0);
	}

	public function onPost()
	{
		$consumerKey    = $this->session->get('oc_consumer_key');
		$consumerSecret = $this->session->get('oc_consumer_secret');
		$token          = $this->session->get('oc_token');
		$tokenSecret    = $this->session->get('oc_token_secret');
		$verifier       = $this->session->get('oc_verifier');

		$url = $this->post->url('string', array(new Filter\Length(3, 256), new Filter\Url()));

		if(!$this->validate->hasError())
		{
			$url = new Url($url);

			$response = $this->oauth->accessToken($url, $consumerKey, $consumerSecret, $token, $tokenSecret, $verifier);

			$this->getTemplate()->assign('request', $this->http->getRequest());
			$this->getTemplate()->assign('response', $this->http->getResponse());

			$token       = $response->getToken();
			$tokenSecret = $response->getTokenSecret();

			if(!empty($token) && !empty($tokenSecret))
			{
				$this->session->set('oc_token', $token);
				$this->session->set('oc_token_secret', $tokenSecret);
				$this->session->set('oc_authed', true);

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
