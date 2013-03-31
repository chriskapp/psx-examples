<?php

namespace demo\http_request;

use PSX\Http;
use PSX\Http\GetRequest;
use PSX\ModuleAbstract;
use PSX\Url;

class index extends ModuleAbstract
{
	public function onLoad()
	{
		$http    = new Http();
		$url     = new Url('http://ip.k42b3.com/');
		$request = new GetRequest($url);

		$response = $http->request($request);


		header('Content-type: text/plain');

		var_dump($response);
	}
}