<?php
/**
 * @var \Pimcore\Templating\PhpEngine $this
 * @var \Pimcore\Templating\PhpEngine $view
 * @var \Pimcore\Templating\GlobalVariables $app
 */

$this->extend('default.html.php');

?>
<?php $language = $this->document->getProperty('language'); ?>
<?php if($this->editmode) : ?>
<style>
table, table td, table th {border:none}
.pimcore_block_button_up, .pimcore_block_button_down {display:none !important;}
#pimcore_editable_rightAreablock .pimcore_area_edit_button,
#pimcore_editable_mainAreablock .pimcore_area_edit_button {z-index: 999;}
.info {font-weight:700;margin:0;}
.margins {margin:8px 0 0 0;}
</style>
<?php endif; ?>
<!-- Text content start -->
<div id="text_wrapper" class="grid-23 omega">
    <article id="text_content_main" class="no-sidebar">

        <!--eri-no-index-->
        <div id="share_wrapper" class="clearfix">
            <div id="share_buttons">
            </div>
        </div>
        <!--/eri-no-index-->

        <?php echo $this->template("Includes/headline.html.php"); // Headline ?>

        <?php echo $this->areablock('mainAreablock',array(
            "toolbar"=>0,
            "allowed"=>array("wysiwyg","snippet","youtube","video","image"),
            "params" => array(
                "wysiwyg" => array("width" => 672),
                "snippet" => array("width" => 672),
                "image" => array("width" => 672),
                "youtube" => array("width" => '100%', "height" => 377),
                "video" => array("width" => '100%', "height" => 377)
            ))); ?>

        <?php echo $this->template("Includes/byline.html.php"); // Byline ?>

    </article>
</div>
<!-- Text content end -->
