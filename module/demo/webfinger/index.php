<?php

namespace demo\webfinger;

use Exception;
use PSX_Filter_Email;
use PSX_Filter_Length;
use PSX_Http;
use PSX_Http_Handler_Curl;
use PSX_Module_ViewAbstract;
use PSX_Url;
use PSX_Webfinger;

class index extends PSX_Module_ViewAbstract
{
	public function onLoad()
	{
		$this->template->set(str_replace('\\', DIRECTORY_SEPARATOR, __CLASS__) . '.tpl');
	}

	public function onPost()
	{
		$http      = new PSX_Http(new PSX_Http_Handler_Curl());
		$webfinger = new PSX_Webfinger($http);
		$email     = $this->getBody()->email('string', array(new PSX_Filter_Length(3, 64), new PSX_Filter_Email()));

		if(!$this->getValidator()->hasError())
		{
			try
			{
				list($user, $host) = explode('@', $email);

				$url = new PSX_Url('http://' . $host);
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
			catch(Exception $e)
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