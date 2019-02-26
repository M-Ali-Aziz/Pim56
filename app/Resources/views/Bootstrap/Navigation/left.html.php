<?php
/**
 * @var \Pimcore\Templating\PhpEngine $this
 * @var \Pimcore\Templating\PhpEngine $view
 * @var \Pimcore\Templating\GlobalVariables $app
 */
?>

<?php
if (!function_exists('isVisible')) {
    function isVisible($page)
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

        /*Exclude from navigation is not inherited.*/
        $parent = $page->getParent();

        if (is_a($parent, 'Pimcore\Navigation\Page\Document')) {
            if (!$parent->getVisible()) {
                $result = false;
            }
        }

        return $result;
    }
}

if (!function_exists('getATag')) {
    function getATag($thisParam, $page) {
        $aTag = '';
        if (!$page->hasPages()) {
            $aClass = "nav-link";
            if ($page->getActive(true)) $aClass = "nav-link active";
            $aTag= '<a href="' . $page->getHref() . '" class="'. $aClass . '">' .
                $thisParam->translate($page->getLabel()) .
            '</a>';
        } else {
            $aClass = "nav-link collapse collapsed";
            $chevronClass = "fal fa-chevron-right";
            if ($page->getActive(true)) {
                $aClass = "nav-link collapse active";
                $chevronClass = "fal fa-chevron-down";
            }
            if ($page->getPages()) {
                foreach ($page->getPages() as $p) {
                    if($p->getActive(true)) $aClass = "nav-link collapse";
                }
            }
            $aTag = '<a href="' . $page->getHref() . '" class="'. $aClass . '">' .
                '<div class="float-right ml-2"><i class="' . $chevronClass . '"></i></div>' .
                $thisParam->translate($page->getLabel()) .
            '</a>';
        }

        return $aTag;
    }
}

$html = '';

// get navigation container from view
$container = $this->pages;

$minDepth = 0;

if ($container) {
    // create recursive iterator
    $iterator = new RecursiveIteratorIterator($container, RecursiveIteratorIterator::SELF_FIRST);

    $prevDepth = -1;

    // iterate container
    foreach ($iterator as $page) {
        $depth = $iterator->getDepth();

        if ($depth < $minDepth) {
            // page is below minDepth
            continue;
        } else {
            if (isVisible($page)) {
                if ($depth > $prevDepth) {
                    // start new ul tag
                    switch($depth) {
                        case 0:
                        $html .= PHP_EOL . '<ul class="nav-accordion nav-collapse nav-undecorated">' . PHP_EOL;
                        break;
                        case 1:
                        $ulClass = 'nav-accordion collapse';
                        if ($page->getParent()->getActive(true)) $ulClass .= ' show';
                        $html .= PHP_EOL . '<ul class="' . "$ulClass" . '">' . PHP_EOL;
                        break;
                        case 2:
                        $ulClass = 'nav-accordion collapse';
                        if ($page->getParent()->getActive(true)) $ulClass .= ' show';
                        $html .= PHP_EOL . '<ul class="' . "$ulClass" . '">' . PHP_EOL;
                        break;
                        case 3:
                        $ulClass = 'nav-accordion collapse';
                        if ($page->getParent()->getActive(true)) $ulClass .= ' show';
                        $html .= PHP_EOL . '<ul class="' . "$ulClass" . '">' . PHP_EOL;
                        break;
                        case 4:
                        $ulClass = 'nav-accordion collapse';
                        if ($page->getParent()->getActive(true)) $ulClass .= ' show';
                        $html .= PHP_EOL . '<ul class="' . "$ulClass" . '">' . PHP_EOL;
                        break;
                    }
                } else if ($prevDepth > $depth) {
                    // close li/ul tags until we're at current depth
                    for ($i = $prevDepth; $i > $depth; $i--) {
                        $html .= '</ul>' . PHP_EOL;
                        $html .= '</li>' . PHP_EOL;
                    }
                    // close previous li tag
                    $html .= '</li>' . PHP_EOL;
                } else {
                    // close previous li tag
                    $html .= '</li>' . PHP_EOL;
                }

                $html .= '<li>'. getATag($this, $page);

                // store as previous depth for next iteration
                $prevDepth = $depth;
            }
        }
    }

    if ($html) {
        // done iterating container; close open ul/li tags
        for ($i = $prevDepth+1; $i > 0; $i--) {
            $html .= '</li>'. PHP_EOL . '</li><!-- END -->' . PHP_EOL;
            if ($i == 1) $html .= '</ul>' . PHP_EOL;
        }
    }
}
// Render the left-nav menu
echo $html;
?>
