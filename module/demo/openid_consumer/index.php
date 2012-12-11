<?php

namespace demo\openid_consumer;

use PSX_Filter_Length;
use PSX_Http;
use PSX_Http_Handler_Curl;
use PSX_Module_ViewAbstract;
use PSX_OpenId;
use PSX_OpenId_Extension_Ax;
use PSX_Session;

class index extends PSX_Module_ViewAbstract
{
	private $http;
	private $openid;
	private $validate;
	private $post;
	private $session;

	public function onLoad()
	{
		$this->http     = new PSX_Http(new PSX_Http_Handler_Curl());
		$this->openid   = new PSX_OpenId($this->http, $this->config['psx_url']);
		$this->validate = $this->getValidator();
		$this->post     = $this->getBody();

		$this->session  = new PSX_Session('oi');
		$this->session->start();

		if($this->session->get('oi_authed') == true)
		{
			$this->template->assign('id', $this->session->get('oi_id'));
			$this->template->assign('name', $this->session->get('oi_name'));
			$this->template->assign('email', $this->session->get('oi_email'));
		}

		$this->template->assign('authed', $this->session->get('oi_authed'));

		$this->template->set(str_replace('\\', DIRECTORY_SEPARATOR, __CLASS__) . '.tpl');
	}

	public function onPost()
	{
		$identity = $this->post->openid_identifier('string', array(new PSX_Filter_Length(3, 256)));
		$returnTo = $this->config['psx_url'] . '/' . $this->config['psx_dispatch'] . 'demo/openid_consumer/callback';

		if(!$this->validate->hasError())
		{
			$this->openid->initialize($identity, $returnTo);


			// add ax extension if supported by the provider
			$ax = new PSX_OpenId_Extension_Ax(array(

				'fullname'  => 'http://axschema.org/namePerson',
				'firstname' => 'http://axschema.org/namePerson/first',
				'lastname'  => 'http://axschema.org/namePerson/last',
				'email'     => 'http://axschema.org/contact/email',

			));

			if($this->openid->hasExtension($ax->getNs()))
			{
				$this->openid->add($ax);
			}


			// redirect the user
			$this->openid->redirect();
		}
		else
		{
			$this->template->assign('error', $this->validate->getError());
		}
	}

	public function logout()
	{
		$this->session->destroy();

		header('Location: ' . $this->config['psx_url'] . '/' . $this->config['psx_dispatch'] . 'demo/openid_consumer');
		exit;
	}
}
