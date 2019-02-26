<?php
namespace LucrisBundle\EventListener;
  
use Pimcore\Event\Model\ElementEventInterface;
use Pimcore\Event\System\MaintenanceEvent;
use Pimcore\Event\Model\DataObjectEvent;
use Pimcore\Event\Model\AssetEvent;
use Pimcore\Event\Model\DocumentEvent;
use LucrisBundle\Model;

/**
 * This is the class that contain the MaintenanceJob function for Lucris Sync.
 */
class LucrisListener {
     
    public function onLucrisMaintenance (MaintenanceEvent $e)
    {
        // Connenct to Pimcore DB
        $db = \Pimcore\Db::get();
        $className = 'LucrisPerson';

        // - (1 day; 24 hours; 60 mins; 60 secs)
        $last24hours = time() - (1 * 24 * 60 * 60);

        // Check if the folder(paretId) allredy exists 
        $query = sprintf("SELECT o_parentId FROM objects WHERE o_path LIKE '%%%s%%' LIMIT 0,1", $className);
        $o_parentId = $db->fetchAll($query);
        // Get parentId
        $parentId = (int) $o_parentId[0]['o_parentId'];

        // Get last modification date from Pimcore DB
        $query = sprintf("SELECT o_modificationDate FROM objects WHERE o_className LIKE '%%%s%%' LIMIT 0,1", $className);
        $o_modificationDate = $db->fetchAll($query);
        // Get parentId
        $modificationDate = (int) $o_modificationDate[0]['o_modificationDate'];

        if ($parentId) {
            if ($modificationDate < $last24hours) {
                // Sync Lucris Person
                try {
                    $sync = new Model\PersonProvider();
                    $sync->createPersons($parentId);
                } catch (\Exception $e) {
                    // Add log to lucris.log
                    \Pimcore\Log\Simple::log("lucris", "Lucris.ERROR: Failed to sync Lucris." . __FILE__ . " Line: " . __LINE__); 
                    return $e->getMessage();
                }

                // Add log to lucris.log
                \Pimcore\Log\Simple::log("lucris", "Lucris.INFO: successfully synced Lucris(onLucrisMaintenance). " . __FILE__ . " Line: " . __LINE__);
            }
            else {
                // Add log to lucris.log
                \Pimcore\Log\Simple::log("lucris", "Lucris.INFO: Failed to sync Lucris. Lucris was uppdated in last 24h! " . __FILE__ . " Line: " . __LINE__);
            }
        } else {
            // Add log to lucris.log
                \Pimcore\Log\Simple::log("lucris", "Lucris.ERROR: Failed to sync Lucris. NO parentId found " . __FILE__ . " Line: " . __LINE__);
        }
    }
}