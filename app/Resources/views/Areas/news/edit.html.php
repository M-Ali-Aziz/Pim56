<?php
/**
 * @var \Pimcore\Templating\PhpEngine $this
 * @var \Pimcore\Templating\PhpEngine $view
 * @var \Pimcore\Templating\GlobalVariables $app
 */
?>
<p class="info">Rubrik</p>
<?php echo $this->input( "heading", array("width" => 255) ); ?>

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

<p class="info margins">Kort sammanfattning: antal tecken</p>
<?php echo $this->select("sammanfattning",array(
    "width" => 100,
    "store" => array(
        array("0", "Dölj"),
        array("90", "Förkortad"),
        array("255", "Hela")
    )
)); ?>

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
        array("25", "25"),
        array("201", "201")
    )
)); ?>

<?php if ($this->document->getProperty('version') == 0) : ?>
<p class="info margins">Bakgrundsfärg</p>
<?php echo $this->select("color",array(
    "width" => 100,
    "store" => array(
        array("bg_blue", "Blå"),
        array("bg_pink", "Rosa"),
        array("bg_green", "Grön"),
        array("bg_beige", "Beige"),
        array("bg_white", "Vit")
    )
)); ?>
<?php endif; ?>

<p class="info margins">Länk till fler nyheter</p>
<?php echo $this->href("link",array(
    "width" => 450,
    "types"=>array("document"),
    "subtypes"=>array(
        "document" => array("page"),
    )
)); ?>
