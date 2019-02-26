<?php

declare(strict_types=1);

/**
* Display image templating helper
*
* Tests if an image exists.
*
* Returns an image tag or an empty string if the remote image file does not exist.
*
* @author Jonas Ledendal <Jonas.Ledendal@har.lu.se>, M. Ali
*/

namespace AppBundle\Templating\Helper;

use Symfony\Component\Templating\Helper\Helper;

class DisplayImage extends Helper
{
    /**
    * @inheritDoc
    */
    public function getName()
    {
        return 'displayImage';
    }

    public function __invoke($src, $title = "", $class = "", $style = "")
    {

        // handle legacy code by stripping the dns from url
        $src = '/images/' . str_replace("http://static.ehl.lu.se/", '', $src);

        // return img-tag if the file exists on the server
        return (file_exists(strval(str_replace("\0", "", PIMCORE_WEB_ROOT . "/var/assets/" . $src))) === true) ?
        "<img alt=\"{$title}\" class=\"{$class}\" src=\"{$src}\" style=\"{$style}\" />" : '';
    }
}
