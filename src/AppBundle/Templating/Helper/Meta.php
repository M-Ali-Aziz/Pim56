<?php

declare(strict_types=1);

/**
 *
 * Meta Templating Helper
 *
 * Outputs social media metas and making sure they are not NULL
 *
 * @author Jimmi Elofsson <hi@jimmi.eu>, M. Ali
 *
 */

namespace AppBundle\Templating\Helper;

use Symfony\Component\Templating\Helper\Helper;
use \Pimcore\Templating\Helper\HeadMeta;

class Meta extends Helper
{
    /**
    * @inheritDoc
    */
    public function getName()
    {
        return 'meta';
    }

    public function __invoke(HeadMeta $headMeta, $meta = array())
    {
        // Twitter Card data
        /*
        <meta name="twitter:card" content="summary_large_image">
        <meta name="twitter:site" content="@publisher_handle">
        <meta name="twitter:title" content="Page Title">
        <meta name="twitter:description" content="Page description less than 200 characters">
        <meta name="twitter:creator" content="@author_handle">
        <!-- Twitter summary card with large image must be at least 280x150px -->
        <meta name="twitter:image:src" content="http://www.example.com/image.jpg">
        */
        if(isset($meta->twitter) && is_array($meta->twitter)){
            foreach($meta->twitter as $name => $content) {
                if($content) {
                    $headMeta->setName('twitter:'.$name, $content);
                }
            }
        }

        // Open Graph data
        /*
        <meta property="og:title" content="Title Here" />
        <meta property="og:type" content="article" />
        <meta property="og:url" content="http://www.example.com/" />
        <meta property="og:image" content="http://example.com/image.jpg" />
        <meta property="og:description" content="Description Here" />
        <meta property="og:site_name" content="Site Name, i.e. Moz" />
        <meta property="article:published_time" content="2013-09-17T05:59:00+01:00" />
        <meta property="article:modified_time" content="2013-09-16T19:08:47+01:00" />
        <meta property="article:section" content="Article Section" />
        <meta property="article:tag" content="Article Tag" />
        <meta property="fb:admins" content="Facebook numberic ID" />
        */
        if(isset($meta->opengraph) && is_array($meta->opengraph)){
            foreach($meta->opengraph as $property => $content) {
                if($content){
                    $headMeta->setProperty($property, $content);
                }
            }
        }
        echo $headMeta;

        // Schema.org markup for Google+
        /*
        <meta itemprop="name" content="The Name or Title Here">
        <meta itemprop="description" content="This is the page description">
        <meta itemprop="image" content="http://www.example.com/image.jpg">
        */
        if(isset($meta->googleplus) && is_array($meta->googleplus)){
            foreach($meta->googleplus as $itemprop => $content) {
                if($content){
                    ?>
                        <meta itemprop="<?php echo $itemprop; ?>" content="<?php echo $content; ?>">
                    <?php
                }
            }
        }
    }
}
