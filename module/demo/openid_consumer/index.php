<?php

namespace demo\openid_consumer;

use PSX\Filter;
use PSX\Http;
use PSX\Module\ViewAbstract;
use PSX\OpenId;
use PSX\OpenId\Extension;
use PSX\Session;

class index extends ViewAbstract
{
	protected $http;
	protected $openid;
	protected $validate;
	protected $post;
	protected $session;

	public function onLoad()
	{
		$this->http     = new Http();
		$this->openid   = new OpenId($this->http, $this->config['psx_url']);
		$this->validate = $this->getValidator();
		$this->post     = $this->getBody();

		$this->session  = new Session('oi');
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
		$identity = $this->post->openid_identifier('string', array(new Filter\Length(3, 256)));
		$returnTo = $this->config['psx_url'] . '/' . $this->config['psx_dispatch'] . 'demo/openid_consumer/callback';

		if(!$this->validate->hasError())
		{
			$this->openid->initialize($identity, $returnTo);


			// add ax extension if supported by the provider
			$ax = new Extension\Ax(array(

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

	/**
	 * @httpMethod GET
	 * @path /logout
	 */
	public function logout()
	{
		$this->session->destroy();

		header('Location: ' . $this->config['psx_url'] . '/' . $this->config['psx_dispatch'] . 'demo/openid_consumer');
		exit;
	}
}
