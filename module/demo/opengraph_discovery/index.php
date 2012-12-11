<?php

namespace demo\opengraph_discovery;

use PSX_Filter_Length;
use PSX_Filter_Url;
use PSX_Http;
use PSX_Http_Handler_Curl;
use PSX_Module_ViewAbstract;
use PSX_Opengraph;
use PSX_Url;

class index extends PSX_Module_ViewAbstract
{
	public function onLoad()
	{
		$this->template->set(str_replace('\\', DIRECTORY_SEPARATOR, __CLASS__) . '.tpl');
	}

	public function onPost()
	{
		$http = new PSX_Http(new PSX_Http_Handler_Curl());
		$og   = new PSX_Opengraph($http);
		$url  = $this->getBody()->url('string', array(new PSX_Filter_Length(3, 256), new PSX_Filter_Url()));

		if(!$this->getValidator()->hasError())
		{
			$response = $og->discover(new PSX_Url($url));

			if(!empty($response))
			{
				$response = $response;
			}
			else
			{
				$response = false;
			}

			$this->template->assign('response', $response);
		}
		else
		{
			$this->template->assign('error', $this->getValidator()->getError());
		}
	}
}