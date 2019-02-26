<?php

namespace LucatBundle;

use Pimcore\Extension\Bundle\AbstractPimcoreBundle;

class LucatBundle extends AbstractPimcoreBundle
{
    public function getNiceName()
    {
        return 'LucatBundle';
    }

    public function getVersion()
    {
        return '1.0.0';
    }

    public function getDescription()
    {
        return 'Syncronize data from LucatOpen';
    }

    public function getCssPaths()
    {
        return [
            '/bundles/lucat/css/lucat.css'
        ];
    }

    public function getJsPaths()
    {
        return [
            '/bundles/lucat/js/lucat.js',
            '/bundles/lucat/js/lucat-sync.js',
            '/bundles/lucat/js/lucat-gridpanel.js'
        ];
    }
}
