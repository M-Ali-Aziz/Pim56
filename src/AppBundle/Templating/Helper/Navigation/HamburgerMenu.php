<?php

declare(strict_types=1);

namespace AppBundle\Templating\Helper\Navigation;

use Symfony\Component\Templating\Helper\Helper;
use \Pimcore\Navigation\Container;

class HamburgerMenu extends Helper
{
    protected $_shortcuts;

    protected $_mainMenu;

    protected $_mainSite = false;

    protected $_lusemSite = false;

    protected $_language;

    /**
    * @inheritDoc
    */
    public function getName()
    {
        return 'hamburgerMenu';
    }

    public function __invoke($params = [])
    {
        if (null !== $params) {
            $this->setShortcuts($params['shortcuts']);
            $this->setMainMenu($params['mainMenu']);
            $this->setMainSite($params['mainSite']);
            $this->setLusemSite($params['lusemSite']);
            $this->setLanguage($params['language']);
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

    public function setLanguage($value)
    {
        $this->_language = $value;

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

    public function getLanguage()
    {
        return $this->_language;
    }

    public function htmlify($page)
    {
        $html = "";

        $label = $page->getLabel();

        // if lable is longer than 27 characters the truncate label
        if (mb_strlen($label) > 27) {
            $label = mb_substr($label, 0, 25) . '...';
        }

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
                                $html .= PHP_EOL . '<ul class="menu-level-1">' . PHP_EOL;
                                $html .= PHP_EOL . '<li class=""><a href="/">Start</a></li>' . PHP_EOL;
                                break;
                                case 1:
                                $html .= PHP_EOL . '<ul class="menu-level-2">' . PHP_EOL;
                                break;
                                case 2:
                                $html .= PHP_EOL . '<ul class="menu-level-3">' . PHP_EOL;
                                break;
                                case 3:
                                $html .= PHP_EOL . '<ul class="menu-level-4">' . PHP_EOL;
                                break;
                                case 4:
                                $html .= PHP_EOL . '<ul class="menu-level-5">' . PHP_EOL;
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
                        if ($page->hasPages()) $liClass = ' class="has_sub"';
                        else $liClass = '';

                        /*if ($page->isActive()){
                        if ($page->hasPages()) $liClass = ' class="has_sub selected"';
                        else $liClass = ' class="selected"';
                        }*/

                        if ($this->isSelected($page)) {
                            if ($page->hasPages()) $liClass = ' class="has_sub selected"';
                            else $liClass = ' class="selected"';
                        }

                        if ($page->hasPages()) $link_expand = '<a class="responsive_link expand"></a>';
                        else $link_expand = "";



                        $html .= '<li' . $liClass . '>'. $this->htmlify($page) . $link_expand;

                        // store current depth as previous depth for next iteration
                        $prevDepth = $depth;
                    }
                }
            }

            if ($html) {
                // done iterating container; close open ul/li tags
                for ($i = $prevDepth + 1; $i > 0; $i--) {
                    //responsive shortcuts
                    if($i == 1) {
                        if ($this->_shortcuts && $this->isMainSite()) {
                            $label = ($this->getLanguage() == 'sv') ? 'Genvägar' : 'Shortcuts';
                            $html .= '<li class="responsive-shortcuts has_sub"><a href="#">' . $label . '</a><a class="responsive_link expand"></a>';
                            $html .= '<ul class="menu-level-2">';
                            foreach($this->_shortcuts as $page) {
                                $html .= '<li><a href="' . $page['uri'] . '">' . $page['label'] . '</a></li>';
                            }
                            $html .= '</ul>';
                            $html .= '</li>' . PHP_EOL;
                        }
                        if ($this->isLusemSite() == true && $this->isMainSite() == false) {
                            if ($this->getLanguage() == 'sv') {
                                $html .= '<li class="responsive-shortcuts"><a href="http://www.ehl.lu.se">Ekonomihögskolan</a></li>' . PHP_EOL;
                            }
                            else {
                                $html .= '<li class="responsive-shortcuts"><a href="http://www.lusem.lu.se">School of Economics & Management</a></li>' . PHP_EOL;
                            }
                        }
                    }
                    $html .= '</li>'. PHP_EOL . '</ul><!-- END -->' . PHP_EOL;
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
