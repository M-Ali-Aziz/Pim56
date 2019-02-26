<?php 

namespace LucatBundle\Command;
 
use Pimcore\Console\AbstractCommand;
use Pimcore\Console\Dumper;
use Pimcore\Model\DataObject\Folder;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputOption;
use LucatBundle\Model;

/**
 * This is the class that create a Command-lind in Pimcore Console to
 * Sync Lucat.
 *
 * @copyright  Copyright (c) 2018 Ekonomihögskolan (http://ehl.lu.se)
 * @author Mohammed Ali
 *
 */
class LucatSyncCommand extends AbstractCommand
{
    protected function configure()
    {
        $this
            ->setName('lucat:sync')
            ->setDescription('Lucat Sync');
    }
 
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        // Sync Lucat
        try {
            // Sync Lucat Organisation
            $syncOrganisation = new Model\OrganisationProvider();
            $this->output->writeln("<comment>Syncing Lucat Organisation ...</comment>");
            $this->output->writeln("<comment>Please wait ...</comment>");
            $syncOrganisation->SynchronizeLucatOrganisation();
            $this->output->writeln("<info>Successfully synced Lucat Organisation.</info>");

            // Sync Lucat Roll
            $syncRoll = new Model\RollProvider();
            $this->output->writeln("<comment>Syncing Lucat Roll ...</comment>");
            $this->output->writeln("<comment>Please wait ...</comment>");
            $syncRoll->SynchronizeLucatRoll();
            $this->output->writeln("<info>Successfully synced Lucat Roll.</info>");

            // Sync Lucat Person
            $syncPerson = new Model\PersonProvider();
            $this->output->writeln("<comment>Syncing Lucat Person ...</comment>");
            $this->output->writeln("<comment>Please wait ...</comment>");
            $syncPerson->SynchronizeLucatPerson();
            $this->output->writeln("<info>Successfully synced Lucat Person.</info>");

            // Add log to var/log/lucat.log
            \Pimcore\Log\Simple::log("lucat", "LUCAT INFO: Successfully synced Lucat. " . __FILE__ . " Line: " . __LINE__);

            $this->dump("Done!", Dumper::NEWLINE_BEFORE | Dumper::NEWLINE_AFTER);
        } catch (\Exception $e) {
            // Add log to var/log/lucat.log
            \Pimcore\Log\Simple::log("lucat", "LUCAT ERROR: " . $e->getMessage() . " " . __FILE__ . " Line: " . __LINE__);

            echo $e->getMessage();   
        }
    }
}
