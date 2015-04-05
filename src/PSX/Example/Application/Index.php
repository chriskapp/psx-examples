<?php

namespace PSX\Example\Application;

use PSX\Controller\ApiAbstract;

class Index extends ApiAbstract
{
	/**
	 * @Inject
	 */
	protected $reverseRouter;

	public function onGet()
	{
		$this->setBody([
			'message' => 'Welcome, this is an example API endpoint build with the PSX framework',
			'links'   => [[
				'rel'   => 'describes', 
				'title' => 'Documentation of the available API endpoints',
				'href'  => $this->reverseRouter->getBasePath() . '/documentation',
			],[
				'rel'   => 'contents', 
				'title' => 'Example internet population API',
				'href'  => $this->reverseRouter->getUrl('PSX\Example\Api\Collection'),
			],[
				'rel'   => 'about', 
				'title' => 'Informations about the REST API framework',
				'href'  => 'http://phpsx.org',
			],[
				'rel'   => 'related', 
				'title' => 'Source code of this example API',
				'href'  => 'https://github.com/k42b3/psx-examples',
			]]
		]);
	}
}
