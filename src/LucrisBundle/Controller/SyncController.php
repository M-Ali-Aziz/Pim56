<?php

namespace LucrisBundle\Controller;

use Pimcore\Controller\FrontendController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use \Pimcore\Tool\Frontend;
use Pimcore\Model\DataObject\Folder;
use Symfony\Component\Console\Input\ArrayInput;
use \Pimcore\Console\Application;
use Symfony\Component\HttpKernel\KernelInterface;


class SyncController extends FrontendController
{
    /**
     * @Route("/lucris/sync/organisation")
     */
    public function organisationAction(KernelInterface $kernel) {
        // Get ParentId
        $parentId = Frontend::getWebsiteConfig()->lucrisOrgParentId;

        // Check if the folder exist
        $folderId = Folder::getById($parentId);

        if ($folderId) {
            if (strtolower($folderId->getKey()) === "lucrisorganisation") {
                try {
                    // Setting up terminal call to sync Organisations
                    $input = new ArrayInput([
                        'command' => 'lucris:organisation',
                        '--parentId' => $parentId
                    ]);

                    // Running terminal call
                    $application = new Application($kernel);
                    $application->run($input);
                    
                } catch (\Exception $e) {
                    return new Response($e->getMessage());
                }

            }
        }
    }

    /**
     * @Route("/lucris/sync/person")
     */
    public function personAction(KernelInterface $kernel) {
        // Get ParentId
        $parentId = Frontend::getWebsiteConfig()->lucrisPersonParentId;

        // Check if the folder exist
        $folderId = Folder::getById($parentId);
        
        if ($folderId) {
            if (strtolower($folderId->getKey()) === "lucrisperson") {
                try {
                    // Setting up terminal call to sync Persons
                    $input = new ArrayInput([
                        'command' => 'lucris:person',
                        '--parentId' => $parentId
                    ]);

                    // Running terminal call
                    $application = new Application($kernel);
                    $application->run($input);
                    
                } catch (\Exception $e) {
                    return new Response($e->getMessage());
                }   
            }
        }
    }
}
