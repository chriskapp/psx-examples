<?php

namespace demo\opengraph_discovery;

use PSX\Filter;
use PSX\Http;
use PSX\Module\ViewAbstract;
use PSX\Opengraph;
use PSX\Url;

class index extends ViewAbstract
{
	public function onLoad()
	{
		$this->template->set(str_replace('\\', DIRECTORY_SEPARATOR, __CLASS__) . '.tpl');
	}

	public function onPost()
	{
		$http = new Http();
		$og   = new Opengraph($http);
		$url  = $this->getBody()->url('string', array(new Filter\Length(3, 256), new Filter\Url()));

		if(!$this->getValidator()->hasError())
		{
			$response = $og->discover(new Url($url));

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