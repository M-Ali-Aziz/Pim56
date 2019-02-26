<?php

namespace LucatBundle\Controller;

use Pimcore\Controller\FrontendController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Console\Input\ArrayInput;
use \Pimcore\Console\Application;
use Symfony\Component\HttpKernel\KernelInterface;

class SyncController extends FrontendController
{
    /**
     * @Route("/lucat/sync/lucat")
     */
    public function lucatAction(KernelInterface $kernel)
    {
        // Sync Lucat
        try {
            // Setting up terminal call to sync lucat
            $input = new ArrayInput([
                'command' => 'lucat:sync'
            ]);

            // Running terminal call
            $application = new Application($kernel);
            $application->run($input);
            
        } catch (\Exception $e) {
            return new Response($e->getMessage());
        }
    }
}
