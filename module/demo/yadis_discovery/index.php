<?php

namespace demo\yadis_discovery;

use PSX\Filter;
use PSX\Http;
use PSX\Module\ViewAbstract;
use PSX\Url;
use PSX\Yadis;

class index extends ViewAbstract
{
	public function onLoad()
	{
	}

	public function onPost()
	{
		$http  = $this->getHttp();
		$yadis = new Yadis($http);
		$url   = $this->getBody()->url('string', array(new Filter\Length(3, 256), new Filter\Url()));

		if(!$this->getValidate()->hasError())
		{
			$response = $yadis->discover(new Url($url), true);

			if(!empty($response))
			{
				$response = htmlspecialchars($response, ENT_COMPAT, 'UTF-8');
			}
			else
			{
				$response = false;
			}

			$this->getTemplate()->assign('discoverUrl', htmlspecialchars($url));
			$this->getTemplate()->assign('response', $response);
		}
		else
		{
			$this->getTemplate()->assign('error', $this->getValidate()->getError());
		}
	}
}