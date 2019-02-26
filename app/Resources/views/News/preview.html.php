<?php
/**
 * @var \Pimcore\Templating\PhpEngine $this
 * @var \Pimcore\Templating\PhpEngine $view
 * @var \Pimcore\Templating\GlobalVariables $app
 */

$this->extend('objectPreview.html.php');

?>
<div id="text_wrapper" class="grid-15 push-8 alpha">
    <article id="text_content_main">
        <div id="share_wrapper" class="clearfix hide-xs">
            <div id="share_buttons"> </div>
        </div>
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

</div>
