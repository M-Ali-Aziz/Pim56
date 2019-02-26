<?php
/**
 * @var \Pimcore\Templating\PhpEngine $this
 * @var \Pimcore\Templating\PhpEngine $view
 * @var \Pimcore\Templating\GlobalVariables $app
 */
?>
<?php
$html = '';
$doc = $this->document;
$arrayBreadcrumb = array();

if(is_object($this->breadcrumbs))
{
    if ($this->breadcrumbs->getClassName() === 'LucatOrganisation') {
        $arrayBreadcrumb[] = '<li>'.$this->breadcrumbs->getName().'</li>';
    } elseif($this->breadcrumbs->getClassName() === 'LucatPerson') {
        $arrayBreadcrumb[] = '<li>'.$this->breadcrumbs->getDisplayName().'</li>';
    } else {
    $arrayBreadcrumb[] = '<li>'.$this->breadcrumbs->getRubrik().'</li>';
    }
}

$i = 0;
while ($doc != null) {
    $i++;
    if($doc->getId() != 1 && $doc instanceof \Pimcore\Model\Document\Page) {
        if($i == 1 && ! is_object($this->breadcrumbs)) {
            $arrayBreadcrumb[] = '<li>'.$doc->getProperty("navigation_name").'</li>';
        }else{
            $arrayBreadcrumb[] = '<li><a href="'.$doc->getFullPath().'">'.$doc->getProperty("navigation_name").'</a>&nbsp;&rsaquo;&nbsp;</li>';
        }
    }
    $doc = $doc->getParent();
}

$arrayBreadcrumb = array_reverse($arrayBreadcrumb);
$arrayBreadcrumb[0] = '<li><a href="/">Start</a>&nbsp;&rsaquo;&nbsp;</li>';
echo join($arrayBreadcrumb);

