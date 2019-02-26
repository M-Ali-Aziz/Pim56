<?php
namespace LucrisBundle\Model;

/**
* This class gets data from Lucris.
*
* @link https://lucris.lub.lu.se/ws/doc/
* Specified for EHL/LUSEM - organization.
*/
class XMLParser
{
    /**
    * Loaded SimpleXMLElement from the URL.
    * @var SimpleXMLElement
    */
    private $xmlElement;

    /**
    * Storing the mapped person data from Lucris.
    * @var array
    */
    private $personItems = array();

    /**
    * Constructor. Loads the SimpleXMLElement object from URL.
    */
    public function __construct($url) {
        for ($i = 0; $i < 3; $i++) {
            $this->xmlElement = @simplexml_load_file($url);
            if ($this->xmlElement === FALSE) {
                // Add log to lucris.php
                \Pimcore\Log\Simple::log("lucris", "Lucris.ERROR Failed to fetch url! try $i: " . __FILE__ . " Line: " . __LINE__);
            
                print "LUCRIS ERROR: Failed to fetch url: $url ! try $i\n";
                sleep(5);
            }
            else {
                break;
            }
        }
    }

    /**
    * Validate the results from the Lucris webservice.
    * If we have already reached the roof of the items with our crawler, the only
    * way for noticing this is checking the XML result if we got records in it.
    * If the query was invalid, it results a similar XML, without records.
    * A diagnostic message is also available we don't get records, but we are not
    * really interested in this.
    * @return boolean
    */
    public function validResults() {
        $str = $this->getStringByPath($this->xmlElement, '//core:count');
        return ($str !== "0" && !empty($str));
    }

    /**
    * Return the number in the core:count field, so we can check if we have fetched everything
    * @return string
    */
    public function count() {
        $str = $this->getStringByPath($this->xmlElement, '//core:count');
        return $str;
    }

    /**
    * Get the xmlElement in usable, simple key-value paired xml format.
    * Note: first you need to use the __construct() method.
    * @return array
    */
    public function getXmlElement() {
        return $this->xmlElement;
    }

    /**
    * Get the person items in usable, simple key-value paired array format.
    * Note: first you need to use the mapPersonData() method.
    * @return array
    */
    public function getPersonItems() {
        return $this->personItems;
    }

    /**
    * Map the necessary data from the SimpleXMLElement object.
    * Data is stored in $this->PersonItems
    */
    public function mapPersonData() {
        $result = $this->xmlElement->children('core', TRUE)->result;
        foreach ($result->content AS $person) {
            $item = array();

            // Uuid
            if ($person->attributes()->uuid) {
                $person_uid = (string) $person->attributes()->uuid;
                $item["uuid"] = $person_uid;
            }

            // Uid
            if ($this->getStringByPath($person, "cur:external/extensions-core:sourceId")) {
                $person_id = $this->getStringByPath($person, "cur:external/extensions-core:sourceId");
                $person_id = str_replace("@lu.se", "", $person_id);
                $item["uid"] = $person_id;
            }

            // First name
            if ($this->getStringByPath($person, "cur:name/core:firstName")) {
                $first_name= $this->getStringByPath($person, "cur:name/core:firstName");
                $item["firstName"] = $first_name;
            }

            // Last name
            if ($this->getStringByPath($person, "cur:name/core:lastName")) {
                $last_name = $this->getStringByPath($person, "cur:name/core:lastName");
                $item["lastName"] = $last_name;
            }

            // Organisations
            $organisations = $person->children('cur',true)->organisationAssociations->staffOrganisationAssociations;
            $i = -1;
            if ($organisations) {
                foreach ($organisations->staffOrganisationAssociation as $org) {
                    $i++;
                    // Organisation uuid
                    $orgUuid = (string) $org->organisation->attributes()->uuid;
                    $item['org'][$i]["uuid"] = $orgUuid;

                    // Organisation source Id
                    $orgSourceId = (string) $org->external->children('extensions-core',true)->sourceId;
                    $orgSourceId = substr($orgSourceId, -8);
                    $item['org'][$i]["sourceId"] = $orgSourceId;

                    // Organisation name
                    $orgName = $org->organisation->children('organisation-template',true)->name->children('core',true)->localizedString;

                    $item['org'][$i]["name"]['sv'] = (string) $orgName[0];
                    $item['org'][$i]["name"]['en'] = (string) $orgName[1];
                }
            }

            // UKA(area) - UKÄ subject classification
            $UKAs = $person->keywordGroups->keywordGroup;
            if ($UKAs) {
                foreach ($UKAs->keyword as $org) {
                    $UKA = $org->target->term->localizedString;
                    $item["uka"]['sv'][] = (string) $UKA[0];
                    $item["uka"]['en'][] = (string) $UKA[1];
                }
            }

            // Keyword (freetext)
            $keywords = $person->keywordGroups->keywordGroup;
            if ($keywords) {
                foreach ($keywords as $key) {
                    foreach ($key->keyword->userDefinedKeyword as $word) {
                        if ($word->attributes()->locale == "sv_SE") {
                            $item["keyword"]['sv'] = (array) $word->freeKeyword;
                        }
                        elseif ($word->attributes()->locale == "en_GB")  {
                            $item["keyword"]['en'] = (array) $word->freeKeyword;
                        }
                    }
                }
            }

            // Portal Url
            if ($person->portalUrl) {
                $url_en = (string) $person->portalUrl;
                $url_sv = str_replace("/en/", "/sv/", $url_en);
                $item["portalUrl"]["sv"] = $url_sv;
                $item["portalUrl"]["en"] = $url_en;
            }

            // Visibility
            if ($this->getStringByPath($person, "cur:limitedVisibility/core:visibility")) {
                $visibility = $this->getStringByPath($person, "cur:limitedVisibility/core:visibility");
                $item["visibility"] = $visibility;
                
            }

            // Modified
            if ($person->modified) {
                $date = new \DateTime($person->modified);
                $modified = $date->format('Y-m-d H:i:s');
                $item["modified"] = $modified;
            }

            $this->personItems[] = $item;
        }
    }

    /**
    * Get the value of an element in the XML structure
    * @param SimpleXMLElement $element the parent element to search in
    * @param string $path path to the element
    * @return string
    */
    private function getStringByPath($element, $path) {
        if ($element !== FALSE) {
            $elements = $element->xpath($path);
            if (is_array($elements) && count($elements) !== 0) {
                return (string) $elements[0];
            }
        }
        else {
            return '';
        }
    }

}
