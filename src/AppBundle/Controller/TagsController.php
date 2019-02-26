<?php

namespace AppBundle\Controller;

use AppBundle\Website\Controller\Page;
use Pimcore\Controller\FrontendController;
use Symfony\Component\HttpFoundation\Request;
use \Pimcore\Db;
use \Pimcore\Model\Element\Tag;
use \Pimcore\Model\DataObject;

/**
* Tags Controller
*
* @package LUSEM
* @category AppBundle
* @author Jonas Ledendal <Jonas.Ledendal@har.lu.se>, M. Ali
* @version 2.0
*/
class TagsController extends Page
{
    /**
    * Detail action
    *
    * Show details for a certain tag
    */    
    public function detailAction(Request $request)
    {
        $paging = true;
        $id = preg_replace('/[^a-z]+/','',$request->get('id'));

        // create database object
        $db = Db::get();
        // database query
        $sql = "SELECT id FROM tags WHERE LOWER(name)='{$id}' LIMIT 0,1";
        // fetching from db result if the user are set as admin (true/false)
        $id = $db->fetchAll($sql)[0]['id'];

        if( ! $id) {
            $this->redirectError();
        }

        //paging
        try{

            $tag = Tag::getById($id);
            $objects = self::_getObjectsForTagById($id);
            $popular = self::_getPopularTags();

            if ($paging) {
                $paginator = new \Zend\Paginator\Paginator($objects);
                $paginator->setCurrentPageNumber(1);
                $paginator->setItemCountPerPage(20);
                $paginator->setPageRange(5);
            }
        }
        catch(\Exception $e) {
            $paging = false;
            $paginator = null;
            throw new \Exception($e);
        }

        $this->view->tag = $tag;
        $this->view->objects = $objects;
        $this->view->paginator = $paginator;
        $this->view->popular = $popular;
        //render view script
        // $this->render();
    }

    private static function _getObjectsForTagById($tagId, $considerChildren = TRUE)
    {
        $type = "object";
        $tag = Tag::getById($tagId);
        $tagPath = $tag->getFullIdPath();

        if ($considerChildren) {
            $conditionForTags = "o_id IN (SELECT cId FROM tags_assignment INNER JOIN tags ON tags.id = tags_assignment.tagid 
                                WHERE ctype = '$type' AND (id = '$tagId' OR idPath LIKE '$tagPath%' ))";
        } else {
            $conditionForTags = "o_id IN (SELECT cId FROM tags_assignment WHERE ctype = '$type' AND tagid = '$tagId')";
        }

        $objectList = new DataObject\Listing();
        $objectList->setCondition($conditionForTags);

        return $objectList;
    }

    private static function _getPopularTags($count=10)
    {
        $db = Db::get();
        $sql = "SELECT tagId, count(tagId) as weight FROM tags_assignment GROUP by tagId ORDER by weight DESC LIMIT 0,{$count}";
        $result = $db->query($sql);

        $tags = array();
        foreach($result as $row) {
            $tags[] = $tag = Tag::getById($row['tagId']);
        }

        return $tags;
    }
}
