<?php

declare(strict_types=1);

namespace AppBundle\Templating\Helper\Navigation;

use Symfony\Component\Templating\Helper\Helper;
use \Pimcore\Navigation\Container;

class Dropdown extends Helper
{
    protected $_shortcuts;

    protected $_mainMenu;

    protected $_mainSite = false;

    protected $_lusemSite = false;

    /**
    * @inheritDoc
    */
    public function getName()
    {
        return 'dropdown';
    }
  
    public function __invoke($params = [])
    {
        if (null !== $params) {
            $this->setShortcuts($params['shortcuts']);
            $this->setMainMenu($params['mainMenu']);
            $this->setMainSite($params['mainSite']);
            $this->setLusemSite($params['lusemSite']);
        }

        return $this;
    }

    public function setShortcuts($values)
    {
        $this->_shortcuts = $values;

        return $this;
    }

    public function setMainMenu($values)
    {
        $this->_mainMenu = $values;

        return $this;
    }

    public function setMainSite($value)
    {
        $this->_mainSite = ($value) ? true : false;

        return $this;
    }

    public function setLusemSite($value)
    {
        $this->_lusemSite = ($value) ? true : false;

        return $this;
    }

    public function isLusemSite()
    {
        return ($this->_lusemSite) ? true : false;
    }


    public function isMainSite()
    {
        return ($this->_mainSite) ? true : false;
    }

    public function htmlify($page)
    {
        $html = "";

        $label = $page->getLabel();

        $html .= '<a href="' . $page->getHref() . '">' . $label . '</a>';

        return $html;
    }

    protected function isInMainMenu($page)
    {
        $result = false;

        foreach($this->_mainMenu as $node) {
            if (substr($page->getHref(), 0, strlen($node['uri'])) == $node['uri']) {
                $result = true;        
            }
        }

        return $result;
    }

    protected function isVisible($page)
    {
        $result = true;
        if (!$page->getVisible()) {
            $result = false;
            $pages = $page->getPages();
            if ($pages) {
                foreach($pages as $child) {
                    $child->setVisible(false);
                }
            }
        }

        // exclude from navigation is not inherited
        $parent = $page->getParent();

        if(is_a($parent, '\Pimcore\Navigation\Page\Document')) {
            if (!$parent->getVisible()) {
                $result = false;
            }
        }

        return $result;
    }

    protected function isSelected($page)
    {
        return ($page->getHref() == $_SERVER['REQUEST_URI']) ? true : false;
    }

    public function renderMenu(Container $container = null)
    {
        // initalize default options
        $html = "";
        $minDepth = 0;

        if ($container) {
            // create recursive iterator
            $iterator = new \RecursiveIteratorIterator($container, \RecursiveIteratorIterator::SELF_FIRST);

            // initialize previous depth
            $prevDepth = -1;

            // iterate container
            foreach ($iterator as $page) {
                // get current depth
                $depth = $iterator->getDepth();

                // do not render pages blow minimum depth
                if ($depth < $minDepth) {
                    continue;
                }
                else {
                    // do not render invisble pages
                    if($this->isInMainMenu($page) && $this->isVisible($page)) {
                        // if depth is higher than previous depth then start a new ul tag
                        if ($depth > $prevDepth) {
                            // start new ul tag
                            switch($depth) {
                                case 0:
                                $html .= PHP_EOL . '<ul class="menuzord-menu">' . PHP_EOL;
                                break;
                                case 1:
                                $html .= PHP_EOL . '<ul class="dropdown">' . PHP_EOL;
                                break;
                                case 2:
                                $html .= PHP_EOL . '<ul class="dropdown">' . PHP_EOL;
                                break;
                                case 3:
                                $html .= PHP_EOL . '<ul class="dropdown">' . PHP_EOL;
                                break;
                                case 4:
                                $html .= PHP_EOL . '<ul class="dropdown">' . PHP_EOL;
                                break;
                            }
                        }
                        else if ($prevDepth > $depth) {
                            // close li/ul tags until we're at current depth
                            for ($i = $prevDepth; $i > $depth; $i--) {
                                $html .= '</li>' . PHP_EOL;
                                $html .= '</ul>' . PHP_EOL;
                            }
                            // close previous li tag
                            $html .= '</li>' . PHP_EOL;
                        } else {
                            // close previous li tag
                            $html .= '</li>' . PHP_EOL;
                        }

                        // render li tag and page
                        if ($page->hasPages()) $liClass = '';
                        else $liClass = '';

                        if ($page->isActive()){
                            if ($page->hasPages()) $liClass = ' class="active"';
                            else $liClass = '';
                        }

                        if ($this->isSelected($page)) {
                            $liClass = ' class="active"';
                        }

                        $html .= '<li' . $liClass . '>'. $this->htmlify($page);

                        // store current depth as previous depth for next iteration
                        $prevDepth = $depth;
                    }
                }
            }
        }

        return $html;
    }

    public function render(Container $container = null)
    {
        $html = "";

        if (null === $container) {
            $container = $this->getContainer();
        }

        $html = $this->_renderMenu($container);

        return $html;
    }
}
