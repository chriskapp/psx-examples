<?php

namespace demo\http_request;

use PSX_Http;
use PSX_Http_GetRequest;
use PSX_Http_Handler_Curl;
use PSX_ModuleAbstract;
use PSX_Url;

class index extends PSX_ModuleAbstract
{
	public function onLoad()
	{
		$http    = new PSX_Http(new PSX_Http_Handler_Curl());
		$url     = new PSX_Url('http://ip.k42b3.com/');
		$request = new PSX_Http_GetRequest($url);

		$response = $http->request($request);


		header('Content-type: text/plain');

		var_dump($response);
	}
}