<?php

namespace AppBundle\Document\Areabrick;

use Pimcore\Extension\Document\Areabrick\AbstractTemplateAreabrick;
use Pimcore\Model\Document\Tag\Area\Info;
use \Pimcore\Model\DataObject;

class EventsBlock extends AbstractTemplateAreabrick
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
        return 'Kalender';
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
        return '/bundles/pimcoreadmin/img/flat-color-icons/calendar.svg';
    }

    public function hasEditTemplate()
    {
        return true;
    }

    // BuildStatement method
    protected function buildStatement($conditions)
    {
        $statement = "";

        $list = array();
        foreach($conditions as $i => $value) {
            if ($value) {
                array_push($list, trim($value));
            }
        }

        foreach($list as $i => $value) {
            $statement .= $value;
            if ($list[$i+1]) $statement .= " AND ";
        }

        return $statement;
    }

    // Other methods defined above!!!
    // Action method
    public function action(Info $info)
    {
        //get property from area brick
        $webbplats = $this->getDocumentTag($info->getDocument(), 'select', 'webbplats')->getData();
        $kategori = $this->getDocumentTag($info->getDocument(), 'select', 'kategori')->getData();
        $serie = $this->getDocumentTag($info->getDocument(), 'select', 'serie')->getData();
        $limit = $this->getDocumentTag($info->getDocument(), 'select', 'limit')->getData();
        if(empty($limit)) $limit = 6;

        //get language property from document
        $language = $info->getDocument()->getProperty('language');

        try {
            //fetch events feed as events list object
            $eventList = new DataObject\Events\Listing();
            $eventList->setOrderKey('Start');
            $eventList->setOrder('asc');
            $eventList->setLimit($limit);

            //set conditions for filtering
            $params = array();
            $conditions = array();
            $statement = "";

            array_push($conditions, "TO_DAYS(FROM_UNIXTIME(End)) >= TO_DAYS(NOW())");

            if($webbplats) {
                array_push($conditions, "Webb LIKE ?");
                array_push($params, "%".$webbplats."%");
            }

            if($kategori) {
                array_push($conditions, "Category LIKE ?");
                array_push($params, "%".$kategori."%");
            }

            if($serie) {
                array_push($conditions, "Serie LIKE ?");
                array_push($params, "%".$serie."%");
            }

            if ($language == 'en'){
                array_push($conditions, "EN = 1");
            }
            if ($language == 'sv'){
                array_push($conditions, "SV = 1");
            }

            $statement = $this->buildStatement($conditions);

            if ($statement) $eventList->setCondition($statement, $params);

            if ($eventList->count() == 0) $eventList = null;

        }
        catch(\Exception $e) {
            $eventList = null;
        }

        //assign object/parameter to view
        $info->getView()->eventList = $eventList;
        $info->getView()->language = $language;
    }
}
