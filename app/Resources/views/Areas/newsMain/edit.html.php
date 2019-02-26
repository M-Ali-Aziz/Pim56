<?php
/**
 * @var \Pimcore\Templating\PhpEngine $this
 * @var \Pimcore\Templating\PhpEngine $view
 * @var \Pimcore\Templating\GlobalVariables $app
 */
?>
<p class="info margins">Filtrera på webbplats</p>
<?php
    $news = Pimcore\Model\DataObject\ClassDefinition::getByName('News');
    $store = array();
    foreach($news->getFieldDefinitions()['Webb']->options as $o) {

        $store[] = array($o['value'], $o['key']);
    }

echo $this->select("webbplats",array(
    "width" => 250,
    "store" => $store
));
?>

<p class="info margins">Antal nyheter som ska visas</p>
<?php echo $this->select("limit",array(
    "width" => 100,
    "store" => array(
        array("3", "3"),
        array("4", "4"),
        array("5", "5"),
        array("8", "8"),
        array("10", "10"),
        array("15", "15"),
        array("20", "20"),
        array("25", "25")
    )
)); ?>
<div style="margin:10px 0 5px 0;">
    <div><?php echo $this->checkbox("paging"); ?><span style="display: inline-block; margin-top: 3px;">Paging/nyhetsarkiv: alla nyheter visas ut med paginering.</span></div>
</div>
