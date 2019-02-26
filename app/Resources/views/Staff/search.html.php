<?php
/**
 * @var \Pimcore\Templating\PhpEngine $this
 * @var \Pimcore\Templating\PhpEngine $view
 * @var \Pimcore\Templating\GlobalVariables $app
 */

$this->extend('default.html.php');

?>

<?php $language = $this->language;?>
<?php if($this->editmode) : ?>
<style>
table, table td, table th {border:none}
.pimcore_block_button_up, .pimcore_block_button_down {display:none !important;}
#pimcore_editable_rightAreablock .pimcore_area_edit_button,
#pimcore_editable_mainAreablock .pimcore_area_edit_button {z-index: 99;}
#content_sidebar table {margin-bottom:0;}
.info {font-weight:700;margin:0;}
.margins {margin:8px 0 0 0;}
.pimcore_area_entry {margin: 0px 0 16px!important;}
</style>
<?php endif; ?>
<!-- Text content start -->
<div id="text_wrapper" class="grid-15<?php echo ((!$this->getProperty('navStartNode')) || ($this->getProperty('push-8'))) ? " push-8 alpha" : ""; ?>">
    <article id="text_content_main">
        <!--eri-no-index-->
        <div id="share_wrapper" class="clearfix">
            <div id="share_buttons"> </div>
        </div>
        <!--/eri-no-index-->
        <header id="page_title">
            <h1><?php echo $this->translate('contact'); ?></h1>
        </header>
        <h2><?php echo $this->translate('search_person'); ?></h2>
        <p><?php echo $this->translate('search_lusem_staff'); ?>.</p>
        <div>
            <form action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="post" name="form" onsubmit="return validate();">
                <input id="searchpers" name="visa" type="hidden" value="2" />
                <input id="searcha" name="q" size="30" type="text" value="<?php echo $this->query;?>" />
                <input name="btnSearch" class="btn btn-primary" type="submit" value="<?php echo $this->translate('search'); ?>" />
            </form>
        </div>
        <p class="lead"> </p>

        <?php
            if($this->staffList) :
                $helper = $this->staff($this, $this->staffList);
                echo $helper->staffList(array(
                    'image' => false,
                    'room' => false,
                    'roleinfo' => false,
                    'moreinfo' => true,
                ));
        ?>
        <?php elseif($this->query) : ?>
            <p><?php echo $this->translate('no matching search results'); ?></p>
        <?php else: ?>
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
                "newsMain" => ['baseuri' => $this->website['baseuri']],
                "eventlistMain" => ['baseuri' => $this->website['baseuri']],
                "heading" => array(), "rss" => array()
        )));?>
        <?php endif;?>

    </article>
</div>
<!-- Text content end -->

<!-- Sidebar start -->
<div id="content_sidebar_wrapper" class="<?php echo ((!$this->getProperty('navStartNode')) || ($this->getProperty('push-8'))) ? "push-8 " : ""; ?>grid-8 omega">
    <div id="content_sidebar">
        <?php echo $this->areablock('rightAreablock',array(
            "toolbar"=>0,
            "allowed"=> array("wysiwyg","snippet","youtube","image","uid","heading","rss","news","eventlist","puff"),
            "params" => array(
                "wysiwyg" => array("width" => 224),
                "snippet" => array("width" => 224),
                "heading" => array("width" => 224),
                "image" => array("width" => 224),
                "youtube" => array("width" => 224, "height" => 130),
                "rss" => array(),
                "news" => ['baseuri' => $this->website['baseuri']],
                "eventlist" => ['baseuri' => $this->website['baseuri']],
                "puff" => array(), "uid" => array()
            )));?>
    </div>
</div>
<!-- Sidebar end -->
