<?php
/**
 * @var \Pimcore\Templating\PhpEngine $this
 * @var \Pimcore\Templating\PhpEngine $view
 * @var \Pimcore\Templating\GlobalVariables $app
 */
?>

<?php
$pages = \Pimcore\Model\DataObject\Website::getByDomainName($this->website['domainname'], ['limit' => 1]);
$mainMenuPages = $pages->getMainMenu();
$targetGroupsPages = $pages->getTargetGroups();
$subsitesPages = $pages->getSubsites();
$thisDoc = $this->document;
$navigation = $this->navigation();
// $requestUri = $this->getRequest()->getRequestUri();
?>

<?php
/**
 * Create Menu Ul-Class
 */
function getMenuUlClass($thisDoc, $page, $navigation)
{
    $navStartNode = $page;
    $mainNavigation = $navigation->buildNavigation($thisDoc, $navStartNode);
    /** @var \Pimcore\Navigation\Renderer\Menu $menuRenderer */
    $menuRenderer = $navigation->menu();

    $ulClass = 'mobile-nav collapse';
    foreach ($mainNavigation as $p) {
        if ( $p->getActive(true) || ($thisDoc->getId() == $page->getId()) ) {
            $ulClass = 'mobile-nav collapse show';
        }
    }

    return $ulClass;
}


/**
 * Create Menu A-tag
 * @return string
 */
function getMenuATag($thisDoc, $navigation, $page)
{

    $navStartNode = $page;
    $mainNavigation = $navigation->buildNavigation($thisDoc, $navStartNode);
    /** @var \Pimcore\Navigation\Renderer\Menu $menuRenderer */
    $menuRenderer = $navigation->menu();

    $aTag = '';
    $aCollapsed = 'collapsed';
    $hasChild = false;
    $childIsActive = false;

    if ($page->getChilds()) {
        foreach ($page->getChilds() as $child) {
            if ($child->getType() == 'page' || $child->getType() == 'link') {
                $hasChild = true;
            }
        }
    }

    if (!$hasChild) {
        if ($thisDoc->getId() == $page->getId()) {
            $aTag = '<span class="nav-link active">' .
                $page->getProperty('navigation_name') .
            '</span>';
        } else {
            $aTag = '<a href="' . $page->getHref() . '" class="nav-link">' .
                $page->getProperty('navigation_name') .
            '</a>';
        }
    } else {

        foreach ($mainNavigation as $p) {
            if ($p->getActive(true)) {
                $aCollapsed = '';
            }
        }

        if ($thisDoc->getId() == $page->getId()) {
            
            $aCollapsed = '';

            $aTag = '<span class="nav-link active">' .
                $page->getProperty('navigation_name') .
            '</span>';
        } else {
            $aTag = '<a href="' . $page->getHref() . '" class="nav-link">' .
                $page->getProperty('navigation_name') .
            '</a>';
        }

        $aTag .= '
            <a href="#' . $page->getKey() .
            '" class="mobile-nav-toggle ' . $aCollapsed . '"' . 
            ' data-target="#' . $page->getKey() . 
            '" data-toggle="collapse" aria-expanded="false"' . 
            ' aria-controls="' . $page->getKey() . '">' .
            '<span class="collapse-show">
                <i class="fal fa-plus-circle"></i>
            </span>
            <span class="collapse-hide">
                <i class="fal fa-minus-circle"></i>
            </span>' .
        '</a>';
    }

    return $aTag;
}
?>

<div class="modal fade" id="nav-mobile" tabindex="-1" role="dialog" aria-labelledby="nav-mobile-label" aria-hidden="true">
<div class="modal-dialog my-0 mx-auto" role="document">
    <div class="modal-content border-0 rounded-0">

        <nav class="nav border-bottom p-3 flex-row justify-content-between align-items-center sticky-top bg-white">
            <div id="nav-mobile-label" class="h3 m-0"><span class="sr-only"></span></div>
            <button type="button" class="border-0 bg-transparent cursor-pointer lh-0 p-2 nm-2" data-dismiss="modal" aria-controls="mobileMenu" aria-expanded="false" aria-label="Dölj meny">
                <span aria-hidden="true"><i class="fal fa-times fa-lg"></i></span>
            </button>
        </nav>
        
        <ul class="mobile-nav mobile-nav-root border-0 nav-collapse font-size-sm nav-undecorated">

