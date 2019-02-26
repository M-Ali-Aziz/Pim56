<?php

declare(strict_types=1);

/**
* Language Selector Templating Helper
*
* View helper returns a link that allows the user to switch the site's
* locale and language between Swedish and English.
*
* The view helper is using the website configuration object to determine
* which languages to toggle between and which language is the main language.
*
* The language component is stripped from the uri for the main language
* site so that it can be accessed directly from the site root.
*
* @package LUSEM
* @author Jonas Ledendal <Jonas.Ledendal@har.lu.se>, M. Ali
* @version 3.0
*/

namespace AppBundle\Templating\Helper;

use Symfony\Component\Templating\Helper\Helper;
use Pimcore\Tool;

class LanguageSelector extends Helper
{
    /**
    * @inheritDoc
    */
    public function getName()
    {
        return 'languageSelector';
    }

    public function __invoke($view)
    {
        $html = "";
        $uri  = "";
        $locales = Tool::getValidLanguages();
        $target_locale = null;
        $current_locale = $view->language;

        if(count($locales) < 2 ) {
            return "";
        }

        // getting a locale that is not equal to $current_locale (from available $locales)
        $target_locale = array_filter($locales, function($l) use($current_locale){
            return ($l != $current_locale);
        });

        // Target Language
        $language = array_values($target_locale)[0];

        //special case for LUSEM faculty site
        if ($view->website['canonicaldomainname'] == 'ehl.lu.se' ||
            $view->website['canonicaldomainname'] == 'lusem.lu.se') {
            $uri = ($language == 'sv') ? 'http://www.ehl.lu.se' : 'http://www.lusem.lu.se';
        }
        else {
            $languages = $view->website['languages'];
            // building uri string based on website object values
            $uri = ((substr($view->website['domainname'], 0, 4) !== 'http') ? 'http://' : '')
                . $view->website['domainname']
                . ((substr($view->website['domainname'], -1) !== '/') &&
                    (substr($languages[$language]['baseuri'], 0, 1) !== '/') ? '/' : '')
                . $languages[$language]['baseuri'];
        }

        //construct language selector link
        return $html = '<a href="' . $uri . '">' . $view->translate('language') . '</a>';
    }

    protected function getMainLocale()
    {
        return Tool::getValidLanguages()[0];
    }
}
