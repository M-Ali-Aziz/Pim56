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
    $events = \Pimcore\Model\DataObject\ClassDefinition::getByName('Events');
    $store = [["", "Alla"]];
    foreach($events->getFieldDefinitions()['Webb']->options as $o) {

        $store[] = array($o['value'], $o['key']);
    }

    echo $this->select("webbplats",array(
        "width" => 250,
        "store" => $store
    ));
?>

<p class="info margins">Filtrera på serie</p>
<?php
    $events = \Pimcore\Model\DataObject\ClassDefinition::getByName('Events');
    $store = [["", "Alla"]];
    foreach($events->getFieldDefinitions()['Serie']->options as $o) {

        $store[] = array($o['value'], $o['key']);
    }

    echo $this->select("serie",array(
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

<p class="info margins">Kort sammanfattning: antal tecken</p>
<?php echo $this->select("sammanfattning",array(
    "width" => 100,
    "store" => array(
        array("0", "Dölj"),
        array("90", "Förkortad"),
        array("255", "Hela")
    )
)); ?>

<p class="info margins">Antal händelser som skall visas</p>
<?php echo $this->select("limit",array(
    "width" => 100,
    "store" => array(
        array("3", "3"),
        array("4", "4"),
        array("5", "5"),
        array("10", "10"),
        array("20", "20"),
        array("30", "30"),
        array("50", "50"),
        array("100", "100")
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

<p class="info margins">Länk till fler händelser</p>
<?php echo $this->href("link",array(
    "width" => 450,
    "types"=>array("document"),
    "subtypes"=>array(
        "document" => array("page"),
    )
)); ?>
