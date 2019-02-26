<?php
/**
 * @var \Pimcore\Templating\PhpEngine $this
 * @var \Pimcore\Templating\PhpEngine $view
 * @var \Pimcore\Templating\GlobalVariables $app
 */
?>
<!-- BEGIN subnav partial view -->
<ul id="tabs" class="no-nav">
    <?php if ($this->pages) :?>
        <?php foreach($this->pages as $page) : ?>
            <li><a href="<?php echo $page->getHref()?>" class="<?php echo (substr($_SERVER['REQUEST_URI'], 0, strlen($page->getHref())) == $page->getHref()) ? 'selected' : ''?>"><?php echo $page->getLabel()?></a></li>
        <?php endforeach;?>
    <?php endif;?>
</ul>
<!-- END subnav partial view -->
