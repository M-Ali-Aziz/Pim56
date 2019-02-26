<?php
/**
 * @var \Pimcore\Templating\PhpEngine $this
 * @var \Pimcore\Templating\PhpEngine $view
 * @var \Pimcore\Templating\GlobalVariables $app
 */

$this->extend('default.html.php');

?>
<?php $language = $this->language; ?>
<?php if($this->editmode) :
    $promo = 'width:704px;';
    if ($this->document->getProperty('DropdownMenu') == 1 AND (!$this->document->getProperty('LeftNav') == 1)) {
        $promo = 'width:656px;height:368px;';
    }
?>
<style>
table, table td, table th {border:none}
.pimcore_block_button_up, .pimcore_block_button_down {display:none!important;}
#pimcore_editable_rightAreablock .pimcore_area_edit_button,
#pimcore_editable_mainAreablock .pimcore_area_edit_button {z-index: 99;}
.pimcore_block_entry {clear:none;float:left;position:relative;}
div[type=slide] {display:block;width:704px;}
.info {font-weight:700;margin:0;}
.margins {margin:8px 0 0 0;}
.top-promo-overlay,
.top-promo img {<?php echo $promo; ?>}
</style>
<?php endif; ?>

<!-- Text content start -->
<?php echo ($this->document->getProperty('DropdownMenu') == 1 AND (!$this->document->getProperty('LeftNav') == 1)) ? "<div id='tab_content_wrapper' class='grid-22 no-nav'>" : "<div id='text_wrapper' class='grid-23 omega'>"; ?>
    <div id="<?php echo ($this->document->getProperty('DropdownMenu') == 1 AND (!$this->document->getProperty('LeftNav') == 1)) ? "tab_landing_page" : "landing_page"; ?>">
        <?php echo $this->areablock('mainAreablock', array(
            "toolbar"=> 0,
            "allowed"=> array("puffblock","slideshow","snippet","newsVertical"),
            "params" => array(
                "slideshow" => array("width" => '100%', "height" => 368),
                "snippet" => array("width" => '100%'),
                "puffblock" => array("class" => ' ', "nbm" => ' nbm'),
                "newsVertical" => [
                    'baseuri' => $this->website['baseuri'],
                    "grid" => 'grid-6'
                ]
            )));?>
    </div>
</div>
<!-- Text content end -->

<?php if ($this->document->getProperty('DropdownMenu') == 1 ) : ?>
    <!-- Sidebar start -->
    <div id="content_sidebar_wrapper" class="grid-8 omega">
        <div id="content_sidebar">
            <?php if($this->editmode) : ?>
                <p style="margin-bottom: 20px;"><b>Innehåll</b> (240 px bred)</p>
            <?php endif; ?>
            <?php echo $this->areablock('rightAreablock',array(
                "toolbar"=>0,
                "allowed"=> array("wysiwyg","blockquote","classprofile","application","snippet","youtube","video","image","uid","heading","rss","news","eventlist","puff"),
                "params" => array(
                    "wysiwyg" => array("width" => '100%'),
                    "blockquote" => array("width" => '100%'),
                    "snippet" => array("width" => '100%'),
                    "heading" => array("width" => '100%'),
                    "image" => array("width" => '100%'),
                    "youtube" => array("width" => '100%', "height" => 134),
                    "video" => array("width" => '100%', "height" => 134),
                    "classprofile" => array(),
                    "application" => array(),
                    "uid" => array(),
                    "rss" => array(),
                    "news" => ['baseuri' => $this->website['baseuri']],
                    "eventlist" => ['baseuri' => $this->website['baseuri']],
                    "puff" => array()
                ))); ?>
        </div>
    </div>
    <!-- Sidebar end -->
<?php endif; ?>
