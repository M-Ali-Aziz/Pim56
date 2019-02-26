<?php

namespace LucatBundle\Model;

use LucatBundle\Model\AbstractProvider;
use \Pimcore\Model\DataObject;
use \Pimcore\Config;
use \Pimcore\Db;

/**
 * Synchronize LucatOrganisations with LucatOpen
 */
class OrganisationProvider extends AbstractProvider
{
    public function SynchronizeLucatOrganisation()
    {
        // Get lucat config file
        $lucatConfigFile = $this->getLucatConfigFile();

        // Get lucatOpen
        $lucatopen = $this->getLucatOpen();

        // Prepare departmentNumbers
        $organisations = $this->getOrganisations();
        $departmentNumbers = array_map(function($org) { return("'" . $org['departmentNumber'] . "'"); }, $organisations);
        $departmentNumbers = implode(',', $departmentNumbers);

        // Get lucatOrgParentId
        $parentId = $this->getParentId('lucatOrgParentId');

        // Set published
        $published = 1;

        // Get the valid languages
        $config = Config::getSystemConfig();
        $l = explode(',', $config->general->validLanguages);

        // Connenct to Pimcore DB
        $db = Db::get();

        // Fetch all organisations
        $sql = "SELECT "
            . "guid, "
            . "departmentNumber, "
            . "displayName, "
            . "luEduOrgOuEN, "
            . "luEduOrgUnitEducationDescription, "
            . "luEduOrgUnitEducationDescriptionEN, "
            . "luEduOrgUnitEducationDescriptionURI, "
            . "luEduOrgUnitEducationDescriptionURIEN, "
            . "luEduOrgUnitResearchDescriptionURI, "
            . "luEduOrgUnitResearchDescriptionURIEN, "
            . "luEduOrgUnitResearchDescription, "
            . "luEduOrgUnitResearchDescriptionEN, "
            . "luEduOrgType, "
            . "postalAddress, "
            . "street, "
            . "postOfficeBox, "
            . "l, "
            . "telephoneNumber, "
            . "luEduOrgUnitVxNumber, "
            . "luEduOrgUnitGpsC, "
            . "luEduOrgUnitDomain, "
            . "luEduOrgUnitHomePageURI, "
            . "luEduOrgUnitHomePageURIEN, "
            . "street "
            . "FROM luEduOrgUnit "
            . "WHERE departmentNumber IN ($departmentNumbers)";
            
        $statement = $lucatopen->prepare($sql);
        $statement->execute();
        $result = $statement->fetchAll(\PDO::FETCH_ASSOC);

        // Save/Update Lucat Organisations
        foreach ($result as $lucatOpenOrg) {
            // Check if organisation allredy exists 
            $query = sprintf('SELECT o_id FROM objects WHERE o_parentId=%s AND o_key="%s" LIMIT 0,1', $parentId, $lucatOpenOrg['departmentNumber']);
            $oIdExisting = $db->fetchAll($query);
            $o_id = (int) $oIdExisting[0]['o_id'];

            if ($o_id) {
                // Update the Object
                $lucatOrgObj = DataObject\LucatOrganisation::getById($o_id);

                $values = [
                    'guid' => $lucatOpenOrg['guid'],
                    'departmentNumber' => $lucatOpenOrg['departmentNumber'],
                    'orgType' => $lucatOpenOrg['luEduOrgType'],
                    'postalAdress' => $lucatOpenOrg['postalAddress'],
                    'street' => $lucatOpenOrg['street'],
                    'postOfficeBox' => $lucatOpenOrg['postOfficeBox'],
                    'location' => $lucatOpenOrg['l'],
                    'telephoneNumber' => $lucatOpenOrg['telephoneNumber'],
                    'vxNumber' => $lucatOpenOrg['luEduOrgUnitVxNumber'],
                    'gpsC' => $lucatOpenOrg['luEduOrgUnitGpsC'],
                    'domain' => $lucatOpenOrg['luEduOrgUnitDomain'],
                    'internalAdress' => $lucatOpenOrg['street'],
                ];

                $lucatOrgObj->setValues($values);
                $lucatOrgObj->setName($lucatOpenOrg['displayName'], $l[0]);
                $lucatOrgObj->setName($lucatOpenOrg['luEduOrgOuEN'], $l[1]);
                $lucatOrgObj->setEducationDescription($lucatOpenOrg['luEduOrgUnitEducationDescription'], $l[0]);
                $lucatOrgObj->setEducationDescription($lucatOpenOrg['luEduOrgUnitEducationDescriptionEN'], $l[1]);
                $lucatOrgObj->setEducationUri($lucatOpenOrg['luEduOrgUnitEducationDescriptionURI'], $l[0]);
                $lucatOrgObj->setEducationUri($lucatOpenOrg['luEduOrgUnitEducationDescriptionURIEN'], $l[1]);
                $lucatOrgObj->setResearchDescription($lucatOpenOrg['luEduOrgUnitResearchDescription'], $l[0]);
                $lucatOrgObj->setResearchDescription($lucatOpenOrg['luEduOrgUnitResearchDescriptionEN'], $l[1]);
                $lucatOrgObj->setUrl($lucatOpenOrg['luEduOrgUnitHomePageURI'], $l[0]);
                $lucatOrgObj->setUrl($lucatOpenOrg['luEduOrgUnitHomePageURIEN'], $l[1]);
                $lucatOrgObj->setResearchUri($lucatOpenOrg['luEduOrgUnitResearchDescriptionURI'], $l[0]);
                $lucatOrgObj->setResearchUri($lucatOpenOrg['luEduOrgUnitResearchDescriptionURIEN'], $l[1]);

                $lucatOrgObj->save();
                
            }
            else {
                // Save new Object
                $lucatOrgObj = new DataObject\LucatOrganisation();

                $values = [
                    'o_parentId' => $parentId,
                    'o_key' => $lucatOpenOrg['departmentNumber'],
                    'o_published' => $published,
                    'guid' => $lucatOpenOrg['guid'],
                    'departmentNumber' => $lucatOpenOrg['departmentNumber'],
                    'orgType' => $lucatOpenOrg['luEduOrgType'],
                    'postalAdress' => $lucatOpenOrg['postalAddress'],
                    'street' => $lucatOpenOrg['street'],
                    'postOfficeBox' => $lucatOpenOrg['postOfficeBox'],
                    'location' => $lucatOpenOrg['l'],
                    'telephoneNumber' => $lucatOpenOrg['telephoneNumber'],
                    'vxNumber' => $lucatOpenOrg['luEduOrgUnitVxNumber'],
                    'gpsC' => $lucatOpenOrg['luEduOrgUnitGpsC'],
                    'domain' => $lucatOpenOrg['luEduOrgUnitDomain'],
                    'internalAdress' => $lucatOpenOrg['street'],
                ];

                $lucatOrgObj->setValues($values);
                $lucatOrgObj->setName($lucatOpenOrg['displayName'], $l[0]);
                $lucatOrgObj->setName($lucatOpenOrg['luEduOrgOuEN'], $l[1]);
                $lucatOrgObj->setEducationDescription($lucatOpenOrg['luEduOrgUnitEducationDescription'], $l[0]);
                $lucatOrgObj->setEducationDescription($lucatOpenOrg['luEduOrgUnitEducationDescriptionEN'], $l[1]);
                $lucatOrgObj->setEducationUri($lucatOpenOrg['luEduOrgUnitEducationDescriptionURI'], $l[0]);
                $lucatOrgObj->setEducationUri($lucatOpenOrg['luEduOrgUnitEducationDescriptionURIEN'], $l[1]);
                $lucatOrgObj->setResearchDescription($lucatOpenOrg['luEduOrgUnitResearchDescription'], $l[0]);
                $lucatOrgObj->setResearchDescription($lucatOpenOrg['luEduOrgUnitResearchDescriptionEN'], $l[1]);
                $lucatOrgObj->setUrl($lucatOpenOrg['luEduOrgUnitHomePageURI'], $l[0]);
                $lucatOrgObj->setUrl($lucatOpenOrg['luEduOrgUnitHomePageURIEN'], $l[1]);
                $lucatOrgObj->setResearchUri($lucatOpenOrg['luEduOrgUnitResearchDescriptionURI'], $l[0]);
                $lucatOrgObj->setResearchUri($lucatOpenOrg['luEduOrgUnitResearchDescriptionURIEN'], $l[1]);

                $lucatOrgObj->save();
            }
        }
    } 
}