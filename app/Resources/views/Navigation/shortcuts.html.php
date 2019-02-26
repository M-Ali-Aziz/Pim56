<?php
/**
 * @var \Pimcore\Templating\PhpEngine $this
 * @var \Pimcore\Templating\PhpEngine $view
 * @var \Pimcore\Templating\GlobalVariables $app
 */
?>
<!-- Shortcuts start -->
<div id="shortcuts">
    <span><?php echo ($this->language == 'sv') ? "Genvägar" : "Shortcuts"; ?></span>
    <span id="shortcuts_icon"></span>
    <div id="shortcuts_wrapper">
        <ul>
            <?php if ($this->pages) :?>
                <?php foreach($this->pages as $page) : ?>
                    <li><a href="<?php echo $page->getHref()?>"><?php echo $page->getLabel()?></a></li>
                <?php endforeach;?>
            <?php endif;?>
        </ul>
    </div>
</div>
<!-- Shortcuts end -->
