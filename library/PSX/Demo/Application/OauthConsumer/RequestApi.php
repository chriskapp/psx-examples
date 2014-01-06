<?php

namespace PSX\Demo\Application\OauthConsumer;

use PSX\Filter;
use PSX\Http;
use PSX\Http\GetRequest;
use PSX\Http\Handler\Curl;
use PSX\Http\PostRequest;
use PSX\Module\ViewAbstract;
use PSX\Oauth;
use PSX\Session;
use PSX\Url;

class RequestApi extends ViewAbstract
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
		$this->post     = $this->getInputPost();
		$this->session  = $this->getSession();

		$this->getTemplate()->assign('ui_status', 0x0);
	}

	public function onPost()
	{
		$consumerKey    = $this->session->get('oc_consumer_key');
		$consumerSecret = $this->session->get('oc_consumer_secret');
		$token          = $this->session->get('oc_token');
		$tokenSecret    = $this->session->get('oc_token_secret');

		$url    = $this->post->url('string', array(new Filter\Length(3, 256), new Filter\Url()));
		$method = $this->post->method('string', array(new Filter\InArray(array('HMAC-SHA1', 'PLAINTEXT'))));
		$body   = $this->post->body('string', array(new Filter\Length(0, 1024)));

		if(!$this->validate->hasError())
		{
			$url    = new Url($url);
			$body   = trim($body);
			$header = array(

				'Authorization' => $this->oauth->getAuthorizationHeader($url, $consumerKey, $consumerSecret, $token, $tokenSecret, $method, $requestMethod = 'GET'),

			);

			if(!empty($body))
			{
				$request = new PostRequest($url, $header, $body);
			}
			else
			{
				$request = new GetRequest($url, $header);
			}


			$response = $this->http->request($request);

			$this->getTemplate()->assign('request', htmlspecialchars($this->http->getRequest(), ENT_COMPAT, 'UTF-8'));
			$this->getTemplate()->assign('response', htmlspecialchars($this->http->getResponse(), ENT_COMPAT, 'UTF-8'));
		}
		else
		{
			$this->getTemplate()->assign('error', $this->validate->getError());
		}
	}

	/**
	 * @httpMethod GET
	 * @path /logout
	 */
	public function logout()
	{
		$this->session->destroy();

		$url = $this->config['psx_url'] . '/' . $this->config['psx_dispatch'] . 'demo/oauth_consumer';

		header('Location: ' . $url);
		exit;
	}
}
