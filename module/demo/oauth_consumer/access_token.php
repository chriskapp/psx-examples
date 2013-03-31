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
		$this->http     = new Http();
		$this->oauth    = new Oauth($this->http);
		$this->validate = $this->getValidator();
		$this->post     = $this->getBody();

		$this->session  = new Session('oc');
		$this->session->start();

		$this->template->set(str_replace('\\', DIRECTORY_SEPARATOR, __CLASS__) . '.tpl');
	}

	public function onGet()
	{
		$this->template->assign('oc_consumer_key', $this->session->get('oc_consumer_key'));
		$this->template->assign('oc_consumer_secret', $this->session->get('oc_consumer_secret'));
		$this->template->assign('oc_token', $this->session->get('oc_token'));
		$this->template->assign('oc_token_secret', $this->session->get('oc_token_secret'));
		$this->template->assign('oc_verifier', $this->session->get('oc_verifier'));

		$this->template->assign('ui_status', 0x0);
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

			$this->template->assign('request', $this->http->getRequest());
			$this->template->assign('response', $this->http->getResponse());

			$token       = $response->getToken();
			$tokenSecret = $response->getTokenSecret();

			if(!empty($token) && !empty($tokenSecret))
			{
				$this->session->set('oc_token', $token);
				$this->session->set('oc_token_secret', $tokenSecret);
				$this->session->set('oc_authed', true);

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
