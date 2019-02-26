<?php

namespace LucrisBundle\Model;

use \Pimcore\Model\DataObject;

/**
* This class gets all Organisations at EHL/LUSEM from
* Lucris_organisations config file ( var -> bundles -> LucrisBundle ).
* and creating a Pimcore DataObject in LucrisOrganiation Object.
*
* @copyright  Copyright (c) 2018 Ekonomihögskolan (http://ehl.lu.se).
* @author Mohammed Ali
*/
class OrganisationProvider
{
    protected $parentId;
    protected $organisations;
    protected $timeNow;
    protected $lucrisConfigPath = PIMCORE_PRIVATE_VAR . '/bundles/LucrisBundle/lucris_config.php';

    /**
    * Create Organisations.
    * @param integer - LucrisOrganisation folder Id on Pimcore admin page > Objects
    */
    public function createOrganisations($parentId) {
        $this->parentId = $parentId;
        return $this->createOrganisationArray();
    }

    /**
    * Get all Organisations at EHL/LUSEM.
    * @return array
    */
    protected function createOrganisationArray() {
        // Get lucris:organisations config file
        $lucrisConfigPath = $this->lucrisConfigPath;
        if(file_exists($lucrisConfigPath)) {
            $lucrisConfigFile = require $lucrisConfigPath;
        }
        else {
            // Add log to lucris.php
            \Pimcore\Log\Simple::log("lucris", "LUCRIS ERROR: Failed to get lucris config file " . __FILE__ . " Line: " . __LINE__);
            // Exception
            throw new \Exception("LUCRIS ERROR: Failed to get lucris config file\n");
        }

        // Set organisations
        $this->organisations = $lucrisConfigFile['organisations'];
        // Run createLucrisOrganisationObject function
        return $this->createLucrisOrganisationObject($this->organisations);
    }

    /**
     * Create a Pimcore DataObject of Lucris Organisations (LucrisOrganisation DataObject).
     * @param array - all Organisations that needs to be created,updated and saved
     */
    protected function createLucrisOrganisationObject($organisations){
        if ($organisations) {
            // Admin page > Objects > LucrisOrganisation Folder ID
            $parentId = $this->parentId;
            $published = 1;

            // Get the valid languages
            $config = \Pimcore\Config::getSystemConfig();
            $languages = explode(',', $config->general->validLanguages);

            // Connenct to Pimcore DB
            $db = \Pimcore\Db::get();

            // Time now - to have it with the printed massage
            $this->timeNow = "[" . date("Y-m-d H:i:s") . "] ";

            foreach ($organisations as $org) {
                // PortalURL
                $portalUrl_sv = str_replace('/en/', '/sv/', $org['portalUrl']);
                $portalUrl_en = $org['portalUrl'];

                // Check if the organisation allredy exists 
                $query = sprintf('SELECT o_id FROM objects WHERE o_parentId=%s AND o_key="%s" LIMIT 0,1', $parentId, $org['sourceId']);
                $oIdExisting = $db->fetchAll($query);
                // Get o_id
                $o_id = (int) $oIdExisting[0]['o_id'];

                if ($o_id) {
                    // Update organisation data
                    $lucrisOrganisationList = DataObject\LucrisOrganisation::getById($o_id);

                    $values = [
                        'uuid' => $org['id'],
                        'sourceId' => $org['sourceId']
                    ];
                    $lucrisOrganisationList->setValues($values);
                    $lucrisOrganisationList->setName($org['name_sv'], $languages[0]);
                    $lucrisOrganisationList->setName($org['name_en'], $languages[1]);
                    $lucrisOrganisationList->setPortalUrl($portalUrl_sv, $languages[0]);
                    $lucrisOrganisationList->setPortalUrl($portalUrl_en, $languages[1]);
                    $lucrisOrganisationList->save();

                    // Print a message
                    print ($this->timeNow . 'LUCRIS INFO: organisation with sourceId:[' . $org["sourceId"] .  '] WAS updated'  . "\xA");
                }
                else {
                    // Create new organisation and save it to LucrisOrganisation Object
                    $newLucrisOrganisationObject = new DataObject\LucrisOrganisation();

                    $values = [
                        'o_parentId' => $parentId,
                        'o_key' => $org['sourceId'],
                        'o_published' => $published,
                        'uuid' => $org['id'],
                        'sourceId' => $org['sourceId']
                    ];
                    $newLucrisOrganisationObject->setValues($values);
                    $newLucrisOrganisationObject->setName($org['name_sv'], $languages[0]);
                    $newLucrisOrganisationObject->setName($org['name_en'], $languages[1]);
                    $newLucrisOrganisationObject->setPortalUrl($portalUrl_sv, $languages[0]);
                    $newLucrisOrganisationObject->setPortalUrl($portalUrl_en, $languages[1]);
                    $newLucrisOrganisationObject->save();

                    // Print a message
                    print ($this->timeNow . 'LUCRIS INFO: New organisation with sourceId:[' . $org["sourceId"] .  '] WAS created AND saved'  . "\xA");

                }
            }
        }
    } 
}