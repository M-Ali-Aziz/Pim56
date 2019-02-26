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


<?php if($this->editmode) : ?>
<style>
.pimcore_area_toggle-content .pimcore_tag_input {
    font-family: "Georgia",serif;
    font-weight: 500;
    line-height: 1.2;
    font-size: 1.5rem;
}
</style>
<?php endif ; ?>
<div class="expand <?php echo $color; ?> mb-3">
    <div class="expand-content">
        <div class="expand-content-lead">
            <p class="h3 mt-0 mb-3"><?php echo $this->input("heading"); ?></p>
            <?php echo $this->wysiwyg("lead", array (
                "customConfig" => "/static/js/ckeditor.js"
            )); ?>
        </div>
        <div class="expand-content-body">
            <?php echo $this->wysiwyg("body", array (
                "customConfig" => "/static/js/ckeditor.js"
            )); ?>
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
