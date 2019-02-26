<?php

declare(strict_types=1);

/**
* Page content manager templating helper
*
* View helper fetches and returns a link with the page's user owner
* mail.
*
* @author Jonas Ledendal, M. Ali
*
*/

namespace AppBundle\Templating\Helper;

use Symfony\Component\Templating\Helper\Helper;
use \Pimcore\Model\User;

class PageManager extends Helper
{
    /**
    * @inheritDoc
    */
    public function getName()
    {
        return 'pageManager';
    }

    public function __invoke($view)
    {
        if ($view->document) {
            $uid = $view->document->getProperty('pageManager');
            $user = User::getByName($uid);
        }

        if($user) {
            //get page content manager first and last names
            //$pageManager = $user->getFirstname(). ' ' . $user->getLastname();
            $pageManager = $user->getEmail();
            // get page content manager mail
            $mail = $user->getEmail();
        }
        else {
            // if user does not exist we default to webmaster
            $pageManager = $view->translate('Webmaster');
            $mail = $_SERVER['SERVER_ADMIN'];
        }

        return '<a href="mailto:' . $mail . '">' . $pageManager . '</a>';
    }
}
