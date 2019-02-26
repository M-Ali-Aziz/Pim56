<?php

namespace NewsBundle;

use Pimcore\Extension\Bundle\AbstractPimcoreBundle;

class NewsBundle extends AbstractPimcoreBundle
{
    public function getVersion()
    {
        return '1.0.0';
    }

    public function getDescription()
    {
        return 'News grid-panels';
    }

    public function getCssPaths()
    {
        return [
            '/bundles/news/css/news.css'
        ];
    }

    public function getJsPaths()
    {
        return [
            '/bundles/news/js/news.js',
            '/bundles/news/js/news-gridpanel.js'
        ];
    }
}
