<?php
/**
 * @var \Pimcore\Templating\PhpEngine $this
 * @var \Pimcore\Templating\PhpEngine $view
 * @var \Pimcore\Templating\GlobalVariables $app
 */
?>

<nav id="header_nav" class="rows-4 hide-xs">
    <ul>
        <?php if ($this->pages) :?>
            <?php foreach($this->pages as $page) : ?>
                <li><a href="<?php echo $page['uri']?>"><?php echo $page['label']?></a></li>
            <?php endforeach;?>
        <?php endif;?>
    </ul>
</nav>
