<?php
namespace EventsBundle\EventListener;

use Pimcore\Event\Model\ElementEventInterface;
use Pimcore\Event\Model\DataObjectEvent;
use Pimcore\Event\Model\AssetEvent;
use Pimcore\Event\Model\DocumentEvent;
use \Pimcore\Model\DataObject;

/**
 * This is the class that contain the EventListener functions for Events DataObjact.
 */
class EventsListener {
     
    public function onEventsSlugifyName (ElementEventInterface $e)
    {
        if($e instanceof DataObjectEvent) {
            // Get current Object
            $object = $e->getObject();

            if (method_exists($object, 'getClassName')) {
                if ($object->getClassName() == 'Events') {
                    $title = $object->getRubrik();
                    $key = $this->slugify($title);

                    // checking if this key allready exists
                    $keyExist = true;
                    $index = 0;
                    while( $keyExist ) {
                        $list = new DataObject\Events\Listing();
                        $list->setUnpublished(true);
                        $list->setCondition('oo_id <> ? AND o_key = ?',
                            [$object->getId(), $key . (($index) ? '-' . $index : '')]);
                        $list->load();

                        if($list->getObjects()) {
                            $index++;
                        }
                        else{
                            $keyExist = false;
                        }
                    }

                    // Set the Key and Save the Object
                    $object->setKey(($index) ? $key . '-' . $index : $key);
                    $e->setObject($object);
                }
            }
        } 
        
        return TRUE;
    }

    static public function slugify($text)
    {

        // swedish characters
        $text = str_replace(array('å','ä','Å','Ä'), 'a', $text);
        $text = str_replace(array('ö','Ö'), 'o', $text);

        // replace non letter or digits by -
        $text = preg_replace('~[^\pL\d]+~u', '-', $text);

        // transliterate
        $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);

        // remove unwanted characters
        $text = preg_replace('~[^-\w]+~', '', $text);

        // trim
        $text = trim($text, '-');

        // remove duplicate -
        $text = preg_replace('~-+~', '-', $text);

        // lowercase
        $text = strtolower($text);

        if (empty($text)) {
            return 'n-a';
        }

        return $text;
    }
}