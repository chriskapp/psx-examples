<?php

namespace demo\openid_consumer;

use Exception;
use PSX_Http;
use PSX_Http_Handler_Curl;
use PSX_Module_ViewAbstract;
use PSX_OpenId;
use PSX_OpenId_Exception;
use PSX_Session;

class callback extends PSX_Module_ViewAbstract
{
	private $http;
	private $openid;
	private $validate;
	private $session;
	private $post;

	public function onLoad()
	{
		$this->http     = new PSX_Http(new PSX_Http_Handler_Curl());
		$this->openid   = new PSX_OpenId($this->http, $this->config['psx_url']);

		$this->session  = new PSX_Session('oi');
		$this->session->start();
	}

	public function onGet()
	{
		try
		{
			if($this->openid->verify() === true)
			{
				$data     = $this->openid->getData();
				$identity = PSX_OpenId::normalizeIdentifier((string) $this->openid->getIdentity()->getLocalId());

				if(!empty($identity))
				{
					// fetch the received values
					$user = array();
					$map  = array(

						'fullname' => 'http://axschema.org/namePerson',
						'first'    => 'http://axschema.org/namePerson/first',
						'last'     => 'http://axschema.org/namePerson/last',
						'email'    => 'http://axschema.org/contact/email',

					);

					foreach($data as $k => $v)
					{
						foreach($map as $t => $ns)
						{
							if($v == $ns)
							{
								$key = str_replace('type', 'value', $k);

								if(isset($data[$key]))
								{
									$user[$t] = $data[$key];
								}
							}
						}
					}

					// assign the values
					if(isset($user['first']) && isset($user['last']))
					{
						$name = $user['first'] . ' ' . $user['last'];
					}
					elseif(isset($user['fullname']))
					{
						$name = $user['fullname'];
					}
					else
					{
						$name = $identity;
					}

					if(isset($user['email']))
					{
						$email = $user['email'];
					}
					else
					{
						$email = '';
					}

					// saves the values in the session
					$this->session->set('oi_authed', true);
					$this->session->set('oi_id', $identity);
					$this->session->set('oi_name', $name);
					$this->session->set('oi_email', $email);

					// redirect the user
					header('Location: ' . $this->config['psx_url'] . '/' . $this->config['psx_dispatch'] . 'demo/openid_consumer');
					exit;
				}
				else
				{
					throw new PSX_OpenId_Exception('Couldnt get identity');
				}
			}
		}
		catch(Exception $e)
		{
			$this->template->assign('error', $e->getMessage() . '<br />' . $e->getTraceAsString());
		}
	}
}