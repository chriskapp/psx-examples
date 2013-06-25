<?php

namespace demo\webfinger;

use PSX\Exception;
use PSX\Filter;
use PSX\Http;
use PSX\Module\ViewAbstract;
use PSX\Url;
use PSX\Webfinger;

class index extends ViewAbstract
{
	public function onLoad()
	{
	}

	public function onPost()
	{
		$http      = $this->getHttp();
		$webfinger = new Webfinger($http);
		$email     = $this->getBody()->email('string', array(new Filter\Length(3, 64), new Filter\Email()));

		if(!$this->getValidate()->hasError())
		{
			try
			{
				list($user, $host) = explode('@', $email);

				$url = new Url('http://' . $host);
				$tpl = $webfinger->getLrddTemplate($url);
				$xrd = $webfinger->getLrdd('acct:' . $email, $tpl);

				$response = $xrd->asXML();

				if(!empty($response))
				{
					$response = htmlspecialchars($response, ENT_COMPAT, 'UTF-8');
				}
				else
				{
					$response = false;
				}

				$this->getTemplate()->assign('discoverEmail', htmlspecialchars($email));
				$this->getTemplate()->assign('response', $response);
			}
			catch(\Exception $e)
			{
				$this->getTemplate()->assign('error', array($e->getMessage()));
			}
		}
		else
		{
			$this->getTemplate()->assign('error', $this->getValidate()->getError());
		}
	}
}