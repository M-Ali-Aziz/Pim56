<?php

declare(strict_types=1);

/**
* Department phonenumber templating helper
*
* @author Jonas Ledendal, M. Ali
*/

namespace AppBundle\Templating\Helper;

use Symfony\Component\Templating\Helper\Helper;

class PhoneNumber extends Helper
{
    /**
    * @inheritDoc
    */
    public function getName()
    {
        return 'phoneNumber';
    }

    public function __invoke($telephoneNumber)
    {
        if( ! empty($telephoneNumber)) {
            return $telephoneNumber;
        }
        else {
            return ($this->view->language == 'sv') ?
            '046-222 00 00 (växel)' :
            '+46 46-222 00 00 (operator)';
        }
    }
}
