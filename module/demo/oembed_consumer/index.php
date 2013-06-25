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
	}

	public function onPost()
	{
		$http   = $this->getHttp();
		$oembed = new Oembed($http);
		$url    = $this->getBody()->url('string', array(new Filter\Length(3, 256), new Filter\Url()));

		if(!$this->getValidate()->hasError())
		{
			$url = new Url($url);

			if($url->getHost() != 'www.youtube.com')
			{
				throw new Exception('Invalid host');
			}

			$type = $oembed->discover($url);

			$this->getTemplate()->assign('oembedUrl', htmlspecialchars($url));
			$this->getTemplate()->assign('type', $type);
		}
		else
		{
			$this->getTemplate()->assign('error', $this->getValidate()->getError());
		}
	}
}
