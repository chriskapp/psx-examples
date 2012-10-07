<?php

class index extends PSX_Module_ViewAbstract
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

		$this->template->assign('oc_client_id', $this->session->get('oc_client_id'));
		$this->template->assign('oc_client_secret', $this->session->get('oc_client_secret'));

		$this->template->set('demo/oauth2_client/' . __CLASS__ . '.tpl');
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
		$authUrl      = $this->post->auth_url('string', array(new PSX_Filter_Length(3, 256), new PSX_Filter_Url()));
		$tokenUrl     = $this->post->token_url('string', array(new PSX_Filter_Length(3, 256), new PSX_Filter_Url()));
		$clientId     = $this->post->consumer_key('string', array(new PSX_Filter_Length(4, 128)));
		$clientSecret = $this->post->consumer_secret('string', array(new PSX_Filter_Length(4, 128)));
		$scope        = $this->post->scope('string', array(new PSX_Filter_Length(0, 256)));
		$redirect     = $this->post->redirect('string', array(new PSX_Filter_Length(3, 256), new PSX_Filter_Url()));

		if(!$this->validate->hasError())
		{
			$this->session->set('oc_token_url', $tokenUrl);
			$this->session->set('oc_client_id', $clientId);
			$this->session->set('oc_client_secret', $clientSecret);
			$this->session->set('oc_scope', $scope);
			$this->session->set('oc_redirect', $redirect);

			$authUrl = new PSX_Url($authUrl);

			if(empty($scope))
			{
				$scope = null;
			}

			PSX_Oauth2_Authorization_AuthorizationCode::redirect($authUrl, $clientId, $redirect, $scope);
		}
		else
		{
			$this->template->assign('error', $this->validate->getError());
		}
	}
}

