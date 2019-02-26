<?php

namespace AppBundle\Command;

use Pimcore\Console\AbstractCommand;
use Pimcore\Console\Dumper;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
Use \Pimcore\Model\DataObject;

class VenueExportCommand extends AbstractCommand
{
    protected function configure()
    {
        $this
            ->setName('events:venue_export')
            ->setDescription('Events Object - Venue export');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $events = new DataObject\Events\Listing();
        $events->setUnpublished(true);
        foreach ($events as $event) {
            if ($event->getVenue2()) {
                $venue = $event->getVenue2();
                $venueId = $event->getVenue2Id();

                $event->setVenue($venueId);
                $event->save();

                $this->output->writeln(sprintf('<info> Exported: (venue: %s with id: %s)</info>', $venue, $venueId));
            }
        }
        
        $this->dump("Done!", Dumper::NEWLINE_BEFORE | Dumper::NEWLINE_AFTER);
    }
}