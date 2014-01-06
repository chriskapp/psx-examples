<?php

namespace PSX\Demo\Application\HtmlLexer;

use PSX\Filter;
use PSX\Html\Lexer;
use PSX\Http;
use PSX\Http\GetRequest;
use PSX\Module\ViewAbstract;

class Index extends ViewAbstract
{
	public function onLoad()
	{
	}

	public function onPost()
	{
		$src = $this->getInputPost()->src('string', array(new Filter\Length(6, 256), new Filter\Url()));

		if(!$this->getValidate()->hasError())
		{
			$http     = $this->getHttp();
			$request  = new GetRequest($src);
			$request->setFollowLocation(true);
			$response = $http->request($request);

			$root     = Lexer::parse($response->getBody());
			$elements = $root->getElementsByTagName('a');
			$links    = array();

			foreach($elements as $el)
			{
				$href = $el->getAttribute('href');

				if(!empty($href))
				{
					$links[] = $href;
				}
			}

			$this->getTemplate()->assign('src', $src);
			$this->getTemplate()->assign('links', $links);
		}
		else
		{
			$this->getTemplate()->assign('error', $this->getValidate()->getError());
		}
	}
}
