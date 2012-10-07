<?php

class index extends PSX_Module_ViewAbstract
{
	public function onLoad()
	{
		$this->template->set('demo/yadis_discovery/' . __CLASS__ . '.tpl');
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