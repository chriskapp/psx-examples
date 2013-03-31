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
		$this->template->set(str_replace('\\', DIRECTORY_SEPARATOR, __CLASS__) . '.tpl');
	}

	public function onPost()
	{
		$http  = new Http();
		$yadis = new Yadis($http);
		$url   = $this->getBody()->url('string', array(new Filter\Length(3, 256), new Filter\Url()));

		if(!$this->getValidator()->hasError())
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

			$this->template->assign('discoverUrl', htmlspecialchars($url));
			$this->template->assign('response', $response);
		}
		else
		{
			$this->template->assign('error', $this->getValidator()->getError());
		}
	}
}