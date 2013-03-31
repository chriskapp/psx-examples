<?php

namespace demo\oauth2_client;

use PSX\Filter;
use PSX\Http;
use PSX\Module\ViewAbstract;
use PSX\Oauth2\Authorization\AuthorizationCode;
use PSX\Session;
use PSX\Url;

class index extends ViewAbstract
{
	protected $http;
	protected $session;
	protected $validate;
	protected $post;

	public function onLoad()
	{
		$this->http     = new Http();
		$this->session  = new Session('o2c');
		$this->session->start();

		$this->validate = $this->getValidator();
		$this->post     = $this->getBody();

		$this->template->assign('oc_client_id', $this->session->get('oc_client_id'));
		$this->template->assign('oc_client_secret', $this->session->get('oc_client_secret'));

		$this->template->set(str_replace('\\', DIRECTORY_SEPARATOR, __CLASS__) . '.tpl');
	}

	public function onGet()
	{
		if($this->session->get('oc_authed') == true)
		{
			$url = $this->config['psx_url'] . '/' . $this->config['psx_dispatch'] . 'demo/oauth2_client/request_api';

			header('Location: ' . $url);
			exit;
		}
	}

	public function onPost()
	{
		$authUrl      = $this->post->auth_url('string', array(new Filter\Length(3, 256), new Filter\Url()));
		$tokenUrl     = $this->post->token_url('string', array(new Filter\Length(3, 256), new Filter\Url()));
		$clientId     = $this->post->consumer_key('string', array(new Filter\Length(4, 128)));
		$clientSecret = $this->post->consumer_secret('string', array(new Filter\Length(4, 128)));
		$scope        = $this->post->scope('string', array(new Filter\Length(0, 256)));
		$redirect     = $this->post->redirect('string', array(new Filter\Length(3, 256), new Filter\Url()));

		if(!$this->validate->hasError())
		{
			$this->session->set('oc_token_url', $tokenUrl);
			$this->session->set('oc_client_id', $clientId);
			$this->session->set('oc_client_secret', $clientSecret);
			$this->session->set('oc_scope', $scope);
			$this->session->set('oc_redirect', $redirect);

			$authUrl = new Url($authUrl);

			if(empty($scope))
			{
				$scope = null;
			}

			AuthorizationCode::redirect($authUrl, $clientId, $redirect, $scope);
		}
		else
		{
			$this->template->assign('error', $this->validate->getError());
		}
	}
}

