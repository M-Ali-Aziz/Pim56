<?php
/**
 * @var \Pimcore\Templating\PhpEngine $this
 * @var \Pimcore\Templating\PhpEngine $view
 * @var \Pimcore\Templating\GlobalVariables $app
 */
?>

<p class="info margins">Filtrera på webbplats</p>
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
<?php
    $events = Pimcore\Model\Object\ClassDefinition::getByName('Events');
    $store = [["", "Alla"]];
    foreach($events->getFieldDefinitions()['Category']->options as $o) {
        $store[] = array($o['value'], $o['key']);
    }
    echo $this->select("kategori",array(
        "width" => 250,
        "store" => $store
    ));
?>

<p class="info margins">Filtrera på serie</p>
<?php
    $events = Pimcore\Model\Object\ClassDefinition::getByName('Events');
    $store = [["", "Alla"]];
    foreach($events->getFieldDefinitions()['Serie']->options as $o) {
        $store[] = array($o['value'], $o['key']);
    }
    echo $this->select("serie",array(
        "width" => 250,
        "store" => $store
    ));
?>

<p class="info margins">Bakgrundsfärg från grafiska profilen</p>
<?php echo $this->select("color",array(
    "width" => 250,
    "store" => array(
        array("", "Vit"),
        array("bg-bronze", "Lejonbrons"),
        array("bg-blue", "Kungsblå"),
        array("bg-dark", "Mörkgrå"),
        array("bg-sky-50", "Himmel 50%"),
        array("bg-sky-25", "Himmel 25%"),
        array("bg-flower-50", "Blomma 50%"),
        array("bg-flower-25", "Blomma 25%"),
        array("bg-copper-50", "Koppar 50%"),
        array("bg-copper-25", "Koppar 25%"),
        array("bg-plaster-50", "Puts 50 %"),
        array("bg-plaster-25", "Puts 25 %"),
        array("bg-stone-50", "Sten 50%"),
        array("bg-stone-25", "Sten 25%")
    )
)); ?>

<p class="info margins">Antal händelser som ska visas</p>
<?php echo $this->select("limit",array(
    "width" => 250,
    "store" => array(
        array("2", "2"),
        array("4", "4"),
        array("6", "6"),
        array("8", "8")
    )
)); ?>
