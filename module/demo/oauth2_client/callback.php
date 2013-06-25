<?php

namespace demo\oauth2_client;

use Exception;
use PSX\Http;
use PSX\Module\ViewAbstract;
use PSX\Oauth2\AccessToken;
use PSX\Oauth2\Authorization\AuthorizationCode;
use PSX\Session;
use PSX\Url;

class callback extends ViewAbstract
{
	protected $http;
	protected $session;
	protected $validate;
	protected $post;

	public function onLoad()
	{
		$this->getContainer()->setParameter('session.name', 'o2c');

		$this->http     = $this->getHttp();
		$this->session  = $this->getSession();
		$this->validate = $this->getValidate();
		$this->post     = $this->getBody();
	}

	public function onGet()
	{
		try
		{
			$tokenUrl     = $this->session->get('oc_token_url');
			$clientId     = $this->session->get('oc_client_id');
			$clientSecret = $this->session->get('oc_client_secret');
			$redirect     = $this->session->get('oc_redirect');

			$code = new AuthorizationCode($this->http, new Url($tokenUrl));
			$code->setClientPassword($clientId, $clientSecret, AuthorizationCode::AUTH_POST);

			$accessToken = $code->getAccessToken($redirect);

			$this->session->set('oc_access_token', $accessToken->getFields());
			$this->session->set('oc_authed', true);

			$this->template->assign('access_token', $accessToken->getAccessToken());
			$this->template->assign('token_type', $accessToken->getTokenType());
			$this->template->assign('expires_in', $accessToken->getExpiresIn());
			$this->template->assign('refresh_token', $accessToken->getRefreshToken());
			$this->template->assign('scope', $accessToken->getScope());

			$this->template->assign('request', $this->http->getRequest());
			$this->template->assign('response', $this->http->getResponse());
		}
		catch(\Exception $e)
		{
			$this->template->assign('error', $e->getMessage());
		}
	}
}