<!-- MainMenu Pages -->
<?php if ($mainMenuPages): ?>
<?php foreach ($mainMenuPages as $page): ?>
    <li class="mobile-nav-item">
    <div class="mobile-nav-container">
        <?php echo getMenuATag($thisDoc, $navigation, $page); ?>
    </div>

<?php if ($page->getChilds()): ?>
    <ul class="<?php echo getMenuUlClass($thisDoc, $page, $navigation); ?>" id="<?php echo $page->getKey(); ?>">
<?php foreach ($page->getChilds() as $child): ?>
<?php if ($child->getType() == 'page' || $child->getType() == 'link'): ?>
<?php if (!$child->getProperty('navigation_exclude')): ?>
    <li class="mobile-nav-item">
    <div class="mobile-nav-container">
    <?php echo getMenuATag($thisDoc, $navigation, $child); ?>
    </div>

        <?php if ($child->getChilds()): ?>
            <ul class="<?php echo getMenuUlClass($thisDoc, $child, $navigation); ?>" id="<?php echo $child->getKey(); ?>">
        <?php foreach ($child->getChilds() as $child1): ?>
        <?php if ($child1->getType() == 'page' || $child1->getType() == 'link'): ?>
        <?php if (!$child1->getProperty('navigation_exclude')): ?>
            <li class="mobile-nav-item">
            <div class="mobile-nav-container">
            <?php echo getMenuATag($thisDoc, $navigation, $child1); ?>
            </div>

                <?php if ($child1->getChilds()): ?>
                    <ul class="<?php echo getMenuUlClass($thisDoc, $child1, $navigation); ?>" id="<?php echo $child1->getKey(); ?>">
                <?php foreach ($child1->getChilds() as $child2): ?>
                <?php if ($child2->getType() == 'page' || $child2->getType() == 'link'): ?>
                <?php if (!$child2->getProperty('navigation_exclude')): ?>
                    <li class="mobile-nav-item">
                    <div class="mobile-nav-container">
                    <?php echo getMenuATag($thisDoc, $navigation, $child2); ?>
                    </div>

                        <?php if ($child2->getChilds()): ?>
                            <ul class="<?php echo getMenuUlClass($thisDoc, $child2, $navigation); ?>" id="<?php echo $child2->getKey(); ?>">
                        <?php foreach ($child2->getChilds() as $child3): ?>
                        <?php if ($child3->getType() == 'page' || $child3->getType() == 'link'): ?>
                        <?php if (!$child3->getProperty('navigation_exclude')): ?>
                            <li class="mobile-nav-item">
                            <div class="mobile-nav-container">
                            <?php echo getMenuATag($thisDoc, $navigation, $child3); ?>
                            </div>

                                <?php if ($child3->getChilds()): ?>
                                    <ul class="<?php echo getMenuUlClass($thisDoc, $child3, $navigation); ?>" id="<?php echo $child3->getKey(); ?>">
                                <?php foreach ($child3->getChilds() as $child4): ?>
                                <?php if ($child4->getType() == 'page' || $child4->getType() == 'link'): ?>
                                <?php if (!$child4->getProperty('navigation_exclude')): ?>
                                    <li class="mobile-nav-item">
                                    <div class="mobile-nav-container">
                                    <?php echo getMenuATag($thisDoc, $navigation, $child4); ?>
                                    </div>

                                        <!-- child 5 ... -->

                                <?php endif ?>
                                <?php endif ?>
                                <?php endforeach ?>
                                    </li>
                                    </ul>
                                <?php endif ?>

                        <?php endif ?>
                        <?php endif ?>
                        <?php endforeach ?>
                            </li>
                            </ul>
                        <?php endif ?>

                <?php endif ?>
                <?php endif ?>
                <?php endforeach ?>
                    </li>
                    </ul>
                <?php endif ?>

        <?php endif ?>
        <?php endif ?>
        <?php endforeach ?>
            </li>
            </ul>
        <?php endif ?>

<?php endif ?>
<?php endif ?>
<?php endforeach ?>
    </li>
    </ul>
<?php endif ?>
    </li>
<?php endforeach ?>
<?php endif ?>


<!-- TargetGroups Pages -->
<?php if ($targetGroupsPages): ?>
<?php foreach ($targetGroupsPages as $page): ?>
    <li class="mobile-nav-item">
        <div class="mobile-nav-container">
            <a class="nav-link" href="<?php echo $page->getHref(); ?>"><?php echo $page->getProperty('navigation_name'); ?></a>
        </div>
    </li>
