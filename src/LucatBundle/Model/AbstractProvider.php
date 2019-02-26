<?php

namespace LucatBundle\Model;

use \PDO;
use \PDOException;
use \Exception;
use \Pimcore\Tool\Frontend;

class AbstractProvider
{
    protected $lucatConfigPath = PIMCORE_PRIVATE_VAR . '/bundles/LucatBundle/lucat_config.php';

    /**
     * Get lucat config file
     *
     * @return array
     */
    protected function getLucatConfigFile()
    {
        $lucatConfigPath = $this->lucatConfigPath;
        if(file_exists($lucatConfigPath)) {
            $lucatConfigFile = require $lucatConfigPath;

            return $lucatConfigFile;
        }
        else {
            // Add log to var/log/lucat.log
            \Pimcore\Log\Simple::log("lucat", "LUCAT ERROR: Failed to get lucat config file " . __FILE__ . " Line: " . __LINE__);
            // Exception
            throw new Exception("LUCAT ERROR: Failed to get lucat config file" . "\n");
        }
    }

    /**
     * Connect to LucatOpen
     *
     * @return PDO object
    */
    protected function getLucatOpen()
    {
        // Get lucat config file
        $lucatConfigFile = $this->getLucatConfigFile();

        try {
            $hostname = $lucatConfigFile['hostname'];
            $port = $lucatConfigFile['port'];
            $dbname = $lucatConfigFile['dbname'];
            $username = $lucatConfigFile['username'];
            $password = $lucatConfigFile['password'];

            $lucatopen = new PDO ("dblib:host=$hostname:$port;dbname=$dbname","$username","$password");
            
            return $lucatopen;

        } catch (PDOException $e) {
            // Add log to var/log/lucat.log
            \Pimcore\Log\Simple::log("lucat", "LUCAT ERROR: Failed to connect to LucatOpen: " . $e->getMessage() . " " . __FILE__ . " Line: " . __LINE__);
            echo "Failed to connect to LucatOpen: " . $e->getMessage() . "\n";
        }
    }

    /**
     * Get related ParentId from Pimcore Website Settings
     *
     * @return string
    */
    protected function getParentId($configName)
    {
        $parentId = Frontend::getWebsiteConfig()->$configName;

        if ($parentId) {
            // Set ParentId
            return $parentId;
        }
        else {
            // Add log to var/log/lucat.log
            \Pimcore\Log\Simple::log("lucat", "LUCAT ERROR: Failed to get ParentId for: $configName, from Website Settings! " . __FILE__ . " Line: " . __LINE__);

            // Exception
            throw new Exception("Failed to get ParentId for: $configName, from Website Settings!" . "\n");
        }
    }

    /**
     * Get all EHL person-uides from LucatOpen
     *
     * @return array
    */
    protected function getUids()
    {
        // Get lucat config file
        $lucatConfigFile = $this->getLucatConfigFile();

        // Prepare departmentNumbers
        $organisations = $lucatConfigFile['organisations'];
        $departmentNumber = array_map(function($org) { return("'" . $org['departmentNumber'] . "'"); }, $organisations);
        $departmentNumbers = implode(',', $departmentNumber);

        // Get lucatOpen
        $lucatopen = $this->getLucatOpen();

        $sql = "SELECT "
            . "pa.uid "
            . "FROM luEduOrgUnit AS ou "
            . "INNER JOIN luEduOrgRole AS ro "
            . "ON ou.guid = ro.luEduOrgUnitGUID "
            . "INNER JOIN luEduPersonOrgRole AS por "
            . "ON ro.guid = por.luEduOrgRoleGUID "
            . "INNER JOIN luEduPersonAccount AS pa "
            . "ON por.luEduPersonGUID = pa.luEduPersonGUID "
            . "WHERE pa.employeeType NOT LIKE ('%Student%') "
            . "AND ou.departmentNumber IN ($departmentNumbers)";

        $statement = $lucatopen->prepare($sql);
        $statement->execute();
        $result = $statement->fetchAll(\PDO::FETCH_ASSOC);

        return $result;
    }

    /**
     * Get all EHL departmentNumber from lucatConfigFile
     *
     * @return array
    */
    protected function getOrganisations()
    {
        // Get lucat config file
        $lucatConfigFile = $this->getLucatConfigFile();

        // Prepare departmentNumbers
        $organisations = $lucatConfigFile['organisations'];

        return $organisations;
    }
}