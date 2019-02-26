<?php

declare(strict_types=1);

/**
* Page last updated templating helper
*
* View helper returns formatted and translated page modification date.
*
* @author Jonas Ledendal, M. Ali
*
*/

namespace AppBundle\Templating\Helper;

use Symfony\Component\Templating\Helper\Helper;

class PageLastUpdated extends Helper
{
    /**
    * @inheritDoc
    */
    public function getName()
    {
        return 'pageLastUpdated';
    }

    public function __invoke($view)
    {
        // get page language
        $language = $view->document->getProperty('language');

        //$date = date('j F Y', $view->document->getModificationDate());
        $date = date('Y-m-d', $view->document->getModificationDate());

        switch($language) {
            case 'sv':
            //FIXME: Figure out how to do this with built-in Zend Framework translation/locale./JL
            $date = str_replace(
                array('January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'),
                array('januari', 'februari', 'mars', 'april', 'maj', 'juni', 'juli', 'augusti', 'september', 'oktober', 'november', 'december'),
                $date
            );
            break;
            default:
            //$date = date('F j, Y', $view->document->getModificationDate());
        }

        return $date;
    }
}
