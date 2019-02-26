<?php
/**
 * @var \Pimcore\Templating\PhpEngine $this
 * @var \Pimcore\Templating\PhpEngine $view
 * @var \Pimcore\Templating\GlobalVariables $app
 */

$this->extend('default.html.php');

?>

<?php if ($this->document->getProperty('bootstrap')) : ?>
    <?= $this->template("Bootstrap/News/detail.html.php"); ?>
<?php else: ?>

    <?php
        $baseUri = ($this->website['baseuri'] == '/') ? '' : $this->website['baseuri'];
        $uri = $baseUri . $uri;
    ?>

    <!-- Text content start -->
    <div id="text_wrapper" class="grid-15<?php echo ((!$this->getProperty('navStartNode')) || ($this->getProperty('push-8'))) ? " push-8 alpha" : ""; ?>">
        <article id="text_content_main">
            <!--eri-no-index-->
            <div id="share_wrapper" class="clearfix hide-xs">
                <div id="share_buttons"> </div>
            </div>
            <!--/eri-no-index-->
            <?php if($this->nyheter) : ?>

                <header id="page_title">
                    <h1><?php echo $this->nyheter->getRubrik() ?></h1>
                </header>

                <p class="lead">
                    <?php echo $this->translate('published'); ?>: <?php echo date("Y-m-d", $this->nyheter->getCreationDate())?>
                </p>

                <p class="lead">
                    <?php echo $this->nyheter->getIngress(); ?>
                </p>

                <?php if($this->nyheter->getImage1()): ?>
                <div>
                    <img src="<?php echo $this->nyheter->getImage1(); ?>" width="100%" />
                    <p class="image_caption"><?php echo $this->nyheter->getCaption(); ?></p>
                </div>
                <?php
                    elseif($video = $this->nyheter->getVideo()):

                        $videoTag = new \Pimcore\Model\Document\Tag\Video();
                        $videoTag->setOptions(array(
                            'thumbnail' => 'videoThumbnail',
                            'width' => 430,
                            'height' => 300,
                            "config" => array(
                            "clip" => array(
                            "autoPlay" => false,
                            "autoBuffering" => true,
                            ))
                        ));
                        $videoTag->setDataFromEditmode(array('id' => $video->data, 'type' => $video->type));
                        echo $videoTag->frontend();

                     endif; 
                ?>

                <p class="news-body">
                    <?php echo $this->nyheter->getBody(); ?>
                </p>

            <?php else : ?>
                <p><?php echo $this->translate('this news does not exist'); ?>!</p>
            <?php endif; ?>

        </article>

        <?php
        /*
        <div class="tags-wrapper-news tags-wrapper">
            <?php if(is_array($this->tags)): foreach ($this->tags as $tag): ?>
                <a class="tag tag-news label label-primary" href="<?php echo $uri; ?>/tag/<?php echo strtolower($tag->getName()); ?>"><?php echo $tag->getName(); ?></a>
            <?php endforeach; endif; ?>
        </div>
        */
        ?>

    </div>
    <!-- Text content end -->

    <?php if($this->nyheter): ?>
    <!-- Sidebar start -->
    <div id="content_sidebar_wrapper" class="<?php echo ((!$this->getProperty('navStartNode')) || ($this->getProperty('push-8'))) ? "push-8 " : ""; ?>grid-8 omega">
        <div id="content_sidebar">

                <?php if($this->nyheter->getBody2()): ?>
                <div>
                    <?php if($this->nyheter->getRubrik2()): ?>
                    <h2><?php echo $this->nyheter->getRubrik2(); ?></h2>
                    <?php endif; ?>
                    <p>
                        <?php echo $this->nyheter->getBody2(); ?>
                    </p>
                    <?php if($this->nyheter->getImage2()): ?>
                    <p>
                        <img src="<?php echo $this->nyheter->getImage2(); ?>" />
                    </p>
                    <?php endif; ?>
                </div>
                <?php endif; ?>

                <?php if($this->nyheter->getBody3()): ?>
                <div class="tab-sidebar-info <?php echo $this->nyheter->getColor(); ?>">
                    <?php if($this->nyheter->getRubrik3()): ?>
                    <h2><?php echo $this->nyheter->getRubrik3() ?></h2>
                    <?php endif; ?>
                    <p>
                        <?php echo $this->nyheter->getBody3(); ?>
                    </p>
                </div>
                <?php endif; ?>

                <?php if($this->nyheter->getSnippet()): ?>
                <div>
                    <p>
                        <? echo $this->inc($this->nyheter->getSnippet()); ?>
                    </p>
                </div>
                <?php endif; ?>
        </div>
    </div>
    <!-- Sidebar end -->
    <?php endif; ?>

<?php endif; ?>

