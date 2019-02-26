<?php
/**
 * @var \Pimcore\Templating\PhpEngine $this
 * @var \Pimcore\Templating\PhpEngine $view
 * @var \Pimcore\Templating\GlobalVariables $app
 */
?>
<p class="info">Filtrera på webbplats</p>
<?php
    $events = Pimcore\Model\DataObject\ClassDefinition::getByName('Events');
    $store = [["", "Alla"]];
    foreach($events->getFieldDefinitions()['Webb']->options as $o) {

        $store[] = array($o['value'], $o['key']);
    }

    echo $this->select("webbplats",array(
        "width" => 250,
        "store" => $store
    ));
?>
<p class="info margins">Filtrera på kategori</p>
<?php echo $this->select("kategori",array(
    "width" => 250,
    "store" => array(
        array("", "Alla"),
        array("Disputation", "Disputation"),
        array("Föreläsning", "Föreläsning"),
        array("Gästföreläsning", "Gästföreläsning"),
        array("Konferens", "Konferens"),
        array("Kurs", "Kurs"),
        array("Mässa", "Mässa"),
        array("RP-seminarium", "RP-seminarium"),
        array("Seminarium", "Seminarium"),
        array("Slutseminarium", "Slutseminarium"),
        array("Workshop", "Workshop"),
        array("Övrigt", "Övrigt")
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
