<?php
/**
 * @var \Pimcore\Templating\PhpEngine $this
 * @var \Pimcore\Templating\PhpEngine $view
 * @var \Pimcore\Templating\GlobalVariables $app
 */
?>
<p class="info">Rubrik på videoklippet (valfritt):</p>
<?php echo $this->input("heading"); ?>

<p class="info margins">YouTube videoklipp-ID (ex. MQQWNkJNEI8):</p>
<?php echo $this->input("id"); ?>