<?php endforeach ?>
<?php endif ?>


<!-- Subsites Pages -->
<?php if ($subsitesPages): ?>
<?php foreach ($subsitesPages as $page): ?>
    <li class="mobile-nav-item">
        <div class="mobile-nav-container">
            <?php echo getMenuATag($thisDoc, $navigation, $page); ?>
        </div>

<?php if ($page->getChilds()): ?>
    <ul class="<?php echo getMenuUlClass($thisDoc, $page, $navigation); ?>" id="<?php echo $page->getKey(); ?>">
<?php foreach ($page->getChilds() as $child): ?>
<?php if ($child->getType() == 'page' || $child->getType() == 'link'): ?>
<?php if (!$child->getProperty('navigation_exclude')): ?>
    <li class="mobile-nav-item">
    <div class="mobile-nav-container">
    <?php echo getMenuATag($thisDoc, $navigation, $child); ?>
    </div>

        <?php if ($child->getChilds()): ?>
            <ul class="<?php echo getMenuUlClass($thisDoc, $child, $navigation); ?>" id="<?php echo $child->getKey(); ?>">
        <?php foreach ($child->getChilds() as $child1): ?>
        <?php if ($child1->getType() == 'page' || $child1->getType() == 'link'): ?>
        <?php if (!$child1->getProperty('navigation_exclude')): ?>
            <li class="mobile-nav-item">
            <div class="mobile-nav-container">
            <?php echo getMenuATag($thisDoc, $navigation, $child1); ?>
            </div>

                <?php if ($child1->getChilds()): ?>
                    <ul class="<?php echo getMenuUlClass($thisDoc, $child1, $navigation); ?>" id="<?php echo $child1->getKey(); ?>">
                <?php foreach ($child1->getChilds() as $child2): ?>
                <?php if ($child2->getType() == 'page' || $child2->getType() == 'link'): ?>
                <?php if (!$child2->getProperty('navigation_exclude')): ?>
                    <li class="mobile-nav-item">
                    <div class="mobile-nav-container">
                    <?php echo getMenuATag($thisDoc, $navigation, $child2); ?>
                    </div>

                        <?php if ($child2->getChilds()): ?>
                            <ul class="<?php echo getMenuUlClass($thisDoc, $child2, $navigation); ?>" id="<?php echo $child2->getKey(); ?>">
                        <?php foreach ($child2->getChilds() as $child3): ?>
                        <?php if ($child3->getType() == 'page' || $child3->getType() == 'link'): ?>
                        <?php if (!$child3->getProperty('navigation_exclude')): ?>
                            <li class="mobile-nav-item">
                            <div class="mobile-nav-container">
                            <?php echo getMenuATag($thisDoc, $navigation, $child3); ?>
                            </div>

                                <?php if ($child3->getChilds()): ?>
                                    <ul class="<?php echo getMenuUlClass($thisDoc, $child3, $navigation); ?>" id="<?php echo $child3->getKey(); ?>">
                                <?php foreach ($child3->getChilds() as $child4): ?>
                                <?php if ($child4->getType() == 'page' || $child4->getType() == 'link'): ?>
                                <?php if (!$child4->getProperty('navigation_exclude')): ?>
                                    <li class="mobile-nav-item">
                                    <div class="mobile-nav-container">
                                    <?php echo getMenuATag($thisDoc, $navigation, $child4); ?>
                                    </div>

                                        <!-- child 5 ... -->

                                <?php endif ?>
                                <?php endif ?>
                                <?php endforeach ?>
                                    </li>
                                    </ul>
                                <?php endif ?>

                        <?php endif ?>
                        <?php endif ?>
                        <?php endforeach ?>
                            </li>
                            </ul>
                        <?php endif ?>

                <?php endif ?>
                <?php endif ?>
                <?php endforeach ?>
                    </li>
                    </ul>
                <?php endif ?>

        <?php endif ?>
        <?php endif ?>
        <?php endforeach ?>
            </li>
            </ul>
        <?php endif ?>

<?php endif ?>
<?php endif ?>
<?php endforeach ?>
    </li>
    </ul>
<?php endif ?>
    </li>
<?php endforeach ?>
<?php endif ?>


        </ul>
    </div>
</div>
</div>