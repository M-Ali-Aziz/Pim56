<?php

namespace AppBundle\Controller;

use AppBundle\Website\Controller\Action;
use Pimcore\Controller\FrontendController;
use Symfony\Component\HttpFoundation\Request;

/**
* Default Controller
*
* The default controller contains a default action.
*
* The default controller inherits some locale and language
* initialization from Website Controller Action. It also
* inherits the website configuration property.
*
* The default controller should mainly be used for pages
* that do not use layout (e.g. snippets). The Website
* Content Controller is used for static pages that use
* layouts.
*
* @package LUSEM
* @category AppBundle
* @author Jonas Ledendal <Jonas.Ledendal@har.lu.se>, M. Ali
* @version 2.0
*/
class DefaultController extends Action
{
    /**
    * Deafult action
    */
    public function defaultAction(Request $request)
    { }

    /**
    * Redirects to admin back-end login page
    */
    public function adminAction(Request $request)
    {
        return $this->redirect('/admin/login');
    }
}
