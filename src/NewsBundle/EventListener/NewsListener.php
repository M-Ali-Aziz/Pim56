<?php
namespace NewsBundle\EventListener;
  
use Pimcore\Event\Model\ElementEventInterface;
use Pimcore\Event\System\MaintenanceEvent;
use Pimcore\Event\Model\DataObjectEvent;
use Pimcore\Event\Model\AssetEvent;
use Pimcore\Event\Model\DocumentEvent;
use \Pimcore\Model\DataObject;

class NewsListener {
     
    public function onNewsMaintenance (MaintenanceEvent $e)
    {
        NewsListener::clean();
    }

    public static function clean()
    {
        $time = time() - (1 * 24 * 60 * 60);

        $list = new DataObject\News\Listing();
        $list->setUnpublished(true);
        $list->setCondition(sprintf(
            "o_key LIKE '%s' AND o_modificationDate < %s", 'untitled%', $time));

        $list->load();
        foreach($list as $untitled) {
            // Remove untitled news older than one day
            $untitled->delete();
        }
    }

    public static function onNewsSlugifyName(ElementEventInterface $e)
    {
        if($e instanceof DataObjectEvent) {
            // Get current Object
            $object = $e->getObject();

            if (method_exists($object, 'getClassName')) {
                if ($object->getClassName() == 'News') {
                    $title = $object->getRubrik();
                    $key = NewsListener::slugify($title);

                    // checking if this key allready exists
                    $keyExist = true;
                    $index = 0;
                    while( $keyExist ) {
                        $list = new DataObject\News\Listing();
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

        // Swedish characters
        $text = str_replace(array('å','ä','Å','Ä'), 'a', $text);
        $text = str_replace(array('ö','Ö'), 'o', $text);

        // Replace non letter or digits by -
        $text = preg_replace('~[^\pL\d]+~u', '-', $text);

        // Transliterate
        $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);

        // Remove unwanted characters
        $text = preg_replace('~[^-\w]+~', '', $text);

        // Trim
        $text = trim($text, '-');

        // Remove duplicate -
        $text = preg_replace('~-+~', '-', $text);

        // Lowercase
        $text = strtolower($text);

        if (empty($text)) {
            return 'n-a';
        }

        return $text;
    }
}
