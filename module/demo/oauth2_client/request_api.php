<?php

namespace demo\oauth2_client;

use PSX\Exception;
use PSX\Filter;
use PSX\Http;
use PSX\Http\GetRequest;
use PSX\Http\PostRequest;
use PSX\Module\ViewAbstract;
use PSX\Oauth2;
use PSX\Oauth2\AccessToken;
use PSX\Session;
use PSX\Url;

class request_api extends ViewAbstract
{
	protected $http;
	protected $oauth;
	protected $session;
	protected $validate;
	protected $post;

	public function onLoad()
	{
		$this->http     = new Http();
		$this->oauth    = new Oauth2($this->http);
		$this->session  = new Session('o2c');
		$this->session->start();

		$this->validate = $this->getValidator();
		$this->post     = $this->getBody();

		$this->template->set(str_replace('\\', DIRECTORY_SEPARATOR, __CLASS__) . '.tpl');
	}

	public function onGet()
	{
	}

	public function onPost()
	{
		$token = $this->session->get('oc_access_token');

		if(empty($token))
		{
			throw new Exception('Access token is not available');
		}

		$accessToken = new AccessToken();
		$accessToken->setAccessToken($token['access_token']);
		$accessToken->setTokenType($token['token_type']);
		$accessToken->setExpiresIn($token['expires_in']);
		$accessToken->setRefreshToken($token['refresh_token']);
		$accessToken->setScope($token['scope']);

		$url  = $this->post->url('string', array(new Filter\Length(3, 256), new Filter\Url()));
		$body = $this->post->body('string', array(new Filter\Length(0, 1024)));

		if(!$this->validate->hasError())
		{
			$url    = new Url($url);
			$body   = trim($body);
			$header = array(

				'Authorization' => $this->oauth->getAuthorizationHeader($accessToken),

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

			$this->template->assign('request', htmlspecialchars($this->http->getRequest(), ENT_COMPAT, 'UTF-8'));
			$this->template->assign('response', htmlspecialchars($this->http->getResponse(), ENT_COMPAT, 'UTF-8'));
		}
		else
		{
			$this->template->assign('error', $this->validate->getError());
		}
	}

	/**
	 * @httpMethod GET
	 * @path /logout
	 */
	public function logout()
	{
		$this->session->destroy();

		$url = $this->config['psx_url'] . '/' . $this->config['psx_dispatch'] . 'demo/oauth2_client';

		header('Location: ' . $url);
		exit;
	}
}

