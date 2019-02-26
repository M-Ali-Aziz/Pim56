<?php 

namespace LucrisBundle\Command;
 
use Pimcore\Console\AbstractCommand;
use Pimcore\Console\Dumper;
use Pimcore\Model\DataObject\Folder;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputOption;
use LucrisBundle\Model;

/**
 * This is the class that create a Command-lind in Pimcore Console to
 * Sync Lucris Organisations.
 *
 * @copyright  Copyright (c) 2018 Ekonomihögskolan (http://ehl.lu.se)
 * @author Mohammed Ali
 *
 */
class LucrisOrganisationCommand extends AbstractCommand
{
    protected function configure()
    {
        $this
            ->setName('lucris:organisation')
            ->setDescription('Lucris Organisation Sync')
            ->addOption(
                'parentId', 'p',
                InputOption::VALUE_REQUIRED,
                'Folder Id for LucrisOrganisation on Admin-page -> Objects'
            );
    }
 
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        // Check if ParentId
        $parentId = $input->getOption('parentId');
        if (!$parentId) {
            $this->output->writeln("<error>Stopping: parentId is required!</error>");
            $this->output->writeln("<comment>plsease check ( lucris:organisation -h ) command for more inormation.</comment>");
            return;
        }

        // Check if parentId is valid
        $folderId = Folder::getById($parentId);
        if($folderId == NULL || $folderId->getO_type() != 'folder') {
            // No folder to export into.
            $this->output->writeln(sprintf('<error>Stopping: %s %s</error>','no folder found with ID:', $parentId));
            $this->output->writeln("<comment>plsease check ( lucris:organisation -h ) command for more inormation.</comment>");
            return;
        }

        // Sync Lucris Organisation
        try {
            $sync = new Model\OrganisationProvider();
            $this->output->writeln("<info>Syncing Lucris Organisation ...</info>");
            $this->output->writeln("<comment>Please wait ...</comment>");
            $sync->createOrganisations($parentId);
            $this->output->writeln("<info>Successfully synced Lucris Organisation.</info>");
            $this->dump("Done!", Dumper::NEWLINE_BEFORE | Dumper::NEWLINE_AFTER);
        } catch (\Exception $e) {
            echo $e->getMessage();   
        }
    }
}
