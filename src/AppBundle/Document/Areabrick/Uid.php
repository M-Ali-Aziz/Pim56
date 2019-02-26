<?php

namespace AppBundle\Document\Areabrick;

use Pimcore\Extension\Document\Areabrick\AbstractTemplateAreabrick;
use Pimcore\Model\Document\Tag\Area\Info;
use \Pimcore\Model\DataObject;

class Uid extends AbstractTemplateAreabrick
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
        return 'Medarbetare';
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
        return '/bundles/pimcoreadmin/img/flat-color-icons/manager.svg';
    }

    public function hasEditTemplate()
    {
        return true;
    }

    // Other methods defined above!!!
    // Action method
    public function action(Info $info)
    {
        //get staff object from faculty database
        try {
            // Get Uid
            $uid = $this->getDocumentTag($info->getDocument(), 'input', 'uid')->getData();
            // Assign employee to view
            $info->getView()->employee = DataObject\LucatPerson::getByUid($uid, ['limit' => 1,'unpublished' => true]);
        }
        catch(\Exception $e) {
            $info->getView()->employee = null;
        }

        // Set language
        $language = $info->getDocument()->getProperty('language');
        //assign parameters to view
        $info->getView()->language = $language;
    }
}
