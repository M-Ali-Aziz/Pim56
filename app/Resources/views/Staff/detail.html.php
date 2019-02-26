<?php
/**
 * @var \Pimcore\Templating\PhpEngine $this
 * @var \Pimcore\Templating\PhpEngine $view
 * @var \Pimcore\Templating\GlobalVariables $app
 */

$this->extend('default.html.php');

?>
<?php $language = $this->document->getProperty('language');?>

<?php if ($this->document->getProperty('bootstrap')) : ?>
    <div class="row">
        <div class="col-12 col-lg-8 mb-6 mb-lg-0">
            <article>
                <h1><?php echo $this->translate('contact'); ?></h1>
                <?php
                    $helper = $this->staff($this);
                    echo $helper->StaffDetail($this->employee, array());
                ?>
            </article>
        </div>
        <div class="col-12 col-lg-4">
        </div>
    </div>
<?php else : ?>

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
        <p class="lead"> </p>
        <?php
            $helper = $this->staff($this);
            echo $helper->StaffDetail($this->employee, array());
        ?>
    </article>
</div>
<!-- Text content end -->

<!-- Sidebar start -->
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
                "rss" => array(),
                "news" => ['baseuri' => $this->website['baseuri']],
                "eventlist" => ['baseuri' => $this->website['baseuri']],
                "puff" => array(), "uid" => array()
            )));?>
    </div>
</div>
<!-- Sidebar end -->
<?php endif;  ?>
