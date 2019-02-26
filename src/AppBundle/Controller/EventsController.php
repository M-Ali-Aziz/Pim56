<?php

namespace AppBundle\Controller;

use AppBundle\Website\Controller\DynamicPage;
use Pimcore\Controller\FrontendController;
use Symfony\Component\HttpFoundation\Request;
use \Pimcore\Model\DataObject;

/**
* Events Controller
*
* @package LUSEM
* @category AppBundle
* @author Jonas Ledendal <Jonas.Ledendal@har.lu.se>, M. Ali
* @version 2.0
*/
class EventsController extends DynamicPage
{
    /**
    * Events Detail Action
    */
    public function detailAction(Request $request)
    {
        try {
            // Get params from the request/url
            $page = $request->get('page');
            $key = $request->get('key');

            // Get events object by key
            $events = new DataObject\Events\Listing();
            $events->setCondition("o_key = " . $events->quote($key));
            $events->load();
            $event = $events->getObjects()[0];

            // Get lokal object by id
            $lokal = DataObject\Lokal::getById($event->getVenue());

            if($event)
            {
                // Assign event object to view
                $this->view->title = $event->getRubrik();
                $this->view->editHeadTitle = true;
                $this->view->event = $event;
                $this->view->google = \Pimcore\Config::getSystemConfig()->services->google;
                if ($lokal) {
                    $this->view->lokal = $lokal;
                    $this->view->coordinate = $lokal->getLatitud() . ',' . $lokal->getLongitud();
                }

                $this->view->breadcrumbs = $event;
            }
        }
        catch(\Exception $e) {
            $event = null;
        }
    }

    /**
    * Events Preview Action
    */
    public function previewAction(Request $request)
    {
        try {
            // Get id from the request/url
            $id = $request->get('id');

            // Get event object by id
            $event = DataObject\Events::getById($id);

            // Get lokal object by id
            $lokal = DataObject\Lokal::getById($event->getVenue());

            if($event)
            {
                // Assign event object to view
                $this->view->event = $event;
                $this->view->google = \Pimcore\Config::getSystemConfig()->services->google;
                if ($lokal) {
                    $this->view->lokal = $lokal;
                    $this->view->coordinate = $lokal->getLatitud() . ',' . $lokal->getLongitud();
                }
            }
        }
        catch(\Exception $e) {
            $event = null;
        }
    }
}
