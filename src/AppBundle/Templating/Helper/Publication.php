<?php

declare(strict_types=1);

/**
* Publication tempating helper
*
* Formats a LUP record as html.
*
* @author Jonas Ledendal, M. Ali
*
*/

namespace AppBundle\Templating\Helper;

use Symfony\Component\Templating\Helper\Helper;

class Publication extends Helper
{
    /**
    * @inheritDoc
    */
    public function getName()
    {
        return 'publication';
    }

    /**
    * @param Website_Service_Lu_Lup_Result $record
    * @return string
    */
    public function __invoke(Website_Service_Lu_Lup_Result $record, $language = 'sv')
    {
        $html = "";
 
        //authors
        $authors = $record->getAuthors();

        foreach($authors as $i => $author) {
            if ($i+1 == count($authors) && $authors) {
                $html .= ($language == 'sv') ? 'och ': 'and ';
            }

            $html .= $author['surname'] . ', ' . $author['givenname'];

            if ($i+1 == count($authors) ) {
                $html .= '. ';
            }
            else {
                $html .= ', ';
            }
        }

        //title
        if ($record->isPart()) {
            $html .= $record->title . '. ';
        }
        else {
            $html .= '<em>' . $record->title . '</em>. ';
        }

        //host
        if ($record->isPart()) {
            $html .= ($language == 'sv') ? 'I ': 'In ';
            $html .= '<em>' . $record->getHostTitle() . '</em>. ';

            //editors
            $authors = $record->getEditors();
            if ($authors) {
                foreach($authors as $i => $author) {
                  if ($i+1 == count($authors) && $authors) {
                    $html .= ($language == 'sv') ? 'och ': 'and ';
                  }
                  $html .= $author['surname'] . ', ' . $author['givenname'];
                  if ($i+1 == count($authors) ) {
                    $html .= '. ';
                  }
                  else {
                    $html .= ', ';
                  }
                }
                $html .= ($language == 'sv') ? '(red.) ': '(eds.) ';
            }
            if (isset($record->host['extent']['start']) && isset($record->host['extent']['end'])) {
                $html .= ', ' . $record->host['extent']['start'] . '-' . $record->host['extent']['end'] . '. ';
            }
        }

        //publisher and publishing year
        $html .= $record->publisher . ', ' . $record->dateIssued . '.';

        return $html;
    }
}
