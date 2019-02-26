<?php

namespace LucatBundle\Controller;

use Pimcore\Controller\FrontendController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use LucatBundle\Helper;
use Pimcore\Db;
use Pimcore\Model\Webservice\JsonEncoder;

class GridPanelController extends FrontendController
{
    /**
     * @Route("/lucat/gridpanel/get-users")
     */
    public function getUsersAction()
    {
        $db = Db::get();

        $sql = 'SELECT id,name,firstname,lastname FROM users WHERE password IS NOT NULL';
        $users = $db->fetchAll($sql);

        JsonEncoder::encode($users);
    }

    /**
     * Get grid-data
     *
     * @Route("/lucat/gridpanel/get")
     * @return JSON
     */
    public function getAction(Request $request)
    {
        try 
        {
            $sort = json_decode((string)$request->get('sort'));
            $result = Helper\LucatHelper::getPerRole([
                'offset' => $request->get('start'),
                'limit' => $request->get('limit'),
                'sort' => json_decode($request->get('sort'))[0],
                'filter' => '%' . $request->get('filter') . '%',
                'fields' => $request->get('fields'),
                'order' => isset($sort[0]->direction) ? $sort[0]->direction : 'DESC',
                'orderBy' => isset($sort[0]->property) ? $sort[0]->property : 'role.o_creationDate'
            ]);
        } 
        catch(\Exception $e)
        {

            JsonEncoder::encode([
                'message' => $e->getMessage(),
                'id' => null,
                'success' => false,
                'total' => 0
            ]);
        }

        JsonEncoder::encode([
            'data' => $result['data'],
            'total' => $result['totalCount'],
            'success' => true
        ]);
    }

    /**
     * @Route("/lucat/gridpanel/export")
     */
    public function exportAction(Request $request)
    {
        try 
        {
            $result = Helper\LucatHelper::getPerRole([
                'sort' => json_decode($request->get('sort'))[0],
                'filter' => '%' . $request->get('filter') . '%',
                'fields' => $request->get('fields'),
                'order' => isset($sort->direction) ? $sort->direction : 'DESC',
                'orderBy' => isset($sort->property) ? $sort->property : 'role.o_creationDate'
            ]);
        } 
        catch(\Exception $e)
        {
            JsonEncoder::encode([
                'message' => $e->getMessage(),
                'id' => null,
                'success' => false,
                'total' => 0
            ]);
        }

        Helper\Csv::output(array_values(self::array_unique_multidimensional($result['data'])), 'lucat-export-' . date('Y-m-d Hi'));
    }

    private static function array_unique_multidimensional($input)
    {
        $serialized = array_map('serialize', $input);
        $unique = array_unique($serialized);
        return array_intersect_key($input, $unique);
    }
}