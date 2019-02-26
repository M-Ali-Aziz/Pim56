<?php

namespace LucatBundle\Model;

use LucatBundle\Model\AbstractProvider;
use \Pimcore\Model\DataObject;
use \Pimcore\Config;
use \Pimcore\Db;

/**
 * Synchronize LucatPerson with LucatOpen
 */
class PersonProvider extends AbstractProvider
{
    public function SynchronizeLucatPerson()
    {
        // Get lucatPersonParentId
        $parentId = $this->getParentId('lucatPersonParentId');

        // Set published
        $published = 1;

        // Get the valid languages
        $config = Config::getSystemConfig();
        $l = explode(',', $config->general->validLanguages);

        // Connenct to Pimcore DB
        $db = Db::get();

        // Get Uids
        $uids = $this->getUids();
        $uids = array_map(function($uid) { return("'" . $uid['uid'] . "'"); }, $uids);
        $uids = implode(',', $uids);

        // Get lucatOpen
        $lucatopen = $this->getLucatOpen();

        $sql = "SELECT "
            . "pa.luEduPersonGUID, "
            . "pa.eduPersonAffiliation, "
            . "pa.eduPersonPrincipalName, "
            . "pa.mail AS luMail, "
            . "pa.uid, "
            . "p.cn, "
            . "p.displayName, "
            . "p.givenName, "
            . "por.telephoneNumber, "
            . "p.o, "
            . "p.sn, "
            . "pv.* "
            . "FROM luEduPersonAccount AS pa "
            . "INNER JOIN luEduPerson AS p "
            . "ON pa.luEduPersonGUID = p.guid "
            . "INNER JOIN luEduPersonOrgRole AS por "
            . "ON por.luEduPersonGUID = p.guid "
            . "INNER JOIN luEduPersonPrivate AS pv "
            . "ON pa.luEduPersonGUID = pv.guid "
            . "WHERE pa.uid IN ($uids)";

        $statement = $lucatopen->prepare($sql);
        $statement->execute();
        $result = $statement->fetchAll(\PDO::FETCH_ASSOC);

        // Save/Update Lucat Person
        foreach ($result as $lucatOpenPerson) {
            // Check if Person allredy exists 
            $query = sprintf('SELECT o_id FROM objects WHERE o_parentId=%s AND o_key="%s" LIMIT 0,1', $parentId, $lucatOpenPerson['uid']);
            $oIdExisting = $db->fetchAll($query);
            $o_id = (int) $oIdExisting[0]['o_id'];

            // Get related organisation(s)
            $roll = $this->getRoll($lucatOpenPerson['uid']);

            // Get related organisation(s)
            $organisation = $this->getOrganisation($roll);

            if ($o_id) {
                // Update the Object
                $lucatPersonObj = DataObject\LucatPerson::getById($o_id);

                $values = [
                    'uid' => $lucatOpenPerson['uid'],
                    'guid' => $lucatOpenPerson['luEduPersonGUID'],
                    'displayName' => $lucatOpenPerson['displayName'],
                    'givenName' => $lucatOpenPerson['givenName'],
                    'surName' => $lucatOpenPerson['sn'],
                    'phoneNumber' => $lucatOpenPerson['telephoneNumber'],
                    'mail' => $lucatOpenPerson['mail'],
                    'luMail' => $lucatOpenPerson['luMail'],
                    'website' => $lucatOpenPerson['labeledURI'],
                    'Facebook' => $lucatOpenPerson['luEduPersonSocialFacebook'],
                    'Flicker' => $lucatOpenPerson['luEduPersonSocialFlickr'],
                    'Linkedin' => $lucatOpenPerson['luEduPersonSocialLinkedIn'],
                    'Skype' => $lucatOpenPerson['luEduPersonSocialSkype'],
                    'Twitter' => $lucatOpenPerson['luEduPersonSocialTwitter'],
                    'Vimeo' => $lucatOpenPerson['luEduPersonSocialVimeo'],
                    'AcademicDegree' => $lucatOpenPerson['luEduPersonAcademicDegree'],
                    'Organisationer' => $organisation,
                    'Roller' => $roll
                ];

                $lucatPersonObj->setValues($values);
                $lucatPersonObj->save();  
            }
            else {
                // Save new Object
                $lucatPersonObj = new DataObject\LucatPerson();

                $values = [
                    'o_parentId' => $parentId,
                    'o_key' => $lucatOpenPerson['uid'],
                    'o_published' => $published,
                    'uid' => $lucatOpenPerson['uid'],
                    'guid' => $lucatOpenPerson['luEduPersonGUID'],
                    'displayName' => $lucatOpenPerson['displayName'],
                    'givenName' => $lucatOpenPerson['givenName'],
                    'surName' => $lucatOpenPerson['sn'],
                    'phoneNumber' => $lucatOpenPerson['telephoneNumber'],
                    'mail' => $lucatOpenPerson['mail'],
                    'luMail' => $lucatOpenPerson['luMail'],
                    'website' => $lucatOpenPerson['labeledURI'],
                    'Facebook' => $lucatOpenPerson['luEduPersonSocialFacebook'],
                    'Flicker' => $lucatOpenPerson['luEduPersonSocialFlickr'],
                    'Linkedin' => $lucatOpenPerson['luEduPersonSocialLinkedIn'],
                    'Skype' => $lucatOpenPerson['luEduPersonSocialSkype'],
                    'Twitter' => $lucatOpenPerson['luEduPersonSocialTwitter'],
                    'Vimeo' => $lucatOpenPerson['luEduPersonSocialVimeo'],
                    'AcademicDegree' => $lucatOpenPerson['luEduPersonAcademicDegree'],
                    'Organisationer' => $organisation,
                    'Roller' => $roll
                ];

                $lucatPersonObj->setValues($values);
                $lucatPersonObj->save();
            }
        }

        // Remove old person
        $this->RemoveOldPerson();
    }

