<?php
/**
 * @var \Pimcore\Templating\PhpEngine $this
 * @var \Pimcore\Templating\PhpEngine $view
 * @var \Pimcore\Templating\GlobalVariables $app
 */
?>

<?php
$pages = \Pimcore\Model\DataObject\Website::getByDomainName($this->domainname, ['limit' => 1]);
$pages = $pages->getMainMenu();
$requestUri = $this->getRequest()->getRequestUri();
$thisDoc = $this->document;
$navigation = $this->navigation();


/**
 * Create Menu li-tag
 * @return string
 */
function getLiTag($thisDoc, $navigation, $page)
{
    $navStartNode = $page;
    $mainNavigation = $navigation->buildNavigation($thisDoc, $navStartNode);
    /** @var \Pimcore\Navigation\Renderer\Menu $menuRenderer */
    $menuRenderer = $navigation->menu();

    $liTag = '';
    $liClass = 'nav-item dropdown dropdown-hover';
    $aHref = '/' . $navStartNode->getKey();
    foreach ($mainNavigation as $page) {
        if ($page->getActive(true)) {
            $liClass = 'nav-item dropdown dropdown-hover active';
        }
    }
    if ($thisDoc->getId() ==  $navStartNode->getId()) {
        $liClass = 'nav-item dropdown dropdown-hover active';
    }

    $liTag .='
        <li class="' . $liClass . '">
        <a class="nav-link text-nowrap dropdown-toggle" href="' . $aHref . '" aria-haspopup="true">' . $navStartNode->getProperty("navigation_name") . '</a>
        <div class="dropdown-menu font-size-base" aria-labelledby="dropdown-ehl-om-ekonomihogskolan">
    ';

    foreach ($mainNavigation as $page) {
        /* @var $page \Pimcore\Navigation\Page\Document */
        if (!$page->isVisible() || !$menuRenderer->accept($page)) { continue; }
        if ($page->getActive(true)){ $active = ' active'; }else{$active = '';}
        $liTag .='
            <a class="dropdown-item' . $active . '" href="' . $page->getHref() .'" aria-haspopup="true">' . $page->getLabel() .'</a>
        ';
    }

    $liTag .='</div></li>';

    return $liTag;
}
?>


<ul class="nav justify-content-end nav-header-main flex-nowrap">
    <?php foreach ($pages as $page) {
        echo getLiTag($thisDoc, $navigation, $page);
    }?>
</ul>