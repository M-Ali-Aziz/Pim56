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
table, table td, table th {border:none}
.pimcore_block_button_up .pimcore_block_button_down, .pimcore_open_link_button {display:none !important;}
.pimcore_open_link_button {display:none !important;}
#pimcore_editable_rightAreablock .pimcore_area_edit_button,
#pimcore_editable_mainAreablock .pimcore_area_edit_button {z-index: 99;}
div[type=slide] {display:block; width: 736px;}
.info {font-weight:700;margin:0;}
.margins {margin:8px 0 0 0;}
</style>
<?php endif; ?>

<?php if ($this->document->getProperty('bootstrap')) : ?>
    <?= $this->template("Bootstrap/Content/start.html.php"); ?>
<?php else: ?>

<style>
.pimcore_block_entry {clear: none; float: left; position: relative;}
</style>

<div class="start-grid-23 alpha">
    <?php echo $this->areablock('mainAreablock', array(
        "toolbar"=> 0,
        "allowed"=> array("puffblock","slideshow","textfield","eventlistVertical","newsVertical"),
        "params" => array(
            "slideshow" => array("width" => 736, "height" => 368),
            "puffblock" => array("class" => 'promo_wrapper '),
            "newsVertical" => [
                'baseuri' => $this->website['baseuri'],
                "grid" => 'start-grid-7'
            ],
            "eventlistVertical" => ['baseuri' => $this->website['baseuri']],
            "textfield" => array()
        ))); ?>
    <?php echo $this->areablock('mainAreablock2', array(
        "toolbar"=> 0,
        "allowed"=> array("eventlistVertical","newsVertical"),
        "params" => array(
            "newsVertical" => [
                'baseuri' => $this->website['baseuri'],
                "grid" => 'start-grid-7'
            ],
            "eventlistVertical" => ['baseuri' => $this->website['baseuri']],
        ))); ?>
</div>
<div class="start-grid-8 omega">
    <?php echo $this->areablock('rightAreablock',array(
        "toolbar"=>0,
        "allowed"=> array("wysiwyg","snippet","youtube","video","rss","news","eventlist","puff"),
        "params" => array(
            "wysiwyg" => array("width" => 224),
            "snippet" => array("width" => 224),
            "youtube" => array("width" => '100%', "height" => 126),
            "video" => array("width" => '100%', "height" => 126),
            "rss" => array(),
            "news" => ['baseuri' => $this->website['baseuri']],
            "eventlist" => ['baseuri' => $this->website['baseuri']],
            "puff" => array()
        ))); ?>
</div>
<?php endif; ?>
