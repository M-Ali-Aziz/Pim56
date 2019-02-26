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
    $store = [["", "Alla"]];
    foreach($news->getFieldDefinitions()['Webb']->options as $o) {
        $store[] = array($o['value'], $o['key']);
    }
    echo $this->select("webbplats",array(
        "width" => 250,
        "store" => $store
    ));
?>

<p class="info margins">Bakgrundsfärg</p>
<?php echo $this->select("color",array(
    "width" => 250,
    "store" => array(
        array("", "Vit"),
        array("bg-sky-50", "Himmel 50%"),
        array("bg-flower-50", "Blomma 50%"),
        array("bg-copper-50", "Koppar 50%"),
        array("bg-plaster-50", "Puts 50 %"),
        array("bg-stone-50", "Sten 50%"),
    )
)); ?>
