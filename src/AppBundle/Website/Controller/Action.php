<?php

namespace AppBundle\Website\Controller;

use Pimcore\Controller\FrontendController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\FilterControllerEvent;
use \Pimcore\Config\Config;
use \Pimcore\Model\Site;
use \Pimcore\Tool;
use \Pimcore\Model\DataObject;

/**
* Website Action Controller
*
* The Website Action Controller is used as a base class
* for all controllers.
*
* @package LUSEM
* @category website
* @author Jonas Ledendal <Jonas.Ledendal@har.lu.se>, M. Ali
* @version 2.0
*/
class Action extends FrontendController
{
    protected $locale;
    protected $language;
    protected $config;
    protected $website;
    protected $websiteDataObject;

    /**
     * Assign properties to controller and view.
    */
    public function onKernelController(FilterControllerEvent $event)
    {
        // Enable view auto-rendering
        $this->setViewAutoRender($event->getRequest(), true, 'php');

        // Assign locale property to controller and view
        $this->locale = $event->getRequest()->getLocale();
        $this->view->locale = $this->locale;

        // Assign language property to controller and view
        $this->language = substr($event->getRequest()->getLocale(), 0, 2);
        $this->view->language = $this->language;

        //Assign website config to controller and view
        $this->config = \Pimcore\Config::getWebsiteConfig();

        // Get website DataObject
        $this->websiteDataObject = new DataObject\Website\Listing();

        //assign Pimcore website configuration property to controller and view
        $this->website = $this->getWebsiteConfiguration($this->locale);
        $this->view->website = $this->website;
    }

    /**
    * Returns the canonical domain name for a domain name
    *
    * @return string
    */
    protected function getCanonicalDomainName()
    {
        // Edit mode does not use site request so we need to
        // figure out the site's domain from the real path
        if (Site::isSiteRequest()) {
            $site = Site::getCurrentSite();
            $domains = $site->getDomains();
            $server_name = $domains[0];
        }
        else
        {
            $server_name = $this->getSiteDomain();
            if (!$server_name) $server_name = "ehl.lu.se";
        }

        //Strip www component from domain name
        if (substr($server_name, 0, 3) === 'www') {
            $server_name = substr($server_name, strpos($server_name, '.') + 1);
        }

        return $server_name;
    }

    /**
    * Returns domain component from document real path
    *
    * This function is used to extract the domain name
    * for requests in edit mode.
    *
    * @return string
    */
    protected function getSiteDomain()
    {
        foreach ($this->websiteDataObject as $w) {
            if (strpos($_SERVER['HTTP_HOST'], $w->getDomainName()) !== false) {
                return $w->getDomainName();
            }
        }
    }

    /**
    * Returns website configuration object
    *
    * Website configuration can be overridden by document properties.
    *
    * @param FilterControllerEvent $locale
    * @return array
    */
    public function getWebsiteConfiguration($locale)
    {
        // loading website object...
        // first we are checking for an object on the website property of current document
        // if not found, we try to figure out what object to use (by domain-name).
        $website = ($this->document) ?
            $this->document->getProperty('website') :
            DataObject\Website::getByDomainName($this->getCanonicalDomainName(), ['limit' => 1]);

        // checking if we got an object
        if( ! is_object($website)) {
            // Write a log to debug.log
            \Pimcore\Log\Simple::log('debug', 'No website object found' . ' ' . __FILE__ . " Line: " . __LINE__);

            // give them the default configuration
            return $this->getDefaultWebsiteConfiguration($locale);
        }

        try
        {
            $config_params = array('languages' => array());

            // Getting active language locale as a two letter string
            $activeLanguage = substr($locale, 0, 2);

            foreach(Tool::getValidLanguages() as $l)
            {

                if( ! $website->getLocaleExists($l)) {
                    continue;
                }

                // getting siteInfo uri
                if($website->getSiteInfo())
                {
                    $href = $website->getSiteInfo()[0]->getElement();
                    $siteInfoPage = \Pimcore\Model\Document::getById($href->getId());
                }

                $siteInfo = (is_object($href)) ? array(
                    'label' => $siteInfoPage->getTitle(),
                    'uri'   => $siteInfoPage->getFullPath()
                ) : NULL;

                // setting website config parameters
                $config_params['languages'][$l] = $lang_config_params = array(
                    'canonicaldomainname' => $this->getCanonicalDomainName(),
                    'domainname' => $website->getDomainName(),
                    'newsFilter' => $website->getNewsFilter(),
                    'subdomain' => $website->getSubdomain(),
                    'baseuri' => $website->getBaseUri($l),
                    'title' => $website->getMain_Title($l),
                    'subtitle' => $website->getMain_Sub_Title($l),
                    'name' => $website->getContact_Information_Name($l),
                    'mail' => $website->getContact_Information_Mail($l),
                    'phone' => $website->getContact_Information_Phone($l),
                    'adress' => $website->getContact_Information_Address($l),
                    'departmentnumber' => $website->getDepartmentNumber(),
                    'locale' => $locale,
                    'siteInfo' => $siteInfo
                );

                // checking if current language-config-parameters are the active one
                // if so, then we want these values to be in the root of config-param
                if($l == $activeLanguage) 
                {
                    $config_params = array_merge($config_params, $lang_config_params);
                }
            }
        }
        catch(\Exception $e)
        {
            // Write a log to debug.log
            \Pimcore\Log\Simple::log('debug', $e->getMessage() . ' ' . __FILE__ . " Line: " . __LINE__);

            // give them the default configuration
            return $this->getDefaultWebsiteConfiguration($locale);
        }

        if ($this->document) {
            // return localized configuration (after we merged the parameters with document properties)
            $configArr = (array_merge($config_params, $this->document->getProperties()));
            $websiteConfig = $this->document->setProperties($configArr);

            return $this->document->getProperties();
        }

        return;

    }

