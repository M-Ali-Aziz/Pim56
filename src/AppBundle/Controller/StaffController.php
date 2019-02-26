<?php

namespace AppBundle\Controller;

use AppBundle\Website\Controller\Page;
use Pimcore\Controller\FrontendController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Event\FilterControllerEvent;
use \Pimcore\Model\DataObject;
use \Pimcore\Config\Config;
use \Pimcore\Model\Site;
use \Pimcore\Tool;

/**
* Staff Controller
*
* @package LUSEM
* @category AppBundle
* @author Jonas Ledendal <Jonas.Ledendal@har.lu.se>, M. Ali
* @version 2.0
*/
class StaffController extends Page
{
    /**
    * Detail action
    * @todo filter and validate input
    * @todo error handling
    */
    public function detailAction(Request $request)
    {
        $uid = (string) $request->get('id');

        $departmentNumber = (is_string($this->website['departmentnumber'])) ? 
            $this->website['departmentnumber'] : NULL;

        if ($departmentNumber == 'v1000020') {
            $departmentNumber = null; // disable filter on main website
        }

        $this->view->baseUri = ($this->website['baseuri'] == '/') ? '/' : $this->website['baseuri'] . '/';
        $this->view->employeeUid = $uid;
        $this->view->org = $org = DataObject\LucatOrganisation::getByDepartmentNumber(
                            $departmentNumber, ['limit' => 1,'unpublished' => true]);

        $this->view->staffList = $staffList = $this->getStaffListing(
                $departmentNumber, array('uid' => $uid));

        if( ! is_object($staffList)) {
            $this->redirectError();
        }

        $this->view->employee = $employee = $staffList->objects[0];
        $this->view->breadcrumbs = $employee;
        $this->view->editHeadTitle = true;
        $this->view->title = $employee->getDisplayName();
    }

    /**
    * List action
    * @todo filter and validate input
    * @todo error handling
    */
    public function listAction(Request $request)
    {
        $domainsException = ['ehl', 'lusem', 'staff'];
        $departmentNumberParam = (string) $request->get('id');
        $departmentNumber = $this->website['departmentnumber'];


        if (!in_array($this->website['subdomain'], $domainsException) && $departmentNumber !== $departmentNumberParam) {
            return $this->redirectError();
        }

        $this->view->google = \Pimcore\Config::getSystemConfig()->services->google;
        $this->view->baseUri = ($this->website['baseuri'] == '/') ? '/' : $this->website['baseuri'] . '/';
        $this->view->staffList = $staffList = $this->getStaffListing(
                $departmentNumberParam);
        $this->view->org = $org = DataObject\LucatOrganisation::getByDepartmentNumber(
                            $departmentNumberParam, ['limit' => 1,'unpublished' => true]);

        if( ! $this->view->org || ! $this->view->staffList) {
            $this->redirectError();
        }

        $this->view->breadcrumbs = $org;
        $this->view->editHeadTitle = true;
        $this->view->title = $org->getName();
    }

    /**
    * Search action
    */
    public function searchAction(Request $request)
    {
        $departmentNumber = (is_string($this->website['departmentnumber'])) ? 
            $this->website['departmentnumber'] : NULL;

        if ($departmentNumber == 'v1000020') {
            $departmentNumber = null; // disable filter on main website
        }

        $this->view->query = $query = $request->get('q');
        if($query) {
            $this->view->staffList = $staffList = $this->getStaffListing(
                                $departmentNumber, array('displayName' => $query));
        }
        $this->view->org = DataObject\LucatOrganisation::getByDepartmentNumber(
                        $departmentNumber, ['limit' => 1,'unpublished' => true]);

        $this->view->breadcrumbs = TRUE;
    }

    /**
     * Get Staff Listing
     *
     * Returns a listing Dataobject of staff members
     */
    protected function getStaffListing($departmentNumber = NULL, $attr = array())
    {
        $org = DataObject\LucatOrganisation::getByDepartmentNumber(
            $departmentNumber, ['limit' => 1,'unpublished' => true]);
        $list = new DataObject\LucatPerson\Listing();
        $query = '';


        if(is_object($org)) {
            $attr['Organisationer'] = $org->getId();
        }

        foreach($attr as $column => $value) {

            if(strlen($value)) {

                if(strlen($query)>0) {
                    $query .= " AND ";
                }
                $query .= "{$column} LIKE '%{$value}%'";
            }
        }

        if(strlen($query) == 0) {
            return null;
        }

        // Filtering by roll fields
        $r = new DataObject\LucatRoll;
        $p = new DataObject\LucatPerson;
        $query .= " AND EXISTS (SELECT oo_id FROM object_" . $r->getClassId() . 
                  " WHERE object_" . $p->getClassId() . ".Roller LIKE CONCAT('%', object_" . $r->getClassId() . ".oo_id, '%') AND hideFromWeb = 0 AND leaveOfAbsence = 0)";
        if($departmentNumber) {
            $query = substr($query,0,-1) . " AND departmentNumber = '$departmentNumber')";
        }

        $list->setCondition($query);
        $list->setOrderKey(['surName','givenName'], true);

        return ($list->load()) ? $list : null;
    }
}