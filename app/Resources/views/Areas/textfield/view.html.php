<?php
/**
 * @var \Pimcore\Templating\PhpEngine $this
 * @var \Pimcore\Templating\PhpEngine $view
 * @var \Pimcore\Templating\GlobalVariables $app
 */
?>
<div class="textfield">
    <h1 class="textfield-title"><?php echo $this->input("heading");?></h1>
    <div class="textfield-text">
        <?php echo $this->textarea("text", array("nl2br" => true)); ?>
    </div>
</div>
