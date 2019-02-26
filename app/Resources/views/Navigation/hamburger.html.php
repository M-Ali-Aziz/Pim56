<?php
/**
 * @var \Pimcore\Templating\PhpEngine $this
 * @var \Pimcore\Templating\PhpEngine $view
 * @var \Pimcore\Templating\GlobalVariables $app
 */

use \Pimcore\Model\Site;
use \Pimcore\Model\Document;

?>
<div id="responsive_navigation_wrapper" class="">
    <nav id="responsive_navigation">
        <p id="responsive_menu" class="clearfix">
            <span>Meny</span>
            <a id="close_responsive_navigation"></a>
        </p>
        <?php
        if(Site::isSiteRequest()) {
            $site = Site::getCurrentSite();
            if (substr($_SERVER['REQUEST_URI'], 0, 3) == '/en') {
                $navStartNode = Document::getByPath($site->getRootPath() . '/en');
            }
            else {
                $navStartNode = $site->getRootDocument();
            }
        } else {
            $navStartNode = Document::getById(1);
        }

        $container = $this->navigation()->buildNavigation($this->document, $navStartNode);
        $subdomain = $this->website['subdomain'];
        if (($subdomain == 'ehl') || ($subdomain == 'lusem')) {
            $mainSite = true;
        }
        if ($this->document->getProperty('LU') == 1 ) $lusemSite = false;
        else $lusemSite = true;

        $hamburgerMenuHelper = $this->hamburgerMenu([
            "mainSite" => $mainSite,
            "lusemSite" => $lusemSite,
            "mainMenu" => $this->mainMenu,
            "shortcuts" => $this->targetgroups,
            "language" => $this->language
        ]);

        echo $hamburgerMenuHelper->renderMenu($container);
        ?>
    </nav>
</div>