    /**
     * Get related roll(s)
     *
     * @return array
     */
    private function getRoll($uid)
    {
        $rollArr = [];

        $rollObj = new DataObject\LucatRoll\Listing();
        $rollObj->setUnpublished(true);
        $rollObj->setCondition("uid = ?", $uid);

        foreach ($rollObj as $roll) {
            $rollArr[] = DataObject\LucatRoll::getById($roll->getId());
        }

        return $rollArr;
    }

    /**
     * Get related Organisation(s)
     *
     * @return array
     */
    private function getOrganisation($rolls)
    {
        $orgArr = [];
        $departmentNrArr = [];
        $orgObjArr = [];

        // Get departmentNumber
        foreach ($rolls as $roll) {
            $departmentNrArr[] = $roll->getdepartmentNumber();
        }

        // Removes duplicate values from $departmentNrArr
        $departmentNrArr = array_unique($departmentNrArr);

        // Get Organisation(s)
        foreach ($departmentNrArr as $departmentNumber) {
            $orgObj = new DataObject\LucatOrganisation\Listing();
            $orgObj->setUnpublished(true);
            $orgObj->setCondition("departmentNumber = ?", $departmentNumber);
            
            foreach ($orgObj as $org) {
                $orgArr[] = $org;
            }
        }

        return $orgArr;
    }

    /**
     * Remove old person(s)
     */
    private function RemoveOldPerson()
    {
        // - (1 hours; 60 mins; 60 secs)
        $last24hours = time() - (1 * 60 * 60);

        // Get LucatPerson Object (old)
        $lucatRollObj = new DataObject\LucatPerson\Listing();
        $lucatRollObj->setCondition("o_modificationDate < ?", $last24hours);
        $lucatRollObj->load();

        if ($lucatRollObj) {
            foreach ($lucatRollObj as $obj) {
                // Remove
                $obj->delete();
            }
        }
    }
}