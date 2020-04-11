<?php

namespace App\Api;

use PSX\Framework\Controller\ApiAbstract;

class Index extends ApiAbstract
{
    /**
     * @Inject
     * @var \PSX\Framework\Loader\ReverseRouter
     */
    protected $reverseRouter;

    public function onLoad()
    {
        parent::onLoad();

        $this->setBody(array(
            'message' => 'Welcome, this is a PSX sample application. It should help to bootstrap a project by providing all needed files and some examples.',
            'links'   => array(
                array(
                    'rel'   => 'routing',
                    'href'  => $this->reverseRouter->getUrl('PSX\Framework\Controller\Tool\RoutingController'),
                    'title' => 'Gives an overview of all available routing definitions',
                ),
                array(
                    'rel'   => 'documentation',
                    'href'  => $this->reverseRouter->getUrl('PSX\Framework\Controller\Tool\DocumentationController::doIndex'),
                    'title' => 'Generates an API documentation from all available endpoints',
                ),
                array(
                    'rel'   => 'alternate',
                    'href'  => $this->reverseRouter->getBasePath() . '/documentation/',
                    'title' => 'HTML client to view the API documentation',
                    'type'  => 'text/html',
                ),
            )
        ));
    }
}
