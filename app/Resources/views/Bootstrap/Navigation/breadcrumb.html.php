<?php
/**
 * @var \Pimcore\Templating\PhpEngine $this
 * @var \Pimcore\Templating\PhpEngine $view
 * @var \Pimcore\Templating\GlobalVariables $app
 */
?>
<?php

$doc = $this->document;
$arrayBreadcrumb = [];

if(is_object($this->breadcrumbs))
{
    if ($this->breadcrumbs->getClassName() === 'LucatOrganisation') {
        $arrayBreadcrumb[] = '<li class="breadcrumb-item active" aria-current="page">'.$this->breadcrumbs->getName().'</li>';
    } elseif($this->breadcrumbs->getClassName() === 'LucatPerson') {
        $arrayBreadcrumb[] = '<li class="breadcrumb-item active" aria-current="page">'.$this->breadcrumbs->getDisplayName().'</li>';
    } else {
        $arrayBreadcrumb[] = '<li class="breadcrumb-item active" aria-current="page">'.$this->breadcrumbs->getRubrik().'</li>';
    }

}

$i = 0;
while ($doc !== null) {
    $i++;
    if($doc->getId() !== 1 && $doc instanceof \Pimcore\Model\Document\Page) {
        if($i == 1 && ! is_object($this->breadcrumbs)) {
            $arrayBreadcrumb[] = '<li class="breadcrumb-item active" aria-current="page">'.$doc->getProperty("navigation_name").'</li>';
        }else{
            $arrayBreadcrumb[] = '<li class="breadcrumb-item"><a href="'.$doc->getFullPath().'">'.$doc->getProperty("navigation_name").'</a></li>';
        }
    } elseif ($doc->getId() !== 1 && $doc instanceof \Pimcore\Model\Document\Link) {
        if($i == 1 && ! is_object($this->breadcrumbs)) {
            $arrayBreadcrumb[] = '<li class="breadcrumb-item active" aria-current="page">'.$doc->getProperty("navigation_name").'</li>';
        }else{
            $arrayBreadcrumb[] = '<li class="breadcrumb-item"><a href="'.$doc->getHref().'">'.$doc->getProperty("navigation_name").'</a></li>';
        }
    }
    $doc = $doc->getParent();
}

$arrayBreadcrumb = array_reverse($arrayBreadcrumb);
$arrayBreadcrumb[0] = '<li class="breadcrumb-item"><a href="/">Start</a></li>';
echo join($arrayBreadcrumb);
