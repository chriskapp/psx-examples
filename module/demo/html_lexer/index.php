<?php

namespace demo\html_lexer;

use PSX_Filter_Length;
use PSX_Filter_Url;
use PSX_Html_Lexer;
use PSX_Http;
use PSX_Http_GetRequest;
use PSX_Module_ViewAbstract;

class index extends PSX_Module_ViewAbstract
{
	public function onLoad()
	{
		$this->template->set(str_replace('\\', DIRECTORY_SEPARATOR, __CLASS__) . '.tpl');
	}

	public function onPost()
	{
		$src = $this->getBody()->src('string', array(new PSX_Filter_Length(6, 256), new PSX_Filter_Url()));

		if(!$this->getValidator()->hasError())
		{
			$http     = new PSX_Http();
			$request  = new PSX_Http_GetRequest($src);
			$request->setFollowLocation(true);
			$response = $http->request($request);

			$root     = PSX_Html_Lexer::parse($response->getBody());
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

			$this->template->assign('src', $src);
			$this->template->assign('links', $links);
		}
		else
		{
			$this->template->assign('error', $this->getValidator()->getError());
		}
	}
}