    /**
    * Returns default website configutation
    *
    * Website configuration can be overridden by document properties.
    *
    * @param FilterControllerEvent $locale
    * @return array
    */
    public function getDefaultWebsiteConfiguration($locale)
    {
        // setting default website config parameters
        switch(substr($locale, 0, 2))
        {
            default:
            case 'sv':
                $config_params = array(
                    'canonicaldomainname' => 'ehl.lu.se',
                    'domainname' => 'www.ehl.lu.se',
                    'subdomain' => 'ehl',
                    'baseuri' => '/',
                    'title' => 'Ekonomihögskolan',
                    'subtitle' => 'Lunds universitet',
                    'departmentnumber' => 'v1000020',
                    'locale' => 'sv'
                );
                break;

            case 'en':
                $config_params = array(
                    'canonicaldomainname' => 'lusem.lu.se',
                    'domainname' => 'www.lusem.lu.se',
                    'subdomain' => 'lusem',
                    'baseuri' => '/',
                    'title' => 'School of Economics and Management',
                    'subtitle' => 'Lund University',
                    'locale' => 'en'
                );
                break;
        }

        if ($this->document) {
            // return localized configuration (after we merged the parameters with document properties)
            $configArr = (array_merge($config_params, $this->document->getProperties()));
            $websiteConfig = $this->document->setProperties($configArr);

            return $this->document->getProperties();
        }

        return;
    }

    /**
    * @deprecated
    * @return string
    */
    public function getSiteBaseUri()
    {
        $baseuri = "";

        if ($this->website['baseuri'] == '/') {
            $baseuri = '/';
        }
        else {
            $baseuri = $this->website['baseuri'] . '/';
        }

        return $baseuri;
    }

    /**
     * Get Navigation
     *
     * @param String $name  navigation name
     * @return array
     */
    protected function _getNavigation($name)
    {
        // Get website configuration object
        $website = ($this->document) ?
            $this->document->getProperty('website') :
            DataObject\Website::getByDomainName($this->getCanonicalDomainName(), ['limit' => 1]);

        if($website)
        {
            $multiHref = array();
            $navigationArr = array();

            // Getting language locale as a two letter string
            $l = substr($this->locale, 0, 2);

            // Getting Multi-Href (naivgation)
            switch(strtolower($name))
            {
                case 'shortcuts':
                    $multiHref = $website->getShortcuts($l);
                    break;
                case 'targetgroups':
                    $multiHref = $website->getTargetGroups($l);
                    break;
                case 'mainmenu':
                default:
                    $multiHref = $website->getMainMenu($l);
                    break;
            }

            // Preparing array
            foreach($multiHref as $href)
            {
                // Loading \Pimcore\Model\Document\Page by ID
                $page = \Pimcore\Model\Document::getById($href->getId());

                // Pushing label & uri to array
                $navigationArr[] = Array(
                    'label' => $page->getProperty('navigation_name'),
                    'uri'   => $page->getPath() . $page->getKey()
                );
            }

            $nav = $navigationArr;
        }
        else
        {
            \Pimcore\Log\Simple::log('debug', 'Could not find website object for domain name ' . $this->getCanonicalDomainName() . ' ' . __FILE__ . " Line: " . __LINE__);
        }

        // Returning navigation array
        return isset($nav) ? $nav : array();
    }

    protected function getMainNavigation()
    {
        return $this->_getNavigation('mainMenu');
    }

    protected function getShortcutsNavigation()
    {
        return $this->_getNavigation('shortcuts');
    }

    protected function getTargetGroupsNavigation()
    {
        return $this->_getNavigation('targetgroups');
    }

    /**
    * Redirects to error page
    */
    protected function redirectError()
    {
        $response = new Response();
        // $response->setContent('404 - Page not found');
        $response->setStatusCode(Response::HTTP_NOT_FOUND);
        $response->headers->set('HTTP/1.1', '404 Not Found', true);
        $response->send();
        $this->view->title = '404 - Page not found';
        $this->render('Content/error.html.php');
    }
}
