<?php
/**
 * @var \Pimcore\Templating\PhpEngine $this
 * @var \Pimcore\Templating\PhpEngine $view
 * @var \Pimcore\Templating\GlobalVariables $app
 */
?>
<div class="top-promo">
    <img src="<?php echo $this->image_src; ?>">
    <div class="<?php echo $this->class; ?>">
        <a href="<?php echo $this->target_href; ?>">
            <div class="text-wrapper <?php echo $this->color; ?>">
                <h1><?php echo $this->title; ?></h1>
                <p class="lead"><?php echo $this->lead; ?></p>
                <span class="top-promo-icon"></span>
            </div>
        </a>
    </div>
</div>
