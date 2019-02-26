<?php

namespace AppBundle\Document\Areabrick;

use Pimcore\Extension\Document\Areabrick\AbstractTemplateAreabrick;
use Pimcore\Model\Document\Tag\Area\Info;
use \Pimcore\Model\DataObject;

class NewsVertical extends AbstractTemplateAreabrick
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
        return 'Nyheter';
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
        return '/bundles/pimcoreadmin/img/icon/newspaper.png';
    }

    public function hasEditTemplate()
    {
        return true;
    }

    // Other methods defined above!!!
    // Action method
    public function action(Info $info)
    {
        // get property values
        $language   = $info->getDocument()->getProperty('language');
        $webbplats  = $this->getDocumentTag($info->getDocument(), 'select', 'webbplats')->getData();

        // condition
        $condition   = strtoupper($language) . " = 1 AND " .
                        "Webb LIKE '%" . $webbplats . "%'";

        $match = str_replace(',', '|', \Pimcore\Tool\Frontend::getWebsiteConfig()->newsSiteStartpage);
        if($info->getView()->startsite && strlen($match) && preg_match('/('.$match.')/',$webbplats)) {
            $condition .= " AND Startpage = 1";
        }

        $newsTop     = ($info->getView()->newsTop) ? 1 : 0;
        $itemsPerRow = ($info->getView()->itemsPerRow) ? $info->getView()->itemsPerRow : 3;
        $limit       = $itemsPerRow + $newsTop;

        // listing
        $newsList = new DataObject\News\Listing();
        $newsList->setOrderKey('o_creationDate');
        $newsList->setOrder('desc');
        $newsList->setLimit($limit);
        $newsList->setCondition($condition);

        // pass data to view
        $info->getView()->newsList   = $newsList;
        $info->getView()->color      = ($color = $this->getDocumentTag($info->getDocument(), 'select', 'color')->getData()) ? $color : 'bg_beige';
        $info->getView()->sammanfattning = (int)$this->getDocumentTag($info->getDocument(), 'select', 'sammanfattning')->getData();
    }
}
