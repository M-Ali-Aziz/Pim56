<?php

namespace AppBundle\Website\OptionsProvider;

use Pimcore\Model\DataObject\ClassDefinition\Data;
use Pimcore\Model\DataObject\ClassDefinition\DynamicOptionsProvider\SelectOptionsProviderInterface;
use Pimcore\Model\DataObject;


class Lokal implements SelectOptionsProviderInterface
{
    /**
     * @param $context array
     * @param $fieldDefinition Data
     * @return array
     */
    public function getOptions($context, $fieldDefinition) {

        $lokals = new DataObject\Lokal\Listing();
        $lokals->setUnpublished(true);
        $lokals->setOrderKey("name");
        $lokals->setOrder("asc");

        foreach ($lokals as $lokal) {
            $venue["key"] = $lokal->getName();
            $venue["value"] = $lokal->getId();
            $venues[]= $venue;
        }

        return $venues;
    }

    /**
     * Returns the value which is defined in the 'Default value' field  
     * @param $context array
     * @param $fieldDefinition Data
     * @return mixed
     */
    public function getDefaultValue($context, $fieldDefinition) {
        return $fieldDefinition->getDefaultValue();
    }

    /**
     * @param $context array
     * @param $fieldDefinition Data
     * @return bool
     */
    public function hasStaticOptions($context, $fieldDefinition) {
        return true;
    }

}