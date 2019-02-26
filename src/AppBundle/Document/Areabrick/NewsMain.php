<?php

namespace AppBundle\Document\Areabrick;

use Pimcore\Extension\Document\Areabrick\AbstractTemplateAreabrick;
use Pimcore\Model\Document\Tag\Area\Info;
use \Pimcore\Model\DataObject;

class NewsMain extends AbstractTemplateAreabrick
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
        return '/bundles/pimcoreadmin/img/flat-color-icons/news.svg';
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
        $language    = $info->getDocument()->getProperty('language');
        $limit       = ($limit = $this->getDocumentTag($info->getDocument(), 'select', 'limit')->getData()) ? $limit : 10;
        $webbplats   = $this->getDocumentTag($info->getDocument(), 'select', 'webbplats')->getData();
        $paging      = $this->getDocumentTag($info->getDocument(), 'checkbox', 'paging')->getData();
        $page = $info->getRequest()->get('page');

        // condition
        $condition   = strtoupper($language) . " = 1 AND " .
                        "Webb LIKE '%" . $webbplats . "%'";

        $match = str_replace(',', '|', \Pimcore\Tool\Frontend::getWebsiteConfig()->newsSiteStartpage);
        if($info->getView()->startsite && strlen($match) && preg_match('/('.$match.')/',$webbplats)) {
            $condition .= " AND Startpage = 1";
        }

        // listing
        $newsList = new DataObject\News\Listing();
        $newsList->setOrderKey('o_creationDate');
        $newsList->setOrder('desc');
        $newsList->setLimit($limit);
        $newsList->setCondition($condition);

        //paging
        try {
            if ($paging) {
                $paginator = new \Zend\Paginator\Paginator($newsList);
                $paginator->setCurrentPageNumber($page);
                $paginator->setItemCountPerPage($limit);
                $paginator->setPageRange(5);
            }
        }
        catch(\Exception $e) {
            $paging = false;
            $paginator = null;
        }

        // pass data to view
        $info->getView()->newsList = $newsList;
        $info->getView()->paginator = $paginator;
        $info->getView()->paging = $paging;
    }
}
