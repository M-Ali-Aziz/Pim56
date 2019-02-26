<?php
/**
 * @var \Pimcore\Templating\PhpEngine $this
 * @var \Pimcore\Templating\PhpEngine $view
 * @var \Pimcore\Templating\GlobalVariables $app
 */
?>
<!--eri-no-index-->
<footer id="byline">
    <span id="byline_label"><?php echo $this->translate('published by'); ?></span>
    <span id="byline_email"> <?php echo $this->pageManager($this); ?></span>
    <time id="byline_date" datetime="<?php echo $this->pageLastUpdated($this); ?>"><?php echo $this->pageLastUpdated($this); ?></time>
</footer>
<!--/eri-no-index-->