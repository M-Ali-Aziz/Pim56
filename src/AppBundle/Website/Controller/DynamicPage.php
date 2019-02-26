<?php

namespace AppBundle\Website\Controller;

use Pimcore\Controller\FrontendController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Event\FilterControllerEvent;
use \Pimcore\Model\Document;
use \Pimcore\Model\Site;

/**
* Website Dynamic Page Controller
*
* @package LUSEM
* @category Website
* @author Jonas Ledendal <Jonas.Ledendal@har.lu.se>, M. Ali
* @version 2.0
*/
class DynamicPage extends Page
{
    /**
    * Initializes controller
    */
    public function onKernelController(FilterControllerEvent $event)
    {
        parent::onKernelController($event);

        //set document object parameter to parent document
        $this->view->document = $this->getParentDocument();
    }

    /**
    * Recursively searches for parent page by matching request uri
    * to pages in the document tree.
    *
    * This can be used to get a document object for dynamic pages.
    */
    protected function getParentDocument()
    {
        if( ! Site::isSiteRequest()) {
            return NULL;
        }

        //get current site
        $site = Site::getCurrentSite();

        //get site root path
        $rootPath = $site->getRootPath();

        $document = null;

        $uri_parts = explode('/', $_SERVER['REQUEST_URI']);

        for($i = count($uri_parts); $i > 0; $i--) {
            $uri = "";
            foreach($uri_parts as $pos=>$part) {
                if($pos == $i) break;
                $uri .= $part . "/";
            }
            $document = Document::getByPath($rootPath.$uri);

            if($document) break;
        }

        return $document;
    }
}
