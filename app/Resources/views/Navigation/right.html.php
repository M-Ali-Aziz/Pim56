<?php
/**
 * @var \Pimcore\Templating\PhpEngine $this
 * @var \Pimcore\Templating\PhpEngine $view
 * @var \Pimcore\Templating\GlobalVariables $app
 */
?>
<!-- BEGIN subnav partial view -->
<?php
function isInActiveSubBranch($page)
{
  $parent = $page->getParent();

  if(get_class($parent) == '\Pimcore\Navigation\Container') return true;

  if ($parent->isActive()) {
    return true;
  }

  return false;	
}

$html = '';

// get navigation container from view
$container = $this->pages;

if ($container) {
  // create recursive iterator
  $iterator = new RecursiveIteratorIterator($container, RecursiveIteratorIterator::SELF_FIRST);

  $prevDepth = -1;

  // iterate container
  foreach ($iterator as $page) {
    $depth = $iterator->getDepth();

    if(isInActiveSubBranch($page) && $page->getVisible()) {
      if ($depth > $prevDepth) {
        // start new ul tag
        $html .= PHP_EOL . '<ul>' . PHP_EOL;
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
      if ($page->hasPages()) $liClass = 'has_submenu';
      else $liClass = '';

      if($page->isActive()) {
        $liClass = $liClass . " active";
        $page->setClass(" active");
      }

      $liClass = ' class="'.$liClass.'"';

      if ($page->hasPages() && $page->getClass() <> ' active') {
        $page->setClass("has_submenu");
      }

      $html .= '<li' . $liClass . '>'. $this->navigation()->menu()->htmlify($page);

      // store as previous depth for next iteration
      $prevDepth = $depth;
    }
  }

  if ($html) {
    // done iterating container; close open ul/li tags
    for ($i = $prevDepth+1; $i > 0; $i--) {
      $html .= '</li>'. PHP_EOL . '</ul>' . PHP_EOL;
    }
  }
}
// actually render the subnav menu
echo $html;
?>
<!-- END subnav partial view -->
