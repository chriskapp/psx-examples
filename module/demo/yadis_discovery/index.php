<?php

namespace demo\yadis_discovery;

use PSX_Filter_Length;
use PSX_Filter_Url;
use PSX_Http;
use PSX_Http_Handler_Curl;
use PSX_Module_ViewAbstract;
use PSX_Url;
use PSX_Yadis;

class index extends PSX_Module_ViewAbstract
{
	public function onLoad()
	{
		$this->template->set(str_replace('\\', DIRECTORY_SEPARATOR, __CLASS__) . '.tpl');
	}

	public function onPost()
	{
		$http  = new PSX_Http(new PSX_Http_Handler_Curl());
		$yadis = new PSX_Yadis($http);
		$url   = $this->getBody()->url('string', array(new PSX_Filter_Length(3, 256), new PSX_Filter_Url()));

		if(!$this->getValidator()->hasError())
		{
			$response = $yadis->discover(new PSX_Url($url), true);

			if(!empty($response))
			{
				$response = htmlspecialchars($response, ENT_COMPAT, 'UTF-8');
			}
			else
			{
				$response = false;
			}

			$this->template->assign('discoverUrl', htmlspecialchars($url));
			$this->template->assign('response', $response);
		}
		else
		{
			$this->template->assign('error', $this->getValidator()->getError());
		}
	}
}