<?php
/**
 * @var \Pimcore\Templating\PhpEngine $this
 * @var \Pimcore\Templating\PhpEngine $view
 * @var \Pimcore\Templating\GlobalVariables $app
 */

$this->extend('default.html.php');

?>
<?php $language = $this->document->getProperty('language');?>

<!-- Text content start -->
<div id="text_wrapper" class="grid-15<?php echo ((!$this->getProperty('navStartNode')) || ($this->getProperty('push-8'))) ? " push-8 alpha" : ""; ?>">
    <article id="text_content_main">
        <!--eri-no-index-->
        <div id="share_wrapper" class="clearfix">
            <div id="share_buttons"> </div>
        </div>
        <!--/eri-no-index-->
        <header id="page_title">
            <h1><?php echo $this->translate('faculty and expertise'); ?></h1>
            <?php if($this->researchArea) : ?>
                <h2><?php  echo $this->researchArea($this->researchArea)?></h2>
            <?php else : ?>
                <h2><?php echo $this->translate('search result'); ?></h2>
            <?php endif;?>
        </header>
        <?php if(isset($this->query)) : ?>

            <p><?php echo $this->translate('search for faculty members'); ?>.</p>
            <form action="/forskning/faculty/search" method="post" name="form" onsubmit="return validate();">
                <input checked="checked" id="searchpers" name="visa" title="Sök forskare och expertis" type="hidden" value="2" />
                <input id="searcha" name="q" size="40" title="Sök forskare och expertis" type="text" value="<?php echo $this->query?>" />
                <input name="btnSearch" type="submit" value="<?php echo $this->translate('search'); ?>" />&nbsp;
            </form>
            <p>&nbsp;</p>
        <?php endif;?>
        <p class="lead"> </p>
        <?php if($this->staffList) : ?>
            <?php $uri = ($language == 'sv') ? 'forskning/faculty/' : 'research/faculty/'?>
            <?php foreach($this->staffList as $employee) : ?>
                <div class="person">
                    <hr>
                    <div class="clearfix">
                        <h2><?php echo $employee['displayname']?></h2>
                        <p>
                            <?php
                            $values = array(
                                $employee['title'][$language],
                                $this->departmentName($employee['departmentnumber'])
                            );
                            echo $this->commaSeparatedValues($values);
                            ?>
                        </p>
                        <p>
                            <a href="mailto:<?php echo $employee['mail']?>"><?php echo $employee['mail']?></a><br>
                            <?php echo $this->translate('phone'); ?>: <?php echo $employee['phone']?><br>
                            <!--<a href="#">www.lu.se</a>-->
                        </p>
                        <p><a href="<?php echo $this->baseUri . $uri?><?php echo $employee['uid']?>"><?php echo $this->translate('show more info'); ?></a></p>
                    </div>
                </div>
            <?php endforeach;?>
        <?php else : ?>
            <p><strong><?php echo $this->translate('no matching search result'); ?>!</strong></p>
        <?php endif;?>
    </article>
</div>
<!-- Text content end -->

<!-- Sidebar start -->
<div id="content_sidebar_wrapper" class="<?php echo ((!$this->getProperty('navStartNode')) || ($this->getProperty('push-8'))) ? "push-8 " : ""; ?>grid-8 omega">
    <div id="content_sidebar">
        <?php if($this->editmode) : ?>
            <p style="margin-bottom: 20px;"><b>Innehåll</b> (224 px bred)</p>
        <?php endif; ?>
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
