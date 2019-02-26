<?php

declare(strict_types=1);

/**
* Research area templating helper
*
* @author Jonas Ledendal, M. Ali
*
*/

namespace AppBundle\Templating\Helper;

use Symfony\Component\Templating\Helper\Helper;

class ResearchArea extends Helper
{
    private static $areas;

    /**
    * @inheritDoc
    */
    public function getName()
    {
        return 'researchArea';
    }

    public function __invoke($id, $locale = 'sv')
    {
        $values = $this->getResearchAreas();

        $name = $values[$id]['en'];

        return $name;
    }

    protected function getResearchAreas()
    {
        try {
            if (empty(self::$areas)) {
                $service = new Website_Service_Lusem_Faculty();
                $areas = array(); // deprecated: $service->findAllResearchAreas();
                self::$areas = array();
                foreach($areas as $area) {
                    self::$areas[$area['id']] = $area['title'];
                }
            }
        }
        catch(Exception $e) {

        }

        return self::$areas;
    }
}
