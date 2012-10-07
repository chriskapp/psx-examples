<?php

class index extends PSX_Module_ViewAbstract
{
	public function onLoad()
	{
		$this->template->set('demo/oembed_consumer/' . __CLASS__ . '.tpl');
	}

	public function onPost()
	{
		$http   = new PSX_Http(new PSX_Http_Handler_Curl());
		$oembed = new PSX_Oembed($http);
		$url    = $this->getBody()->url('string', array(new PSX_Filter_Length(3, 256), new PSX_Filter_Url()));

		if(!$this->getValidator()->hasError())
		{
			$url = new PSX_Url($url);

			if($url->getHost() != 'www.youtube.com')
			{
				throw new PSX_Exception('Invalid host');
			}

			$type = $oembed->discover($url);

			$this->template->assign('oembedUrl', htmlspecialchars($url));
			$this->template->assign('type', $type);
		}
		else
		{
			$this->template->assign('error', $this->getValidator()->getError());
		}
	}
}
