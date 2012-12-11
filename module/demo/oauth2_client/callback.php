<?php

namespace demo\oauth2_client;

use Exception;
use PSX_Http;
use PSX_Module_ViewAbstract;
use PSX_Oauth2_Authorization_AuthorizationCode;
use PSX_Session;
use PSX_Url;

class callback extends PSX_Module_ViewAbstract
{
	private $http;
	private $session;

	private $validate;
	private $post;

	public function onLoad()
	{
		$this->http     = new PSX_Http();
		$this->session  = new PSX_Session('o2c');
		$this->session->start();

		$this->validate = $this->getValidator();
		$this->post     = $this->getBody();

		$this->template->set(str_replace('\\', DIRECTORY_SEPARATOR, __CLASS__) . '.tpl');
	}

	public function onGet()
	{
		try
		{
			$tokenUrl     = $this->session->get('oc_token_url');
			$clientId     = $this->session->get('oc_client_id');
			$clientSecret = $this->session->get('oc_client_secret');
			$redirect     = $this->session->get('oc_redirect');

			$code = new PSX_Oauth2_Authorization_AuthorizationCode($this->http, new PSX_Url($tokenUrl));
			$code->setClientPassword($clientId, $clientSecret, PSX_Oauth2_Authorization_AuthorizationCode::AUTH_POST);

			$accessToken = $code->getAccessToken($redirect);

			$this->session->set('oc_access_token', $accessToken);
			$this->session->set('oc_authed', true);

			$this->template->assign('access_token', $accessToken->getAccessToken());
			$this->template->assign('token_type', $accessToken->getTokenType());
			$this->template->assign('expires_in', $accessToken->getExpiresIn());
			$this->template->assign('refresh_token', $accessToken->getRefreshToken());
			$this->template->assign('scope', $accessToken->getScope());

			$this->template->assign('request', $this->http->getRequest());
			$this->template->assign('response', $this->http->getResponse());
		}
		catch(Exception $e)
		{
			$this->template->assign('error', $e->getMessage());
		}
	}
}

