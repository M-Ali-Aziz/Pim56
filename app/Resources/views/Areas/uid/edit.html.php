<?php
/**
 * @var \Pimcore\Templating\PhpEngine $this
 * @var \Pimcore\Templating\PhpEngine $view
 * @var \Pimcore\Templating\GlobalVariables $app
 */
?>
<p class="info">Ange Lucat-ID:</p>
<?php echo $this->input( "uid", array("width" => 255)); ?>

<div style="margin:5px 0 5px 0;">
    <div><?php echo $this->checkbox("displayImage"); ?><span style="display: inline-block; margin-top: 3px;">Visa bild</span></div>
</div>

<div style="margin:5px 0 5px 0;">
    <div><?php echo $this->checkbox("displayHeading"); ?><span style="display: inline-block; margin-top: 3px;">Visa rubriken "Kontakt/Contact"</span></div>
</div>
