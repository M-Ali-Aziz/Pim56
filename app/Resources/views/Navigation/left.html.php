<?php
/**
 * @var \Pimcore\Templating\PhpEngine $this
 * @var \Pimcore\Templating\PhpEngine $view
 * @var \Pimcore\Templating\GlobalVariables $app
 */
?>

<?php
if (!function_exists('isInActiveBranch')) {
    function isInActiveBranch($page)
    {
        $parent = $page->getParent();
        if(get_class($parent) == 'Pimcore\Navigation\Container') return true;
        if ($parent->isActive()) return true;
        return false;
    }
}

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
        if(is_a($parent, 'Pimcore\Navigation\Page\Document')) {
            if (!$parent->getVisible()) {
                $result = false;
            }
        }
        return $result;
    }
}

$html = '';
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
        }
        else {
            if(isInActiveBranch($page) && isVisible($page)) {
                if ($depth > $prevDepth) {
                    // start new ul tag
                    switch($depth) {
                        case 0:
                        $html .= PHP_EOL . '<nav id="content_navigation" class="grid-8 alpha hide-xs">' . PHP_EOL;
                        $html .= PHP_EOL . '<ul class="menu-level-1">' . PHP_EOL;
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

                if ($page->isActive()){
                    if ($page->hasPages()) $liClass = ' class="has_sub active"';
                    else $liClass = ' class="selected"';
                }

                $html .= '<li' . $liClass . '>'. $this->navigation()->menu()->htmlify($page);

                // store as previous depth for next iteration
                $prevDepth = $depth;
            }
        }
    }

    if ($html) {
        // done iterating container; close open ul/li tags
        for ($i = $prevDepth+1; $i > 0; $i--) {
            $html .= '</li>'. PHP_EOL . '</ul><!-- END -->' . PHP_EOL;
            if($i == 1) $html .= '</nav>' . PHP_EOL;
        }
    }
}
echo $html;
?>
