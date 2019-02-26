<?php

declare(strict_types=1);

/**
* Comma-separated values templating helper
*
* View helper returns an array as a row of comma-separated values.
*
* @author Jonas Ledendal, M. Ali
*
*/

namespace AppBundle\Templating\Helper;

use Symfony\Component\Templating\Helper\Helper;

class CommaSeparatedValues extends Helper
{
    /**
    * @inheritDoc
    */
    public function getName()
    {
        return 'commaSeparatedValues';
    }

    public function __invoke($values)
    {
        $html = "";

        $list = array();
        foreach($values as $i => $value) {
          if ($value) {
            array_push($list, trim((string)$value));
          }
        }

        foreach($list as $i => $value) {
          $html .= $value;
          if ($list[$i+1]) $html .= ", ";
        }

        return $html;
    }
}
