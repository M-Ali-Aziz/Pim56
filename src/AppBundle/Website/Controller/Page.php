<?php

namespace AppBundle\Website\Controller;

use Pimcore\Controller\FrontendController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Event\FilterControllerEvent;

/**
* Website Page Controller
*
* The Page Controller is used as the default controller for all
* page documents.
*
* The Page Controller enables layout by default. Since an error
* occurs when layout is enabled for a snippet document, the content
* controller should never be used for snippets.
*
* The Page Controller is responsible for all initialization that
* is required by layout scripts. Controllers that use layout must
* therefore extend the Page Controller.
*
* @package LUSEM
* @category website
* @author Jonas Ledendal <Jonas.Ledendal@har.lu.se>, Jimmi Elofsson <hi@jimmi.eu>, M. Ali
* @version 2.0
*/
class Page extends Action
{
    protected $departmentNumber;
    protected $department;

    /**
    * Assign properties to controller and view.
    */
    public function onKernelController(FilterControllerEvent $event)
    {
        parent::onKernelController($event);

        // Assign main menu navigation
        $this->view->mainMenu = $this->getMainNavigation();

        // Assign shortcuts navigation
        $this->view->shortcuts = $this->getShortcutsNavigation();

        // Assign target groups navigation
        $this->view->targetgroups = $this->getTargetGroupsNavigation();

        // Assign department property to controller and view
        $this->departmentNumber = $this->website['departmentnumber'];
        $this->view->department = $this->department = NULL;

        // Subdomain
        $this->view->subdomain = $subd = $this->website['subdomain'];

        // Language
        $lang = $this->language;

        if ($this->document) {

            if ($this->document->getProperty('bootstrap')) {
                // Site Cookies
                $this->siteCookies();
            }

            // Image
            $image = $this->document->getProperty('social_media_image');

            // Opengraph
            if($image)
            {
                $image = 'http://' . $_SERVER['HTTP_HOST'] . $image->path . $image->filename;
                $card = 'summary_large_image';
            }
            else
            {
                $image = 'http://' . $_SERVER['HTTP_HOST'] . '/static/images/logos/logo-ehl-' . strtolower($lang) . '.png';
                $card = 'summary';
            }
            // assign twitter metas
            $this->view->twitter = [
                'card'          => $card,
                'site'          => $this->config->twitter_site,
                'title'         => $this->document->getTitle(),
                'description'   => substr($this->document->getDescription(), 0,200),
                'creator'       => $this->config->twitter_site,
                'image:src'     => $image,
            ];
            // assign googleplus metas
            $this->view->googleplus = [
                'name'        => $this->document->getTitle(),
                'description' => $this->document->getDescription(),
                'image'       => $image,
            ];
            // assign open graph facebook metas
            $this->view->opengraph = [
                'og:title'       => $this->document->getTitle(),
                'og:description' => $this->document->getDescription(),
                'og:type'        => 'website',
                'og:url'         => 'http://' . $_SERVER['HTTP_HOST'] . $this->document->getFullPath() . $id,
                'og:image'       => $image,
                'og:site_name'   => $this->website['name'],
                'fb:app_id'      => $this->config->fb_app_id,
                'fb:profile_id'  => $this->config->fb_profile_id
            ];
        }

        // Add dev/test to the $sund depending on the curent environment
        if (strpos($_SERVER["SERVER_NAME"], 'dev') !== false) {
            $subd = 'dev.' . $subd;
        } elseif (strpos($_SERVER["SERVER_NAME"], 'test') !== false) {
            $subd = 'test.' . $subd;
        }

        // searchUrl
        $this->view->searchUrl = $searchUrl = (((strpos($subd, 'ehl') !== false) || (strpos($subd, 'lusem') !== false)) ? '//' . $subd : (($lang == 'en') ? 'https://www.lunduniversity' : 'https://www'))
            . '.lu.se/search';
    }

    /**
    * Site Cookies.
    */
    public function siteCookies()
    {
        $code = '
        <div class="alert alert-danger fixed-bottom fade show m-0 border-0 rounded-0 font-size-sm" role="alert" id="pc-cookie-notice">
            <div>
                <button type="button" class="float-right border-0 bg-transparent cursor-pointer lh-0 p-2 nm-2" data-dismiss="alert" id="pc-button"><span aria-hidden="true"><i class="fal fa-times fa-lg"></i></span></button>' .
                $this->get("translator")->trans("cookie-policy-text") .
                ' <a href="' . $this->get("translator")->trans("cookie-policy-linktarget") . '" class="alert-link">' .
                    $this->get("translator")->trans("cookie-policy-linktext") .
                '</a>
            </div>
        </div>';

        $cookieListener = $this->get(\Pimcore\Bundle\CoreBundle\EventListener\Frontend\CookiePolicyNoticeListener::class);
        $cookieListener->setTemplateCode($code);
    }
}
