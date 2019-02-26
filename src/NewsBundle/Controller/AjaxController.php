<?php

namespace NewsBundle\Controller;

use Pimcore\Controller\FrontendController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Pimcore\Db;
use Pimcore\Model\Webservice\JsonEncoder;
use Pimcore\Tool\Session;
use Pimcore\Model\DataObject;
use Pimcore\Tool\Frontend;
use Pimcore\File;

class AjaxController extends FrontendController
{
    /**
     * @Route("/news/ajax/get-users")
     */
    public function getUsersAction () {

        $db = Db::get();

        $sql = 'SELECT id,name,firstname,lastname FROM users WHERE password IS NOT NULL';
        $users = $db->fetchAll($sql);

        JsonEncoder::encode($users);

    }

    /**
     * @Route("/news/ajax/get-news")
     */
    public function getNewsAction(Request $request)
    {
        try {

            $offset     = $request->get('start');
            $limit      = $request->get('limit');
            $sort       = json_decode($request->get('sort'))[0]; // [{"property":"o_creationDate","direction":"ASC"}]
            $order      = isset($sort->direction) ? $sort->direction : 'DESC';
            $orderBy    = isset($sort->property) ? $sort->property : 'o_creationDate';
            $fields     = $request->get('fields');
            $filter     = '%' . $request->get('filter') . '%';
            $session = Session::getReadOnly();
            $user = $session->user;

            $list = new DataObject\News\Listing();
            $list->setUnpublished(true);
            $list->setOffset($offset);
            $list->setLimit($limit);
            $list->setOrderKey($orderBy);
            $list->setOrder($order);

            //$condition = implode(' LIKE :? OR ', $fields) . ' LIKE :?';
            //$conditionVariables = array_fill(0,count($fields),$filter);
            $list->setCondition('Rubrik LIKE ' . $list->quote($filter));
            // if( ! $user->admin) {
            //     $list->addConditionParam("o_userOwner = " . $list->quote($user->id), "AND");
            // }
            $list->load();

            $db = Db::get();
            $class = DataObject\ClassDefinition::getByName('News');
            $totalCount = (int) $db->fetchOne('SELECT count(*) as count FROM object_' . $class->getId() . 
                                              ' WHERE ' . $list->getCondition());
        } 
        catch(\Exception $e)
        {

            JsonEncoder::encode(array(
                'message' => $e->getMessage(),
                'id' => null,
                'success' => false,
                'total' => 0
            ));
        }

        $result = Array();
        foreach($list as $o) {
            // filter object by our fields.
            $result[] = array_intersect_key( $o->getObjectVars(), array_flip($fields));
        }

        JsonEncoder::encode(array(
            'data' => $result,
            'total' => $totalCount,
            'success' => true
        ));
    }

    /**
     * @Route("/news/ajax/create-object")
     */
    public function createObjectAction (Request $request) {

        try {
            $user = (int) $request->get('userId');
            $parentId   = Frontend::getWebsiteConfig()->newsParentId;

            // Create a new object
            $newObject = new DataObject\News();
            $newObject->setKey(File::getValidFilename('untitled'));
            $newObject->setParentId($parentId);
            $newObject->setUserOwner($user);
            $newObject->setRubrik("Untitled");
            $newObject->save();

            JsonEncoder::encode(array(
                'id' => $newObject->getId(),
                'success' => true
            ));
        }
        catch(\Exception $e)
        {

            JsonEncoder::encode(array(
                'message' => $e->getMessage(),
                'id' => null,
                'success' => false
            ));
        }

    }
}
