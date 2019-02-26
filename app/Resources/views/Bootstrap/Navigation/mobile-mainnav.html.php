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
?>

<?= $this->template("Bootstrap/Navigation/mobile-mainnav-item.html.php", [
    'pages' => $pages
]);?>

<div class="mobile-nav-bar font-size-sm font-size-sm-base d-xl-none">
    <nav class="nav ml-2 flex-grow-1">

        <?php if ($pages): ?>
            <?php foreach ($pages as $page): ?>
                <?php
                    $navStartNode = $page;
                    $mainNavigation = $this->navigation()->buildNavigation($this->document, $navStartNode);
                    /** @var \Pimcore\Navigation\Renderer\Menu $menuRenderer */
                    $menuRenderer = $this->navigation()->menu();

                    $activeClass = '';
                    foreach ($mainNavigation as $p) {
                        if ($p->getActive(true) || ($this->document->getId() == $page->getId())) {
                            $activeClass = 'active';
                        }
                    }

                ?>

                <div class="nav-item flex-1 <?php echo $activeClass; ?>">
                    <a
                        href="#nav-mobile--<?php echo $page->getKey(); ?>"
                        class="nav-link px-2"
                        data-toggle="modal"
                        aria-controls="nav-mobile--<?php echo $page->getKey(); ?>"
                        aria-expanded="false"
                        aria-label="Visa meny">
                        <?php echo $page->getProperty('navigation_name');?>
                    </a>
                </div>
            <?php endforeach ?>
        <?php endif ?>
    </nav>
    <nav class="nav">
        <div class="nav-item">
          <a class="nav-link" href="#nav-mobile" data-toggle="modal" aria-controls="nav-mobile" aria-expanded="false" aria-label="Visa meny"><i class="fal fa-bars"></i> <?= $this->translate("more"); ?></a>
        </div>
    </nav>
</div>