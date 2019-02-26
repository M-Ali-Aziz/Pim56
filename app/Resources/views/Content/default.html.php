<?php
/**
 * @var \Pimcore\Templating\PhpEngine $this
 * @var \Pimcore\Templating\PhpEngine $view
 * @var \Pimcore\Templating\GlobalVariables $app
 */

$this->extend('default.html.php');
?>

<?php $language = $this->language; ?>
<?php if($this->editmode) : ?>
<style>
    table, table td, table th {border:none;}
    .pimcore_block_button_up, .pimcore_block_button_down {display:none !important;}
    #pimcore_editable_rightAreablock .pimcore_area_edit_button,
    #pimcore_editable_mainAreablock .pimcore_area_edit_button {z-index: 9999;}
    #content_sidebar table {margin-bottom:0;}
    /*.pimcore_tag_input, .pimcore_tag_textarea {padding:5px 10px 0 10px;}*/
    .x-window .pimcore_tag_input {border: 1px solid #dedbd9;}
    .info {font-weight:700;margin:0;}
    .margins {margin:8px 0 0 0;}
    .embed-responsive {z-index:1;}
    .pimcore_area_entry {margin: 0px 0 16px!important;}
</style>
<?php endif; ?>

<?php if ($this->document->getProperty('bootstrap')) : ?>
    <?= $this->template("Bootstrap/Content/default.html.php"); ?>
<?php else: ?>

<div id="text_wrapper" class="grid-15<?php echo ((!$this->getProperty('navStartNode')) || ($this->getProperty('push-8'))) ? " push-8 alpha" : ""; ?>">
    <article id="text_content_main">
        <div id="share_wrapper" class="clearfix hide-xs">
            <div id="share_buttons"> </div>
        </div>
        <?php echo $this->template("Includes/headline.html.php"); ?>
        <?php echo $this->areablock('mainAreablock',array(
            "toolbar"=>0,
            "allowed"=>array("wysiwyg","snippet","youtube","video","rss","news","newsMain","eventlistMain","image","heading"),
            "params" => array(
                "wysiwyg" => array("width" => '432'),
                "snippet" => array("width" => '432'),
                "image" => array("width" => '432'),
                "youtube" => array("width" => '100%', "height" => 242),
                "video" => array("width" => '100%', "height" => 242),
                "news" => ['baseuri' => $this->website['baseuri']],
                "newsMain" => ['baseuri' => $this->website['baseuri']], /*ta bort*/
                "eventlistMain" => ['baseuri' => $this->website['baseuri']],
                "heading" => array(),
                "rss" => array()
            )));?>
        <?php echo $this->template("Includes/byline.html.php"); ?>
    </article>
</div>
<div id="content_sidebar_wrapper" class="<?php echo ((!$this->getProperty('navStartNode')) || ($this->getProperty('push-8'))) ? "push-8 " : ""; ?>grid-8 omega">
    <div id="content_sidebar">
        <?php echo $this->areablock('rightAreablock',array(
            "toolbar"=>0,
            "allowed"=> array("wysiwyg","snippet","youtube","video","image","uid","heading","rss","news","eventlist","puff"),
            "params" => array(
                "wysiwyg" => array("width" => 224),
                "snippet" => array("width" => 224),
                "heading" => array("width" => 224),
                "image" => array("width" => 224),
                "youtube" => array("width" => '100%', "height" => 126),
                "video" => array("width" => '100%', "height" => 126),
                "uid" => array(),
                "puff" => array(),
                "news" => ['baseuri' => $this->website['baseuri']],
                "eventlist" => ['baseuri' => $this->website['baseuri']],
                "rss" => array()
            )));?>
    </div>
</div>
<?php endif; ?>
