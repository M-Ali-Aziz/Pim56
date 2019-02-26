<?php
/**
 * @var \Pimcore\Templating\PhpEngine $this
 * @var \Pimcore\Templating\PhpEngine $view
 * @var \Pimcore\Templating\GlobalVariables $app
 */
?>

<?php
$id = "carousel-" . uniqid();
$slides = 2;
?>

<?php if ($this->editmode) : ?>
    <style>
    .pimcore_tag_image img {width:100%; height:100%;}
    .pimcore_tag_image_empty {height:100%;}
    .linktext {font-family: Georgia,serif; font-size: 2rem; padding:16px; line-height:2.4rem;}
    .linktext a {text-decoration: none;}
    .masonry-tile-img-content .linktext {background-color: #fff;}
    .pimcore_tag_link_text {display: inline-block!important; padding-right: 20px;}
    .masonry-tile-img {border: dashed #4d4c44 1px; height: 420px;}
    </style>
<?php endif; ?>

<?php if(!$this->block("carousel-item")->isEmpty()) {
    $slides = $this->block("carousel-item")->getCount();
} ?>

<?php if (!$this->editmode) : ?>
<div class="container-fluid mx-0 px-0 nav-undecorated">
    <div id="<?php echo $id ?>" class="carousel slide" data-ride="carousel" data-pause="false">
        <ol class="carousel-indicators">
            <?php for($i=0; $i<$slides; $i++) { ?>
                <li data-target="#<?php echo $id ?>" data-slide-to="<?php echo $i ?>" class="<?php echo ($i==0 ? "active" : "") ?>">
                    <span class="sr-only"><?php echo $this->input("text" . $i) ?></span>
                </li>
            <?php } ?>
        </ol>
        <div class="carousel-controls-container">
          <div class="carousel-controls">
            <div class="carousel-controls-play"></div>
            <div class="carousel-controls-pause"></div>
          </div>
        </div>
        <div class="carousel-inner">
<?php endif; ?>
    <?php while($this->block("carousel-item")->loop()) { ?>
        <?php if ($this->editmode) : ?>
            <div class="masonry-tile-img mb-2">
                <div class="masonry-tile-img-bg">
                    <?= $this->image("image", [
                        "hidetext" => 1,
                        "uploadPath" => "/images/ehl/carousel/"
                    ]); ?>
                </div>
                <div class="masonry-tile-img-content">
                    <div class="blockline">
                        <div class="linktext"><?= $this->link("link"); ?></div>
                    </div>
                </div>
            </div>
        <?php else: ?>
            <div class="carousel-item <?php echo $this->subsiteClass; ?> <?php echo ($this->block("carousel-item")->getCurrent()==0 ? "active" : "") ?>">
                <a href="<?= $this->link("link")->getHref(); ?>" class="nav-block h-100">
                    <div class="carousel-img-container">
                        <img src="<?= $this->image("image")->getSrc() ; ?>" alt="<?= $this->link("link")->getText(); ?>" class=" carousel-img">
                    </div>
                    <div class="carousel-caption <?php echo $this->subsiteCaption; ?>">
                        <div class="container">
                            <p><span class="a nav-block-link"><?= $this->link("link")->getText(); ?>&nbsp;<i class="fal fa-chevron-circle-right fa-sm"></i></span></p>
                        </div>
                    </div>
                </a>
            </div>
        <?php endif; ?>
    <?php } ?>
<?php if (!$this->editmode) : ?>
        </div>
        <a class="carousel-control-prev" href="#<?php echo $id ?>" role="button" data-slide="prev">
          <span class="carousel-control-prev-icon" aria-hidden="true"></span>
          <span class="sr-only">Föregående</span>
        </a>
        <a class="carousel-control-next" href="#<?php echo $id ?>" role="button" data-slide="next">
          <span class="carousel-control-next-icon" aria-hidden="true"></span>
          <span class="sr-only">Nästa</span>
        </a>
    </div>
</div>
<?php endif; ?>
