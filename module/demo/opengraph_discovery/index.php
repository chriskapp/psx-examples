<?php

class index extends PSX_Module_ViewAbstract
{
	public function onLoad()
	{
		$this->template->set('demo/opengraph_discovery/' . __CLASS__ . '.tpl');
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