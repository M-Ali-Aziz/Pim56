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

<p class="info margins">Kort sammanfattning: antal tecken</p>
<?php echo $this->select("sammanfattning",array(
    "width" => 100,
    "store" => array(
        array("0", "Dölj"),
        array("80", "Förkortad"),
        array("255", "Hela")
    )
)); ?>

<p class="info margins">Bakgrundsfärg</p>
<?php echo $this->select("color",array(
    "width" => 100,
    "store" => array(
        array("bg_blue", "Blå"),
        array("bg_pink", "Rosa"),
        array("bg_green", "Grön"),
        array("bg_beige", "Beige")
    )
)); ?>
