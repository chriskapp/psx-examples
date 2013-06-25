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
	}

	public function onPost()
	{
		$http = $this->getHttp();
		$og   = new Opengraph($http);
		$url  = $this->getBody()->url('string', array(new Filter\Length(3, 256), new Filter\Url()));

		if(!$this->getValidate()->hasError())
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

			$this->getTemplate()->assign('response', $response);
		}
		else
		{
			$this->getTemplate()->assign('error', $this->getValidate()->getError());
		}
	}
}