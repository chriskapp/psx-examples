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
		$this->template->set(str_replace('\\', DIRECTORY_SEPARATOR, __CLASS__) . '.tpl');
	}

	public function onPost()
	{
		$http      = new Http();
		$webfinger = new Webfinger($http);
		$email     = $this->getBody()->email('string', array(new Filter\Length(3, 64), new Filter\Email()));

		if(!$this->getValidator()->hasError())
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

				$this->template->assign('discoverEmail', htmlspecialchars($email));
				$this->template->assign('response', $response);
			}
			catch(\Exception $e)
			{
				$this->template->assign('error', array($e->getMessage()));
			}
		}
		else
		{
			$this->template->assign('error', $this->getValidator()->getError());
		}
	}
}