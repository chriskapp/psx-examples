<?php

namespace demo\oembed_consumer;

use PSX\Exception;
use PSX\Filter;
use PSX\Http;
use PSX\Module\ViewAbstract;
use PSX\Oembed;
use PSX\Url;

class index extends ViewAbstract
{
	public function onLoad()
	{
		$this->template->set(str_replace('\\', DIRECTORY_SEPARATOR, __CLASS__) . '.tpl');
	}

	public function onPost()
	{
		$http   = new Http();
		$oembed = new Oembed($http);
		$url    = $this->getBody()->url('string', array(new Filter\Length(3, 256), new Filter\Url()));

		if(!$this->getValidator()->hasError())
		{
			$url = new Url($url);

			if($url->getHost() != 'www.youtube.com')
			{
				throw new Exception('Invalid host');
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
