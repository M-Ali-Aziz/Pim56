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
#pimcore_editable_mainAreablock .pimcore_area_edit_button {z-index: 99;}
.info {font-weight:700;margin:0;}
.margins {margin:8px 0 0 0;}
</style>
<?php endif; ?>

<!-- Text content start -->
<div id="tab_content_wrapper" class="grid-22 no-nav">
    <div class="tab-content">
        <?php if ($this->document->getProperty('tabPageTitle') == 1) : ?>
            <?php if($this->editmode) : ?>
                <?php echo "<h2>" . $this->input("title") . "</h2>"; ?>
                <?php echo "<p class='lead'>" . $this->textarea("lead") . "</p>"; ?>
            <?php else : ?>
                <?php echo (!$this->input("title")->isEmpty()) ? "<h2>" . $this->input("title") . "</h2>" : "" ; ?>
                <?php echo (!$this->textarea("lead")->isEmpty()) ? "<p class='lead'>" . $this->textarea("lead") . "</p>" : "" ; ?>
            <?php endif; ?>
        <?php else : ?>
        <?php echo $this->template("Includes/headline.html.php"); // Headline ?>
        <?php endif; ?>
        <?php echo $this->areablock('mainAreablock',array(
            "toolbar"=>0,
            "allowed"=>array("wysiwyg","accordion","blockquote","snippet","youtube","video","rss","news","newsMain","eventlistMain","image","heading"),
            "params" => array(
                "wysiwyg" => array("width" => '100%'),
                "accordion" => array("width" => '100%'),
                "blockquote" => array("width" => '100%'),
                "snippet" => array("width" => '100%'),
                "image" => array("width" => '656'),
                "youtube" => array("width" => '100%', "height" => 368),
                "video" => array("width" => '100%', "height" => 368),
                "rss" => array(),
                "news" => ['baseuri' => $this->website['baseuri']],
                "newsMain" => ['baseuri' => $this->website['baseuri']],
                "eventlistMain" => ['baseuri' => $this->website['baseuri']],
                "heading" => array()
            )));?>
    </div>
</div>
<!-- Text content end -->

<!-- Sidebar start -->
<div id="content_sidebar_wrapper" class="grid-8 omega">
    <div id="content_sidebar">
        <?php echo $this->areablock('rightAreablock',array(
            "toolbar"=>0,
            "allowed"=> array("wysiwyg","blockquote","classprofile","application","snippet","youtube","video","image","uid","heading","rss","news","eventlist","puff"),
            "params" => array(
                "wysiwyg" => array("width" => '100%'),
                "blockquote" => array("width" => '100%'),
                "snippet" => array("width" => '100%'),
                "heading" => array("width" => '100%'),
                "image" => array("width" => '240'),
                "youtube" => array("width" => '100%', "height" => 134),
                "video" => array("width" => '100%', "height" => 134),
                "classprofile" => array(),
                "application" => array(),
                "uid" => array(),
                "rss" => array(),
                "news" => ['baseuri' => $this->website['baseuri']],
                "eventlist" => ['baseuri' => $this->website['baseuri']],
                "puff" => array()
        )));?>
    </div>
</div>
<!-- Sidebar end -->
