<?php
namespace LucatBundle\EventListener;
  
use Pimcore\Event\Model\ElementEventInterface;
use Pimcore\Event\System\MaintenanceEvent;
use Pimcore\Event\Model\DataObjectEvent;
use Pimcore\Event\Model\AssetEvent;
use Pimcore\Event\Model\DocumentEvent;
use LucatBundle\Model;

/**
 * This is the class that contain the MaintenanceJob function for Lucat Sync.
 */
class LucatListener {
     
    public function onLucatMaintenance (MaintenanceEvent $e)
    {
        // Connenct to Pimcore DB
        $db = \Pimcore\Db::get();
        $className = 'LucatPerson';

        // - (1 day; 24 hours; 60 mins; 60 secs)
        $last24hours = time() - (1 * 24 * 60 * 60);

        // Get last modification date from Pimcore DB
        $query = sprintf("SELECT o_modificationDate FROM objects WHERE o_className LIKE '%%%s%%' LIMIT 0,1", $className);
        $o_modificationDate = $db->fetchAll($query);
        // Get parentId
        $modificationDate = (int) $o_modificationDate[0]['o_modificationDate'];

        // If Lucat data not synced since last 24 hours
        if ($modificationDate < $last24hours) {
            // Sync Lucat
            try {
                // Sync Lucat Organisation
                $syncOrganisation = new Model\OrganisationProvider();
                $syncOrganisation->SynchronizeLucatOrganisation();

                // Sync Lucat Roll
                $syncRoll = new Model\RollProvider();
                $syncRoll->SynchronizeLucatRoll();

                // Sync Lucat Person
                $syncPerson = new Model\PersonProvider();
                $syncPerson->SynchronizeLucatPerson();

                // Add log to lucat.log
                \Pimcore\Log\Simple::log("lucat", "Lucat.INFO: Successfully synced Lucat(onLucatMaintenance). " . __FILE__ . " Line: " . __LINE__);

            } catch (Exception $e) {
                // Add log to lucat.log
                \Pimcore\Log\Simple::log("lucat", "Lucat.ERROR: " . $e->getMessage() . " " . __FILE__ . " Line: " . __LINE__);

                echo $e->getMessage();   
            }
        } else {
            // Add log to lucat.log
                \Pimcore\Log\Simple::log("lucat", "Lucat.INFO: Failed to sync Lucat. Lucat was uppdated in last 24h! " . __FILE__ . " Line: " . __LINE__);
        }
    }
}