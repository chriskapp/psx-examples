<?php

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