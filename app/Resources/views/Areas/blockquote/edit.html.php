<?php
/**
 * @var \Pimcore\Templating\PhpEngine $this
 * @var \Pimcore\Templating\PhpEngine $view
 * @var \Pimcore\Templating\GlobalVariables $app
 */
?>
<p class="info">Citat</p>
<?php echo $this->textarea("blockquote", array("height" => 90)); ?>

<p class="info margins">Namn på citerad person, titel etc</p>
<?php echo $this->input("quoted"); ?>
