<?php

namespace AppBundle\Controller;

use AppBundle\Website\Controller\DynamicPage;
use Pimcore\Controller\FrontendController;
use Symfony\Component\HttpFoundation\Request;
use \Pimcore\Model\Element\Tag;
use \Pimcore\Model\DataObject;

/**
* News Controller
*
* @package LUSEM
* @category AppBundle
* @author Jonas Ledendal <Jonas.Ledendal@har.lu.se>, M. Ali
* @version 2.0
*/
class NewsController extends DynamicPage
{
    /**
    * News Detail Action
    */
    public function detailAction(Request $request, $validateForFrontend = TRUE)
    {
        try
        {
            // setup conditions - we will need them to know what news to load
            $paramId = explode('/', $request->get('id'));
            $id = is_array($paramId) ? $paramId[0] : $paramId;
            $language = str_replace('/', '', $this->language);
            $condition = is_numeric($id) ? "o_id = ".$id : "o_key = '".$id."'";
            // create news list
            $list = new DataObject\News\Listing();
            if($validateForFrontend) {
                // $language = sv/en 
                $condition .= " AND " . strtoupper($language) . " = 1";
            }
            else {

                $list->setUnpublished(true);
            }

            // set conditions from earlier and load news
            $list->setCondition($condition);
            $results = $list->load();
            $object = $results[0];

            if($object) {
                // checking for valid subdomain or webfilter
                if($validateForFrontend) {
                    $webb = is_array($object->getWebb()) ? $object->getWebb() : array();
                    $validWebb = array_filter($webb, function($w) {
                        return ($w == $this->website['subdomain'] || strstr($this->website['newsFilter'], $w));
                    });
                    if( !$validWebb) {

                        throw new \Exception('News object not found. ');
                    }
                }

                $tags = Tag::getTagsForElement($object->getType(), $object->getId());

                // assign header social meta tags
                try
                {
                     if($object->getImage1() !== NULL) {
                        $og_image = 'http://' . $_SERVER['HTTP_HOST'] . $object->getImage1('Opengraph');
                        $og_image_thumb = 'http://' . $_SERVER['HTTP_HOST'] . $object->getImage1()->getThumbnail('Opengraph');
                    }

                    // assign twitter metas
                    $this->view->twitter = array_merge($this->view->twitter, Array(
                        'card'          => ($og_image) ? 'summary_large_image' : 'summary',
                        'site'          => $this->config->twitter_site,
                        'title'         => $object->getRubrik(),
                        'description'   => substr($object->getIngress(), 0,200),
                        'creator'       => $this->config->twitter_site,
                        'image:src'     => $og_image
                    ));

                    // assign googleplus metas
                    $this->view->googleplus = array_merge($this->view->googleplus,  Array(
                        'name'        => $object->getRubrik(),
                        'description' => $object->getIngress(),
                        'image'       => $og_image
                    ));

                    // assign open graph facebook metas
                    $this->view->opengraph = array_merge($this->view->opengraph, Array(
                        'og:title'       => $object->getRubrik(),
                        'og:description' => $object->getIngress(),
                        'og:type'        => 'article',
                        'og:url'         => 'http://' . $_SERVER['HTTP_HOST'] . $this->document->getFullPath() . '/' . $id,
                        /*'og:image'       => $og_image_thumb,*/
                        'og:image'       => $og_image,
                        'og:site_name'   => $this->website['name']
                        /*'article:published_time' => date("c", (int)$object->getCreationDate()),
                        'article:modified_time'  =>  date("c", (int)$object->getModificationDate()),
                        'article:section' => 'Nyheter',
                        'article:tag'    => NULL,
                        'fn:admins'      => NULL*/
                    ));
                }
                catch(\Exception $e) {
                    // Write a log to debug.log
                    \Pimcore\Log\Simple::log('debug', $e->getMessage() . ' ' . __FILE__ . " Line: " . __LINE__);

                    if($this->debugmode) {
                        throw new \Exception($e->getMessage());
                    }
                }

                //assign news object to view
                $this->view->title = $object->getRubrik();
                $this->view->editHeadTitle = true;
                $this->view->breadcrumbs = $object;
                $this->view->nyheter = $object;
                $this->view->tags = $tags;
                $this->view->news_locale = ($object->getRubrik($language)) ? $language : FALSE;

                //render view script
                // $this->render('detail');
            }
            else {
                throw new \Exception('News object not found.');
            }
        }
        catch(\Exception $e) {
            // ops! something went terribly wrong
            $object = null;
            // Write a log to debug.log
            \Pimcore\Log\Simple::log('debug', $e->getMessage() . ' ' . __FILE__ . " Line: " . __LINE__);
            
            if($this->debugmode) {
                throw new \Exception($e->getMessage());
            } else {
                $this->redirectError();
            }
        }
    }

    /**
    * News Preview Action
    */
    public function previewAction(Request $request)
    {
        // Language
        $language = $this->language;

        // Get id from the request/url
        $id = $request->get('id');

        // Get news object by id
        $news = DataObject\News::getById($id);

        // Assign news object to view
        $this->view->title = $news->getRubrik();
        $this->view->nyheter = $news;
        $this->view->tags = $tags;
        $this->view->news_locale = ($news->getRubrik($language)) ? $language : FALSE;
    }

}
