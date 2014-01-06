<?php

namespace PSX\Demo\Application\Webfinger;

use PSX\Exception;
use PSX\Filter;
use PSX\Http;
use PSX\Module\ViewAbstract;
use PSX\Url;
use PSX\Webfinger;

class Index extends ViewAbstract
{
	public function onLoad()
	{
	}

	public function onPost()
	{
		$http      = $this->getHttp();
		$webfinger = new Webfinger($http);
		$email     = $this->getInputPost()->email('string', array(new Filter\Length(3, 64), new Filter\Email()));

		if(!$this->getValidate()->hasError())
		{
			try
			{
				list($user, $host) = explode('@', $email);

				$url      = new Url('http://' . $host);
				$document = $webfinger->discover($url, 'acct:' . $email);

				$this->getTemplate()->assign('document', $document);
			}
			catch(\Exception $e)
			{
				$this->getTemplate()->assign('error', array($e->getMessage()));
			}
		}
		else
		{
			$this->getTemplate()->assign('error', $this->getValidate()->getError());
		}
	}
}