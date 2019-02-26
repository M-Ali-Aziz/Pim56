<?php

namespace LucrisBundle;

use Pimcore\Extension\Bundle\AbstractPimcoreBundle;

class LucrisBundle extends AbstractPimcoreBundle
{
    public function getNiceName()
    {
        return 'LucrisBundle';
    }

    public function getVersion()
    {
        return '1.0.0';
    }

    public function getDescription()
    {
        return 'Research Portal Bundle';
    }

    public function getCssPaths()
    {
        return [
            '/bundles/lucris/css/lucris.css'
        ];
    }

    public function getJsPaths()
    {
        return [
            '/bundles/lucris/js/lucris-sync.js',
            '/bundles/lucris/js/lucris.js'
        ];
    }
}
