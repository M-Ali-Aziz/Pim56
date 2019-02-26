<?php
/**
 * @var \Pimcore\Templating\PhpEngine $this
 * @var \Pimcore\Templating\PhpEngine $view
 * @var \Pimcore\Templating\GlobalVariables $app
 */
?>

<div class="border-top border-dark mt-5 py-3">
    <?php echo $this->translate('last_published'); ?>: <?php echo $this->pageLastUpdated($this); ?>
</div>
