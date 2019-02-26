<?php

namespace AppBundle\Controller;

use AppBundle\Website\Controller\DynamicPage;
use Pimcore\Controller\FrontendController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Event\FilterControllerEvent;
use AppBundle\Website\Filter\Links;

/**
* Faculty Controller
*
* @package LUSEM
* @category AppBundle
* @author Jonas Ledendal <Jonas.Ledendal@har.lu.se>, M. Ali
* @version 2.0
*/
class FacultyController extends DynamicPage
{
    /**
    * Initialize
    */
    public function onKernelController(FilterControllerEvent $event)
    {
        //Disable the output/Full-page cache
        $this->get(\Pimcore\Bundle\CoreBundle\EventListener\Frontend\FullPageCacheListener::class)->disable("FacultyController Controller");
    }

    /**
    * Detail action
    * @todo filter and validate input
    * @todo error handling
    */
    public function detailAction(Request $request)
    {
        //Get Lucat user id from request parameter
        $uid = (string) $request->get('id');

        //Get website department number
        $departmentNumber = $this->website['departmentnumber'];

        //Disable department filter for LUSEM main website
        if ($departmentNumber == 'v1000020') {
            $departmentNumber = null;
        }

        //Lusem faculty web service
        $faculty = new Website_Service_Lusem_Faculty();
        $member = $faculty->findMemberByUserIdentifier($uid, $departmentNumber);

        //Fetch publications from LUP (currently maximum 20)
        $lup = new Website_Service_Lu_Lup();
        $publications = $lup->findPublicationsByUserIdentifier($uid);
        if ($publications) $this->view->publications = $publications;

        //Lusem employees web service
        if (isset($member)) {
            //Add employee data
            $service = new Website_Service_Lusem_Employees();
            $employee = $service->findEmployeeByUserIdentifier($uid);
            $employee['faculty'] = $member;

            //Make links clickable
            $filterChain = new Links();
            $employee['faculty']['research']['description']['sv'] = $filterChain->filter($employee['faculty']['research']['description']['sv']);
            $employee['faculty']['research']['description']['en'] = $filterChain->filter($employee['faculty']['research']['description']['en']);
        }

        //Assign view parameters
        $this->view->employee = $employee;

        //Not found redirect to error page
        if (!isset($this->view->employee)) {
            $this->redirectError();
        }

        //Assign website base uri parameter to view
        $this->view->baseUri = ($this->website['baseuri'] == '/') ? '/' : $this->website['baseuri'] . '/';
        if ($this->language == 'sv') {
            $this->view->facultyUri = 'http://www.lusem.lu.se/research/faculty/';
        }
        else {
            $this->view->facultyUri = 'http://www.ehl.lu.se/forskning/faculty/';
        }

        //Render view script
        // $this->render('detail');
    }

    /**
    * List action
    * @todo filter and validate input
    * @todo error handling
    */
    public function listAction(Request $request)
    {
        //Get Lucat department id from request parameter
        $departmentNumber = (string) $request->get('id');

        //Handle legacy department numbers
        if (substr($departmentNumber, 0, 1) != '0') $departmentNumber = '0' . $departmentNumber;

        $service = new Website_Service_Lusem_Employees();
        $this->view->orgunit = $service->findOrganizationByDepartmentNumber($departmentNumber);

        //Lusem faculty web service
        $faculty = new Website_Service_Lusem_Faculty();
        $members = $faculty->findMembersByDepartmentNumber($departmentNumber);

        //Assign view parameters
        $this->view->staffList = $this->createFacultyMemberList($members);

        //Disable department filter for LUSEM main website
        if ($this->website['departmentnumber'] != 'v1000020' && $departmentNumber != $this->website['departmentnumber']) {
            $this->view->staffList = null;
        }

        //Not found redirect to error page
        if (!isset($this->view->staffList)) {
            $this->redirectError();
        }

        //Assign website base uri parameter to view
        $this->view->baseUri = ($this->website['baseuri'] == '/') ? '/' : $this->website['baseuri'] . '/';

        //Render view script
        // $this->render();
    }

    /**
    * Search result action
    */
    public function searchResultAction(Request $request)
    {
        //Get query string from request parameter
        $query = $request->get('q');

        //Get research area from request parameter
        $researchArea = (string) $request->get('topic');

        //Get website department number
        $departmentNumber = $this->website['departmentnumber'];

        //Disable department filter for LUSEM main website
        if ($departmentNumber == 'v1000020') {
            $departmentNumber = null;
        }

        //Lusem faculty web service
        $faculty = new Website_Service_Lusem_Faculty();
        if (isset($query)) {
            $members = $faculty->findMembersByName($query, $departmentNumber);
        }
        else if (isset($researchArea)) {
            $members = $faculty->findMembersByResearchArea($researchArea, $departmentNumber);
        }
        else {
            $members = null;
        }

        //Assign view parameters
        $this->view->staffList = $this->createFacultyMemberList($members);

        //Assign website base uri parameter to view
        $this->view->baseUri = ($this->website['baseuri'] == '/') ? '/' : $this->website['baseuri'] . '/';

        //Assign search query parameter to view
        if(isset($query)) $this->view->query = trim($query);

        //Assign research area parameter to view
        if(isset($researchArea)) $this->view->researchArea = $researchArea;

        //Render view script
        // $this->render();
    }

    /**
    * Returns faculty member list
    *
    * @param unknown $members
    * @return Ambigous <multitype:, NULL>
    */
    protected function createFacultyMemberList($members)
    {
        if (isset($members)) {
            $service = new Website_Service_Lusem_Employees();
            $employees = array();
            foreach($members as $member) {
                $employee = $service->findEmployeeByUserIdentifier($member['uid']);
                if(isset($employee)) {
                    $employee['faculty'] = $member;
                    array_push($employees, $employee);
                }
            }
        }
        else {
            $employees = null;
        }

        return $employees;
    }
}
