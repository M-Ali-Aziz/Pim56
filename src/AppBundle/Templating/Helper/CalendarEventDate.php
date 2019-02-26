<?php

declare(strict_types=1);

/**
* Calendar Event templating Helper
*
* View helper formats a calendar start and end event date.
*
* @author Jonas Ledendal <Jonas.Ledendal@har.lu.se>, M. Ali
*/

namespace AppBundle\Templating\Helper;

use Symfony\Component\Templating\Helper\Helper;

class CalendarEventDate extends Helper
{
    /**
    * @inheritDoc
    */
    public function getName()
    {
        return 'calendarEventDate';
    }

    public function __invoke($language, $startDate, $endDate, $displayEndDate = false)
    {
        $html = "";
        $language = $language;
        $startDate_Date = get_object_vars($startDate)['date'];
        $endDate_Date = get_object_vars($endDate)['date'];

        //get start and end day and month
        $startDay   = date('j', strtotime($startDate_Date));
        $startMonth = date('n', strtotime($startDate_Date));
        $endDay     = date('j', strtotime($endDate_Date));
        $endMonth   = date('n', strtotime($endDate_Date));
        $timeLang   = ($language == 'sv') ? 'kl.' : 'at';


        if($displayEndDate == false) { //only display the start date
            $html .= strftime('%e %B %Y', strtotime($startDate_Date)) . " $timeLang " . date('H:i', strtotime($startDate_Date));
        }
        else if(date('H:i', strtotime($startDate_Date)) == '00.00') { //don't show time if 00.00
            $html .= strftime('%e %B %Y', strtotime($startDate_Date));
        }
        else if ($startDay == $endDay && $startMonth == $endMonth) { //same day and month
            $html .= strftime('%e %B %Y', strtotime($startDate_Date)) . " $timeLang ". date('H:i', strtotime($startDate_Date)) . '&ndash;' . date('H:i', strtotime($endDate_Date));
        }
        else if ($startDay != $endDay && $startMonth == $endMonth) {//different days, but same month
            $html .= strftime('%e', strtotime($startDate_Date)) . '&ndash;' . strftime('%e %B %Y', strtotime($endDate_Date));
        }
        else if ($startDay != $endDay && $startMonth != $endMonth) {//different days and different months
            $html .= strftime('%e %B', strtotime($startDate_Date)) . '&ndash;' . strftime('%e %B %Y', strtotime($endDate_Date));
        }

        else { //display the entire start and end date as a catch all
            $html .= strftime('%A %e %B %Y', strtotime($startDate_Date)) . '&ndash;' . strftime('%A %e %B %Y', strtotime($endDate_Date));
        }

        return $html;
    }
}
