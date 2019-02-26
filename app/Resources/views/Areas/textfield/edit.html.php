<?php
/**
 * @var \Pimcore\Templating\PhpEngine $this
 * @var \Pimcore\Templating\PhpEngine $view
 * @var \Pimcore\Templating\GlobalVariables $app
 */
?>
<p class="info">Rubrik</p>
<?php echo $this->input("heading"); ?>

<p class="info margins">Text</p>
<?php echo $this->textarea("text", array("height" => 100)); ?>
