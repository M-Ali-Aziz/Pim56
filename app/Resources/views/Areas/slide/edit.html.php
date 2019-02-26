<?php
/**
 * @var \Pimcore\Templating\PhpEngine $this
 * @var \Pimcore\Templating\PhpEngine $view
 * @var \Pimcore\Templating\GlobalVariables $app
 */
?>
<p class="info">Bakgrundsfärg</p>
<?php echo $this->select("color",array(
    "width" => "140",
    "store" => array(
        array("bg_blue", "Blå"),
        array("bg_pink", "Rosa"),
        array("bg_green", "Grön"),
        array("bg_beige", "Beige"),
        array("bg_yellow", "Gul"),
        array("bg_white", "Vit")
    )
)); ?>

<p class="info margins">Rubrik</p>
<?php echo $this->input("promo_title"); ?>

<p class="info margins">Undertext (ska EJ uteslutas)</p>
<?php echo $this->input("promo_lead"); ?>

<p class="info margins">Intern länk inom den egna webbplatsen (drag-and-drop)</p>
<?php echo $this->href("promo_href"); ?>

<p class="info margins">Extern länk utanför den egna webbplatsen (ange fullständig URL)</p>
<?php echo $this->input("promo_link"); ?>

<p class="info margins">Vattenstämpel:</p>
<div><?php echo $this->checkbox("sigill"); ?><span style="display: inline-block; margin-top: 3px;">Sigill</span></div>

<p class="info margins">Bild från Assets (drag-and-drop)</p>
<?php echo $this->href("promo_image",array(
    "types"=>array("asset"),
    "subtypes"=>array(
        "asset" => array("image"),
    ))
); ?>
