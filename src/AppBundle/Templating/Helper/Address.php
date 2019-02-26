<?php

declare(strict_types=1);

/**
* Department address templating helper
*
* @author Jonas Ledendal, M. Ali
*/

namespace AppBundle\Templating\Helper;

use Symfony\Component\Templating\Helper\Helper;

class Address extends Helper
{
    /**
    * @inheritDoc
    */
    public function getName()
    {
        return 'address';
    }

    public function __invoke($department)
    {
        $html = "";

        if (is_array($department)) {
          $address = (array_key_exists('address', $department)) ? $department['address'] : null;
          if (is_array($address)) {
            if ($this->view->language == 'sv') {
              $html = $address['postofficebox'] . ', ' . $address['postcode'] . ' ' . $address['city'];
            }
            else {
              $html = $address['postofficebox'] . ', SE-' . $address['postcode'] . ' ' . $address['city'] . ', Sweden';
            }
          }
        }

        return $html;
    }
}
