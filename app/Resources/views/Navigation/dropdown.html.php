<?php
/**
 * @var \Pimcore\Templating\PhpEngine $this
 * @var \Pimcore\Templating\PhpEngine $view
 * @var \Pimcore\Templating\GlobalVariables $app
 */

use \Pimcore\Model\Site;
use \Pimcore\Model\Document;

?>
<?php
if(Site::isSiteRequest()) {
    $site = Site::getCurrentSite();
    $navStartNode = $site->getRootDocument();
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

$dropdownMenuHelper = $this->dropdown([
    "mainSite" => $mainSite,
    "lusemSite" => $lusemSite,
    "mainMenu" => $this->mainMenu,
    "shortcuts" => $this->targetgroups
]);

echo $dropdownMenuHelper->renderMenu($container);