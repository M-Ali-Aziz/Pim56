<?php

namespace AppBundle\Document\Areabrick;

use Pimcore\Extension\Document\Areabrick\AbstractTemplateAreabrick;
use Pimcore\Model\Document\Tag\Area\Info;

class Startpuff extends AbstractTemplateAreabrick
{
    /**
     * @inheritdoc
     */
    public function getTemplateLocation()
    {
        return static::TEMPLATE_LOCATION_GLOBAL;
    }

    /**
     * @inheritdoc
     */
    public function getName()
    {
        return 'Puff';
    }

    /**
     * @inheritdoc
     */
    public function getVersion()
    {
        return '1.0';
    }

    /**
     * @inheritdoc
     */
    public function getIcon()
    {
        return '/bundles/pimcoreadmin/img/icon/picture.png';
    }

    public function hasEditTemplate()
    {
        return true;
    }

    // Other methods defined above!!!
    // Action method
    public function action(Info $info)
    {
        $itemsPerRow = ($info->getView()->itemsPerRow) ? $info->getView()->itemsPerRow : 3;
        
        //get each element from the startpuff areablock
        $indices = $info->getTag()->indices;

        $column = 0;
        $gutters = [];
        foreach($indices as $indice) 
        {
            if($column>=$itemsPerRow)
                $column = 0;

            switch($column)
            {
                case 0:
                    $class = 'alpha';
                    break;
                case $itemsPerRow-1:
                    $class = 'omega';
                break;
                default:
                    $class = '';
                break;
            }

            array_push($gutters, $class);
            $column++;
        }

        //assign parameter gutters to view
        $info->getView()->gutters = $gutters;
    }
}
