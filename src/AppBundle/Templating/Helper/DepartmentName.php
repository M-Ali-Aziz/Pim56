<?php

declare(strict_types=1);

/**
* Department name templating helper
*
* @author Jonas Ledendalm, M. Ali
*
*/

namespace AppBundle\Templating\Helper;

use Symfony\Component\Templating\Helper\Helper;

class DepartmentName extends Helper
{
    /**
    * @inheritDoc
    */
    public function getName()
    {
        return 'departmentName';
    }

    public function __invoke($departmentNumber, $locale = 'sv')
    {
        $values = $this->getDepartments();

        $name = $values[$departmentNumber][$locale];

        if (empty($name)) {
            $name = ($locale == 'sv') ? 'Namnlös institution (' . $departmentNumber . ')': 'Untitled department (' . $departmentNumber . ')';
        }

        return $name;
    }

    protected function getDepartments()
    {
        return array();
    }
}
