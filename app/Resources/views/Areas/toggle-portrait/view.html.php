<?php
/**
 * @var \Pimcore\Templating\PhpEngine $this
 * @var \Pimcore\Templating\PhpEngine $view
 * @var \Pimcore\Templating\GlobalVariables $app
 */
?>

<?php
$color = $this->select("color")->getData();
if(empty($color)) $color = 'bg-sky-50';
?>


<?php if ($this->editmode) : ?>
    <style>
    .pimcore_area_toggle-portrait .pimcore_tag_textarea {
        font-family: "Georgia",serif;
        font-weight: 500;
        line-height: 1.2;
        font-size: 1.5rem;
    }
    </style>
    <div class="expand <?php echo $color; ?> mb-3">
        <div class="expand-content">
            <div class="expand-content-lead">
                <blockquote class="blockquote">
                    <p class="mb-0"><i class="fas fa-3x fa-quote-right fa-pull-left"></i><?php echo $this->textarea("blockquote"); ?></p>
                    <footer class="text-right"><?php echo $this->input("contact-info"); ?></footer>
                </blockquote>

            </div>
            <div class="expand-content-body">
                <?php if (!$this->image("image")->isEmpty()) : ?>
                <p><img src="<?php echo $this->image("image")->getSrc(); ?>" alt="" class="" style="width: 100%;height:auto;"></p>
                <?php endif; ?>
                <?php echo $this->wysiwyg("body", array ("customConfig" => "/static/js/ckeditor.js")); ?>
            </div>
        </div>
        <div class="expand-control">
            <div class="expand-closed">
                <?php echo $this->translate('full_story'); ?>&nbsp;<span class="ml-1"><i class="fal fa-chevron-down"></i></span>
            </div>
            <div class="expand-open">
                <?php echo $this->translate('hide_story'); ?>&nbsp;<span class="ml-1"><i class="fal fa-chevron-up"></i></span>
            </div>
        </div>
    </div>
<?php else : ?>
<div class="expand <?php echo $color; ?> mb-3">
    <div class="expand-content">
        <div class="expand-content-lead">
            <blockquote class="blockquote">
                <p class="mb-0"><i class="fas fa-3x fa-quote-right fa-pull-left"></i><?php echo $this->textarea("blockquote"); ?></p>
                <footer class="blockquote-footer text-right"><?php echo $this->input("contact-info"); ?></footer>
            </blockquote>

        </div>
        <div class="expand-content-body">
            <?php if (!$this->image("image")->isEmpty()) : ?>
            <p><img src="<?php echo $this->image("image")->getSrc(); ?>" alt="" class="" style="width: 100%;height:auto;"></p>
            <?php endif; ?>
            <?php echo $this->wysiwyg("body", array ("customConfig" => "/static/js/ckeditor.js")); ?>
        </div>
    </div>
    <div class="expand-control">
        <div class="expand-closed">
            <?php echo $this->translate('full_story'); ?>&nbsp;<span class="ml-1"><i class="fal fa-chevron-down"></i></span>
        </div>
        <div class="expand-open">
            <?php echo $this->translate('hide_story'); ?>&nbsp;<span class="ml-1"><i class="fal fa-chevron-up"></i></span>
        </div>
    </div>
</div>
<?php endif; ?>
