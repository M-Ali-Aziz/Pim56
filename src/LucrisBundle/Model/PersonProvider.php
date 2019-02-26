<?php
namespace LucrisBundle\Model;

use LucrisBundle\Model\XMLParser;
use \Pimcore\Model\DataObject;
use \Pimcore\Model\Asset;
use \Pimcore\Model\Element;

/**
* This class gets all Person/Researchers at EHL/LUSEM from Lucris/Pure
* and creating a Pimcore DataObject of Person/Researchers in LucrisPerson DataObject.
*
* @link https://lucris.lub.lu.se/ws/doc/ - Pure web service.
* @link https://pimcore.com/docs/4.6.x/Objects/index.html - Pimcore Objects Doc.
* @copyright  Copyright (c) 2018 Ekonomihögskolan (http://ehl.lu.se).
* @author Mohammed Ali
*/
class PersonProvider
{
    protected $baseUrl;
    protected $basePersonOrgUrl = "/person.current?associatedOrganisationUuids.uuid=";
    protected $orgId;
    // protected $basePersonUrl = "/person.current?uuids.uuid=";
    // protected $personUrlSuffix1 = "&rendering=xml_long";
    protected $personUrlSuffix2 = "&window.size=";
    protected $personTotal;
    protected $lucrisConfigPath = PIMCORE_PRIVATE_VAR . '/bundles/LucrisBundle/lucris_config.php';
    protected $persons;
    protected $personItems;
    protected $parentId;
    protected $timeNow;

    /**
    * Create Person/Researchers.
    * @param integer - LucrisPerson folder Id on Pimcore admin page > Objects
    */
    public function createPersons($parentId)
    {
        $this->parentId = $parentId;
        return $this->createPersonArray();
    }

    /**
    * Get all Person/Researchers at EHL/LUSEM.
    * @return array
    */
    protected function createPersonArray()
    {
        // Get config file
        $lucrisConfigPath = $this->lucrisConfigPath;
        if(file_exists($lucrisConfigPath)) {
            $lucrisConfigFile = require $lucrisConfigPath;
        }

        // Time now - to have it with the printed massage
        $this->timeNow = "[" . date("Y-m-d H:i:s") . "] ";


        if ($lucrisConfigFile) {
            $baseUrl = $this->baseUrl = $lucrisConfigFile['base_url'];
            foreach ($lucrisConfigFile['organisations'] as $org) {
                // Organisations ID
                $orgId = $this->orgId = $org['id'];
                //Set persons/researcher total
                $this->setPersonTotal();

                if ($this->personTotal > 0) {
                    $url = $baseUrl .  $this->basePersonOrgUrl . $orgId . $this->personUrlSuffix2;
                    // Add personTotal to the url ( &window.size= )
                    $url = $url . $this->personTotal;

                    /**
                    * Get all persons/researcher at EHL/LUSEM
                    * @param string - $url from Lucris/Pure REST service
                    * @return Array - $persons all persons/researcher - EHL/LUSEM
                    */
                    $parser = new XMLParser($url);
                    if ($parser->validResults()) {
                        $parser->mapPersonData();
                        $this->persons[] = $parser->getPersonItems();
                    }
                    else{
                        // Add log to lucris.php
                        \Pimcore\Log\Simple::log("lucris", "LUCRIS ERROR: Not a valid result from XMLParser " . __FILE__ . " Line: " . __LINE__);
                        // Exception
                        throw new \Exception("LUCRIS ERROR: Not a valid result from XMLParser\n");
                    }
                }
                else{
                    // Add log to lucris.php
                    \Pimcore\Log\Simple::log("lucris", "LUCRIS ERROR: Failed to count persons " . __FILE__ . " Line: " . __LINE__);
                    // Exception
                    throw new \Exception("LUCRIS ERROR: Failed to count persons\n");
                }
            }
            // Create Person/Researchers necessary data
            // and save to LucrisPerson Object
            $this->createLucrisPersonObject($this->persons);
        }
        else {
            // Add log to lucris.php
            \Pimcore\Log\Simple::log("lucris", "LUCRIS ERROR: Failed to get lucris config file " . __FILE__ . " Line: " . __LINE__);
            // Exception
            throw new \Exception("LUCRIS ERROR: Failed to get lucris config file\n");
        }
    }

    /**
    * Get the total number of Person/Researchers in a specific organisation.
    * @return integer
    */
    private function setPersonTotal()
    {
        $url = $this->baseUrl .  $this->basePersonOrgUrl . $this->orgId . $this->personUrlSuffix2 . 1;
        $parser = new XMLParser($url);
        if ($parser->validResults()) {
            $this->personTotal = (int) $parser->count();
        }
    }

