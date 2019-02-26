<?php
/**
 * @var \Pimcore\Templating\PhpEngine $this
 * @var \Pimcore\Templating\PhpEngine $view
 * @var \Pimcore\Templating\GlobalVariables $app
 */
?>
<?= $this->video("video", array(
    "width" => $this->width,
    "height" => $this->height,
    "youtube" => array(
        "showinfo" => 0
    )
)); ?>
