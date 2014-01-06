<?php

namespace PSX\Demo\Application\OpenidConsumer;

use PSX\Filter;
use PSX\Http;
use PSX\Module\ViewAbstract;
use PSX\OpenId;
use PSX\OpenId\Extension;
use PSX\Session;

class Index extends ViewAbstract
{
	protected $http;
	protected $openid;
	protected $validate;
	protected $post;
	protected $session;

	public function onLoad()
	{
		$this->getContainer()->setParameter('session.name', 'oi');

		$this->http     = $this->getHttp();
		$this->openid   = new OpenId($this->http, $this->config['psx_url']);
		$this->validate = $this->getValidate();
		$this->post     = $this->getInputPost();
		$this->session  = $this->getSession();

		if($this->session->get('oi_authed') == true)
		{
			$this->getTemplate()->assign('id', $this->session->get('oi_id'));
			$this->getTemplate()->assign('name', $this->session->get('oi_name'));
			$this->getTemplate()->assign('email', $this->session->get('oi_email'));
		}

		$this->getTemplate()->assign('authed', $this->session->get('oi_authed'));
	}

	public function onPost()
	{
		$identity = $this->post->openid_identifier('string', array(new Filter\Length(3, 256)));
		$returnTo = $this->config['psx_url'] . '/' . $this->config['psx_dispatch'] . 'openidconsumer/callback';

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

		header('Location: ' . $this->config['psx_url'] . '/' . $this->config['psx_dispatch'] . 'openidconsumer');
		exit;
	}
}
