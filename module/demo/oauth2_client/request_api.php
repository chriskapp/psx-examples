<?php

namespace demo\oauth2_client;

use PSX_Exception;
use PSX_Filter_Length;
use PSX_Filter_Url;
use PSX_Http;
use PSX_Http_GetRequest;
use PSX_Http_PostRequest;
use PSX_Module_ViewAbstract;
use PSX_Oauth2;
use PSX_Session;
use PSX_Url;

class request_api extends PSX_Module_ViewAbstract
{
	private $http;
	private $oauth;
	private $session;

	private $validate;
	private $post;

	public function onLoad()
	{
		$this->http     = new PSX_Http();
		$this->oauth    = new PSX_Oauth2($this->http);
		$this->session  = new PSX_Session('o2c');
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
		$accessToken = $this->session->get('oc_access_token');

		if(!($accessToken instanceof PSX_Oauth2_AccessToken))
		{
			throw new PSX_Exception('Access token is not available');
		}

		$url  = $this->post->url('string', array(new PSX_Filter_Length(3, 256), new PSX_Filter_Url()));
		$body = $this->post->body('string', array(new PSX_Filter_Length(0, 1024)));

		if(!$this->validate->hasError())
		{
			$url    = new PSX_Url($url);
			$body   = trim($body);
			$header = array(

				'Authorization' => $this->oauth->getAuthorizationHeader($accessToken),

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

		$url = $this->config['psx_url'] . '/' . $this->config['psx_dispatch'] . 'demo/oauth2_client';

		header('Location: ' . $url);
		exit;
	}
}

