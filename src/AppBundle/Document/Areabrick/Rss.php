<?php

namespace AppBundle\Document\Areabrick;

use Pimcore\Extension\Document\Areabrick\AbstractTemplateAreabrick;
use Pimcore\Model\Document\Tag\Area\Info;

class Rss extends AbstractTemplateAreabrick
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
        return 'RSS-flöde';
    }

    /**
     * @inheritdoc
     */
    public function getVersion()
    {
        return '1.0';
    }

    public function hasEditTemplate()
    {
        return true;
    }

    // Other methods defined above!!!
    // Action method
    public function action(Info $info)
    {
        if($this->getDocumentTag($info->getDocument(), 'input', 'rss')->isEmpty()) {

            return;
        }

        // set conditions
        $heading = $this->getDocumentTag($info->getDocument(), 'input', 'heading')->getData();
        $rss = $this->getDocumentTag($info->getDocument(), 'input', 'rss')->getData();
        $brickName = $this->brick->name;
        $page = $info->getRequest()->get('page');
        $limit = $this->getDocumentTag($info->getDocument(), 'numeric', 'limit')->getData() ?
            $this->getDocumentTag($info->getDocument(), 'numeric', 'limit')->getData() : 10;
        $pagination = $this->getDocumentTag($info->getDocument(), 'checkbox', 'pagination')->getData();

        // Rss feed
        try {
            // load rss feed
            $rssFeed = (array) @simplexml_load_file($rss);
        }
        catch(\Exception $e) {
            // ops something went wrong
            $rssFeed = NULL;
            // Write a log to debug.log
            \Pimcore\Log\Simple::log('debug', $e->getMessage() . ' ' . __FILE__ . " Line: " . __LINE__);
        }

        // Convert rssFeed Object to rssFeedArray
        $rssFeedArray = [];
        $i = 0;
        foreach ($rssFeed['channel']->item as $item) {
            $title =        (string) $item->title;
            $description =  (string) $item->description;
            $link =         (string) $item->link;
            $pubDate =      (string) $item->pubDate;
            $creator =      (string) $item->xpath('//dc:creator')[$i];
            $i++;

            $rssFeedArray[] = [
                'title' => $title,
                'description' => $description,
                'link' => $link,
                'pubDate' => $pubDate,
                'creator' => $creator
            ];
        }

        // set limit if no pagination
        if (!$pagination) {
            $rssFeedArray = array_slice($rssFeedArray, 0, $limit);
        }

        // paginator
        if ($pagination) {
            $paginator = new \Zend\Paginator\Paginator(new \Zend\Paginator\Adapter\ArrayAdapter($rssFeedArray));
        }
        if ($paginator) {
            $paginator->setCurrentPageNumber($page);
            $paginator->setItemCountPerPage($limit);
            $paginator->setPageRange(5);

            // Make paginator avalible in view
            $info->getView()->paginator = $paginator;
        }
        else{
            // Make paginator avalible in view
            $info->getView()->paginator = null;
        }

        // Make variables avalible in view
        $info->getView()->heading = $heading;
        $info->getView()->brickName = $brickName;
        $info->getView()->rssFeed = $rssFeed;
        $info->getView()->rssFeedArray = $rssFeedArray;
        $info->getView()->pagination = $pagination;
    }
}
