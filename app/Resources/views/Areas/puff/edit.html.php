<?php
/**
 * @var \Pimcore\Templating\PhpEngine $this
 * @var \Pimcore\Templating\PhpEngine $view
 * @var \Pimcore\Templating\GlobalVariables $app
 */
?>

<?php if ($this->document->getProperty('bootstrap')) : ?>
    <p class="info">Typ av puff</p>
    <?php echo $this->select("puff",array(
        "width" => 250,
        "store" => array(
            array("promo_txt_large", "Textpuff"),
            array("promo_img", "Bildpuff")
        )
    )); ?>
    <p class="info margins">Bakgrundsfärg</p>
    <?php echo $this->select("color",array(
        "width" => 250,
        "store" => array(
            ['nav-block-sky-50 nav-block-fade-sky-50', 'Himmel 50 %'],
            ['nav-block-copper-50 nav-block-fade-copper-50', 'Koppar 50 %'],
            ['nav-block-flower-50 nav-block-fade-flower-50', 'Blomma 50 %'],
            ['nav-block-plaster-50 nav-block-fade-plaster-50', 'Puts 50 %'],
        )
    )); ?>
<?php else : ?>
    <p class="info">Typ av puff</p>
    <?php echo $this->select("puff",array(
        "width" => 250,
        "store" => array(
            array("promo_txt_small promo_mini", "Minipuff"),
            array("promo_txt_small", "Liten textpuff"),
            array("promo_txt_large", "Stor textpuff"),
            array("promo_img", "Bildpuff"),
            array("promo_video", "Videopuff")
        )
    )); ?>
    <p class="info margins">Bakgrundsfärg</p>
    <?php echo $this->select("color",array(
        "width" => 250,
        "store" => array(
            array("bg_blue", "Blå"),
            array("bg_pink", "Rosa"),
            array("bg_green", "Grön"),
            array("bg_beige", "Beige"),
            array("bg_yellow", "Gul"),
            array("bg_white", "Vit")
        )
    )); ?>
<?php endif; ?>

<p class="info margins">Rubrik</p>
<?php echo $this->input("promo_title", array("width" => 500)); ?>

<p class="info margins">Undertext (kan uteslutas)</p>
<?php echo $this->input("promo_lead", array("width" => 500)); ?>

<p class="info margins">Intern länk inom den egna webbplatsen (drag-and-drop)</p>
<?php echo $this->href("promo_href", array("width" => 500)); ?>

<p class="info margins">Extern länk utanför den egna webbplatsen (ange fullständig URL)</p>
<?php echo $this->input("promo_link", array("width" => 500)); ?>

<p class="info margins">För bild- eller videopuff: bild från Assets (drag-and-drop)</p>
<?php echo $this->href("promo_image",array(
    "width"=>500,
    "types"=>array("asset"),
    "subtypes"=>array(
        "asset" => array("image"),
    )
)); ?>
