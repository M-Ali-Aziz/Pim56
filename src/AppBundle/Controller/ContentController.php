<?php

namespace AppBundle\Controller;

use AppBundle\Website\Controller\Page;
use Pimcore\Controller\FrontendController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\FilterControllerEvent;
use \Pimcore\Config\Config;
use \Pimcore\Model\Site;
use \Pimcore\Tool;

/**
* Content Controller
*
* @package LUSEM
* @category AppBundle
* @author Jonas Ledendal <Jonas.Ledendal@har.lu.se>, M. Ali
* @version 2.0
*/
class ContentController extends Page
{
    /**
    * Default action
    */
    public function defaultAction(Request $request)
    {
        $subdomain = $this->website['subdomain'];

        $this->view->debugmode = (PIMCORE_DEVMODE || PIMCORE_DEBUG) ? TRUE : FALSE;
        $this->view->breadcrumbs = TRUE;
    }

    /**
    * Start action
    */
    public function startAction(Request $request)
    {
        $this->view->startsite = TRUE;
    }

    /**
    * Extended action
    */
    public function extendedAction(Request $request)
    {
        $this->view->extended = TRUE;
    }

    /**
    * Tabs action
    */
    public function tabsAction(Request $request)
    {
        $this->view->tabs = TRUE;
    }

    /**
    * Landing action
    */
    public function landingAction(Request $request)
    {
        $this->view->landing = TRUE;
    }

    /**
    * Landing action
    */
    public function subsiteAction(Request $request)
    {
        $this->view->subsite = TRUE;
    }

    /**
    * solr action
    */
    public function solrAction(Request $request)
    {
        $this->view->solr = TRUE;
        $this->view->breadcrumbs = TRUE;
    }

    /**
    * Error action
    *
    * Sets response object header to status code 404.
    */
    public function errorAction(Request $request)
    {
        $response = new Response();
        // $response->setContent('404 - Page not found');
        $response->setStatusCode(Response::HTTP_NOT_FOUND);
        $response->headers->set('HTTP/1.1', '404 Not Found', true);
        $response->send();
        $this->view->title = '404 - Page not found';
    }
}
