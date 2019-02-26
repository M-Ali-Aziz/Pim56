<?php
/**
 * @var \Pimcore\Templating\PhpEngine $this
 * @var \Pimcore\Templating\PhpEngine $view
 * @var \Pimcore\Templating\GlobalVariables $app
 */
?>

<ul class="clearfix">
    <?php if ($this->pages) :?>
        <?php foreach($this->pages as $page) : ?>
            <li class="<?php echo (substr($_SERVER['REQUEST_URI'], 0, strlen($page['uri'])) == $page['uri']) ? 'selected' : ''?>">
                <a href="<?php echo $page['uri']?>"><?php echo $page['label']?></a>
            </li>
        <?php endforeach;?>
    <?php endif;?>
</ul>
