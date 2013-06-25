<?php

namespace demo\openid_consumer;

use PSX\Exception;
use PSX\Http;
use PSX\Module\ViewAbstract;
use PSX\OpenId;
use PSX\Session;

class callback extends ViewAbstract
{
	protected $http;
	protected $openid;
	protected $validate;
	protected $session;
	protected $post;

	public function onLoad()
	{
		$this->getContainer()->setParameter('session.name', 'oi');

		$this->http     = $this->getHttp();
		$this->openid   = new OpenId($this->http, $this->config['psx_url']);
		$this->session  = $this->getSession();
	}

	public function onGet()
	{
		try
		{
			if($this->openid->verify() === true)
			{
				$data     = $this->openid->getData();
				$identity = OpenId::normalizeIdentifier((string) $this->openid->getIdentity()->getLocalId());

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
					throw new Exception('Couldnt get identity');
				}
			}
		}
		catch(\Exception $e)
		{
			$this->getTemplate()->assign('error', $e->getMessage() . '<br />' . $e->getTraceAsString());
		}
	}
}