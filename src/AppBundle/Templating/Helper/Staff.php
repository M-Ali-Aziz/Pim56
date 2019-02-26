<?php

declare(strict_types=1);

/**
 *  TODO: 
 *
 *  - make use of partial 
 *  @see http://stackoverflow.com/a/2390151
 * 
 *  - Check if person is correct class object. 
 *
 * @author Jimmi Elofsson <hi@jimmi.eu>, M. Ali
 *
 */

namespace AppBundle\Templating\Helper;

use Symfony\Component\Templating\Helper\Helper;
use \Pimcore\Model\DataObject;

class Staff extends Helper
{
    private $staff = array();
    private $view;

    /**
    * @inheritDoc
    */
    public function getName()
    {
        return 'staff';
    }

    public function __invoke($view, $staff = array())
    {
        $this->view = $view;
        $this->staff = $staff;

        return $this;
    }

    public function StaffList($attr = array())
    {
        $result = '';
        
        foreach($this->staff as $s) {
            $result .= '<hr>';
            $result .= $this->StaffDetail($s, $attr);
        }

        return $result;
    }

    /**
     *
     * Staff Detail
     *
     * Will setup content and render a detailed view of 
     * a staff member (person) that are passed to this function
     *
     * @param object    $person
     * @param array     $attr 
     */
    public function StaffDetail($person, $attr = array())
    {
        if( ! isset($attr['heading']) || $attr['heading']) {

            $pdata['heading'] = $person->getDisplayName();
        }

        if($person->getLuMail()) {

            $pdata['mail'] = $person->getLuMail();
        }

        if($attr['moreinfo']) {

            $pdata['moreinfo'] = $this->view->baseUri . strtolower($this->view->translate('contact'))
                                 . '/' . $person->getUid();
        }

        if( ! isset($attr['room']) || $attr['room']) {
            $pdata['room'] = $this->StaffRoom($person);
        }

        // Get Staff Portal Url - Lucris
        if ($person->getUid() && !$attr['moreinfo']) {
            $pdata['portalUrl'] = $this->StaffPortalUrl($person, $attr);   
        }

        $pdata['website'] = ! isset($attr['website']) || $attr['website'] ? $person->getWebsite() : false;

        $pdata['image'] = ! isset($attr['image']) || $attr['image'] ? true : false;
        $pdata['roles'] = $this->StaffRoles($person, $attr);
        $pdata['phone'] = $this->StaffPhone($person);
        $pdata['person'] = $person;
        $pdata['view'] = (! isset($attr['view'])) 
                      ? 'Staff/partialPersonContactDetails.html.php' : $attr['view'];

        // View Parameters
        $parameters = array_merge($attr, $pdata);
        unset($parameters['view']);

        // rendering partial
        return $this->view->template($pdata['view'], $parameters);
    }

    public function StaffPortalUrl($person, $attr){
        try {
            // List LucrisPerson Object
            $lucrisPersonObject = new DataObject\LucrisPerson\Listing();
            $lucrisPersonObject->setLocale($this->view->language);
            $lucrisPersonObject->setCondition("uid LIKE ?", $person->getUid());
            $lucrisPersonObject->load();
            // Get PortalUrl
            foreach ($lucrisPersonObject as $staff) {
                return $staff->getportalUrl();
            } 
        }
        catch (\Exception $e) {
            echo $e->getMessage();
        }

        return false;
    }

    public function StaffPhone($person)
    {
        $phones = Array();
        $phone = '';

        if( ! $this->getRoles($person)) {
            return NULL;
        }

        foreach($this->getRoles($person) as $r)
        {
            if($r->getTelephoneNumber() && ! in_array($r->getTelephoneNumber(), $phones)) 
            {
                $phones[] = $r->getTelephoneNumber();
            }
        }

        if(is_array($phones)) 
        {
            foreach($phones as $p)
            {
                $phone .= $this->view->phoneNumber($p) . ', ';
            }
        }

        return ($phone) ? substr($phone, 0, -2) : NULL;
    }

    public function StaffRoom($person)
    {
        $room = NULL;

        if(is_array($this->getRolesByPerson($person)))
        {

            foreach($this->getRolesByPerson($person) as $r)
            {
                if($r->primary)
                {
                    $room = $r->room;
                }
            }
        }

        return $room;   
    }

    public function StaffRoles($person, $attr)
    {
        if(is_array($this->getRolesByPerson($person, $attr['department'])))
        {
            $roles = '';

            if( ! isset($attr['roleinfo']) || $attr['roleinfo'])
            {
                foreach($this->getRolesByPerson($person) as $r)
                {

                    $uri = preg_replace('/(kontakt|contact)(.*)/i', 
                        '$1', $_SERVER['REQUEST_URI']) . 
                        '/' . $this->baseUri . $r->departmentNumber;

                    $roles .= ucwords($r->roleName) . ' ' . mb_strtolower($this->view->translate('at'))
                            . ' <a href="' . $uri . '">' . $r->orgName . '</a><br>';
                }
            }
            else
            {

                foreach($this->getRolesByPerson($person, $attr['department']) as $r)
                {

                    $roles .= mb_strtolower($r->roleName) . ', ';
                }

                $roles = ucfirst($roles);
            }

            return substr($roles,0,-2);
        }

        return NULL;
    }

    private function getRolesByPerson($person, $departmentnumber=false)
    {
        if(! is_object($person)) {
            return NULL;
        }

        $roles = array();
        $organisations = $person->getOrganisationer();

        if( ! $departmentnumber)
        {
            // getting departmentnumber from all 
            // organisations connected with the person
            $departmentnumber = array_map(function($org) {

                return $org->getDepartmentNumber();
            }, $person->getOrganisationer());

        }
        else if( ! is_array($departmentnumber))
        {
            $departmentnumber = array($departmentnumber);
        }

        // filter roles by departmentnumbers
        $roles = array_filter($this->getRoles($person), function($r) use ($departmentnumber) {
            return (in_array($r->getDepartmentNumber(), $departmentnumber));
        });

        $roles = array_map(function($r) use ($organisations) {

            foreach($organisations as $o) 
            {
                if($o->getDepartmentNumber() == $r->getDepartmentNumber())
                {
                    return (object) array(
                        'roleName' => $r->getDisplayName($this->view->language),
                        'orgName' => $o->getName($this->view->language),
                        'orgBaseUri' => $this->baseUri,
                        'departmentNumber' => $r->getDepartmentNumber($this->view->language),
                        'primary' => $r->getPrimaryContactInfo(),
                        'room' => $r->getRoom()
                    );
                }
            }

            return NULL;
            
        }, $roles);

        return $roles;

    }

    private function getRoles($person, $include_custom_roles = FALSE)
    {
        if(! is_object($person)) {
            return NULL;
        }

        $rolesArr = $person->getRoller();
        
        if($include_custom_roles) {
            return $rolesArr;
        }

        return array_filter($rolesArr, function($r) {
            return ($r->getRoleType()!='custom' &&
                    $r->getHideFromWeb()!=TRUE &&
                    $r->getLeaveOfAbsence != TRUE);
        });
    }
}
