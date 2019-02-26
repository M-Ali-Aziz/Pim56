<?php

declare(strict_types=1);

/**
* Summary templating helper
*
* View helper returns a text summary specified by length. The result
* is UTF-8 safe.
*
* @author Jimmi Elofsson <hi@jimmi.eu>, M. Ali
*
*/

namespace AppBundle\Templating\Helper;

use Symfony\Component\Templating\Helper\Helper;

class Summary extends Helper
{
    /**
    * @inheritDoc
    */
    public function getName()
    {
        return 'summary';
    }

    public function __invoke($text, $length = 255, $endWith = '...')
    {
        if ($text) {
            $summary = mb_substr($text, 0, $length, 'utf-8');
            if(mb_strlen($summary, 'utf-8') < mb_strlen($text, 'utf-8')) {
                $summary .= $endWith;
            }

            return (strlen($summary) > strlen($endWith)) ? $summary : '';
        }
    }
}
