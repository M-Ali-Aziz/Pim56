<?php
/**
 * @var \Pimcore\Templating\PhpEngine $this
 * @var \Pimcore\Templating\PhpEngine $view
 * @var \Pimcore\Templating\GlobalVariables $app
 */
?>
<!-- BEGIN subnav partial view -->
<ul class="nav nav-tabs nav-undecorated" role="tablist">
    <?php if ($this->pages) :?>
        <?php foreach($this->pages as $page) : ?>
            <li class="nav-item">
                <a class="nav-link <?php if( $page->getActive(true) ){ ?>active<?php } ?>"
                    href="<?php echo $page->getHref()?>"
                    role="tab"
                    aria-selected="<?php if( $page->getActive(true) ){ ?>true<?php }else{ ?>false<?php } ?>"
                    >
                    <?php echo $page->getLabel()?>     
                </a>
            </li>
        <?php endforeach;?>
    <?php endif;?>
</ul>
<!-- END subnav partial view -->
