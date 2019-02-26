<?php

namespace EventsBundle;

use Pimcore\Extension\Bundle\AbstractPimcoreBundle;

class EventsBundle extends AbstractPimcoreBundle
{
    public function getVersion()
    {
        return '1.0.0';
    }

    public function getDescription()
    {
        return 'Events grid-panels';
    }

    public function getCssPaths()
    {
        return [
            '/bundles/events/css/events.css'
        ];
    }

    public function getJsPaths()
    {
        return [
            '/bundles/events/js/events.js',
            '/bundles/events/js/events-gridpanel.js'
        ];
    }
}