    /**
     * Create a Pimcore DataObject of  Person/Researchers (LucrisPerson DataObject).
     * @param array - all Persons/Researchers that needs to be created,updated and saved
     */
    protected function createLucrisPersonObject($personItems)
    {
        if ($personItems) {
            // Admin page > Objects > LucrisPerson Folder ID
            $parentId = $this->parentId;
            $published = 1;

            // Get teh valid languages
            $config = \Pimcore\Config::getSystemConfig();
            $languages = explode(',', $config->general->validLanguages);

            $personOrgs = new DataObject\LucrisOrganisation\Listing();
            $personOrgsArr = [];
            foreach ($personOrgs as $personOrg) {
                $personOrgsArr[] = $personOrg->getSourceId();
            }

            // Connenct to Pimcore DB
            $db = \Pimcore\Db::get();

            foreach ($personItems as $p) {
                foreach ($p as $person) {
                    // Get person photo from Asset
                    $photo = NULL;
                    if (file_exists(PIMCORE_ASSET_DIRECTORY . "/images/staff/" . $person['uid'] . ".jpg")) {
                        $photo = Asset\Image::getByPath("/images/staff/" . $person['uid'] . ".jpg");
                    }

                    // Person Organisation
                    $organisation = [];
                    foreach ($person['org'] as $org) {
                        if (in_array($org['sourceId'], $personOrgsArr)) {
                            $organisation[] = DataObject::getByPath("/LucrisOrganisation/" . $org['sourceId']);
                        }
                        // $organisation[] = DataObject\LucrisOrganisation::getBySourceId($org['sourceId']);
                    }

                    // Person UKÄ(area)
                    $UKA_sv = NULL;
                    $UKA_en = NULL;
                    if ($person['uka']['sv']) { $UKA_sv = implode(',', $person['uka']['sv']); }
                    if ($person['uka']['en']) { $UKA_en = implode(',', $person['uka']['en']); }

                    // Keyword (freetext)
                    $keyword_sv = NULL;
                    $keyword_en = NULL;
                    if ($person['keyword']['sv']) { $keyword_sv = implode(',', $person['keyword']['sv']); }
                    if ($person['keyword']['en']) { $keyword_en = implode(',', $person['keyword']['en']); }

                    // Check if the person allredy exists 
                    $query1 = sprintf('SELECT o_id FROM objects WHERE o_parentId=%s AND o_key="%s" LIMIT 0,1', $parentId, $person['uid']);
                    $oIdExisting = $db->fetchAll($query1);
                    // Get o_id
                    $o_id = (int) $oIdExisting[0]['o_id'];

                    if ($o_id) {
                        // Update person data
                        $lucrisPersonList = DataObject\LucrisPerson::getById($o_id);

                        $values = [
                            'uuid' => $person['uuid'],
                            'uid' => $person['uid'],
                            'name' => $person['firstName'] . ' ' . $person['lastName'],
                            'firstName' => $person['firstName'],
                            'lastName' => $person['lastName'],
                            'photo' => $photo,
                            'organisation' => $organisation,
                            'visibility' => $person['visibility'],
                            'modified' => $person['modified']
                        ];
                        
                        $lucrisPersonList->setValues($values);
                        $lucrisPersonList->setUka($UKA_sv, $languages[0]);
                        $lucrisPersonList->setUka($UKA_en, $languages[1]);
                        $lucrisPersonList->setKeyword($keyword_sv, $languages[0]);
                        $lucrisPersonList->setKeyword($keyword_en, $languages[1]);
                        $lucrisPersonList->setPortalUrl($person['portalUrl']['sv'], $languages[0]);
                        $lucrisPersonList->setPortalUrl($person['portalUrl']['en'], $languages[1]);
                        $lucrisPersonList->save();

                        // Print a message
                        // print ($this->timeNow . 'LUCRIS INFO: Person with id:[' . $person["uid"] .  '] WAS updated'  . "\xA");
                    }
                    else{
                        // Create new person and save it to LucrisPerson Object
                        $newLucrisPersonObject = new DataObject\LucrisPerson();

                        $values = [
                            'o_parentId' => $parentId,
                            'o_key' => $person['uid'],
                            'o_published' => $published,
                            'uuid' => $person['uuid'],
                            'uid' => $person['uid'],
                            'name' => $person['firstName'] . ' ' . $person['lastName'],
                            'firstName' => $person['firstName'],
                            'lastName' => $person['lastName'],
                            'photo' => $photo,
                            'organisation' => $organisation,
                            'visibility' => $person['visibility'],
                            'modified' => $person['modified']
                        ];
                        $newLucrisPersonObject->setValues($values);
                        $newLucrisPersonObject->setUka($UKA_sv, $languages[0]);
                        $newLucrisPersonObject->setUka($UKA_en, $languages[1]);
                        $newLucrisPersonObject->setKeyword($keyword_sv, $languages[0]);
                        $newLucrisPersonObject->setKeyword($keyword_en, $languages[1]);
                        $newLucrisPersonObject->setPortalUrl($person['portalUrl']['sv'], $languages[0]);
                        $newLucrisPersonObject->setPortalUrl($person['portalUrl']['en'], $languages[1]);
                        $newLucrisPersonObject->save();

                        // Print a message
                        // print ($this->timeNow . 'LUCRIS INFO: New person with id:[' . $person["uid"] .  '] WAS created AND saved'  . "\xA");
                    }
                }
            }
        }
    }
}
