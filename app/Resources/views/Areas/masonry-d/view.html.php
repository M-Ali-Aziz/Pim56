<?php
/**
 * @var \Pimcore\Templating\PhpEngine $this
 * @var \Pimcore\Templating\PhpEngine $view
 * @var \Pimcore\Templating\GlobalVariables $app
 */
?>

<?php if ($this->editmode) : ?>
<style type="text/css">
    .masonry-cols {width:100%;}
    .masonry-tile-img-bg .pimcore_tag_image {width:100%; height:100%;}
    .linktext {font-family: Georgia,serif; font-size: 2rem; padding:16px; line-height:2.4rem;}
    .linktext a {text-decoration: none;}
    .masonry-tile-img-content .linktext {background-color: #fff;}
    .pimcore_tag_link_text {display: inline-block!important; padding-right: 20px;}
    .pimcore_tag_link .x-btn-default-small {}
    .masonry-tile-img {border: dashed #4d4c44 1px;}
</style>
<?php endif ?>

<?php $store = [
    ['nav-block-sky-50 nav-block-fade-sky-50', 'Himmel 50 %'],
    ['nav-block-sky nav-block-fade-sky', 'Himmel 100 %'],
    ['nav-block-copper-50 nav-block-fade-copper-50', 'Koppar 50 %'],
    ['nav-block-copper nav-block-fade-copper', 'Koppar 100 %'],
    ['nav-block-flower-50 nav-block-fade-flower-50', 'Blomma 50 %'],
    ['nav-block-flower nav-block-fade-flower', 'Blomma 100 %'],
    ['nav-block-plaster-50 nav-block-fade-plaster-50', 'Puts 50 %'],
    ['nav-block-plaster nav-block-fade-plaster', 'Puts 100 %']
]; ?>

<div class="container mason">
    <div class="masonry-container masonry-container-2by1">
        <div class="masonry masonry-wide masonry-cols">
            <div class="masonry-col masonry-col-50">
                <div class="masonry-row masonry-row-100">
                    <div class="masonry-tile">
                        <?php if ($this->editmode) : ?>
                            <div class="masonry-tile-img">
                                <div class="masonry-tile-img-bg">
                                    <?= $this->image("image", [
                                        "hidetext" => true
                                    ]); ?>
                                </div>
                                <div class="masonry-tile-img-content">
                                    <div class="blockline">
                                        <div class="linktext"><?= $this->link("masonryTileLink"); ?></div>
                                    </div>
                                </div>
                            </div>
                        <?php else: ?>
                            <a href="<?= $this->link("masonryTileLink")->getHref(); ?>" class="nav-block masonry-tile-img">
                                <div class="masonry-tile-img-bg">
                                    <img src="<?= $this->image("image")->getSrc() ; ?>" alt="<?= $this->link("masonryTileLink")->getText(); ?>">
                                </div>
                                <div class="masonry-tile-img-content">
                                    <div class="blockline">
                                        <h1><span class="a nav-block-link"><?= $this->link("masonryTileLink")->getText(); ?>&nbsp;<i class="fal fa-chevron-circle-right fa-sm"></i></span>
                                        </h1>
                                    </div>
                                </div>
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <div class="masonry-col masonry-col-50">
                <div class="masonry-row masonry-row-35">
                    <div class="masonry-tile">
                        <?php if ($this->editmode) : ?>
                            <div class="<?= $this->select("color2")->getData(); ?>" style="border: dashed #4d4c44 1px;">
                                <div class="pl-4 pt-3">
                                    <?= $this->select("color2", [
                                        "reload" => "true",
                                        "store" => $store
                                    ]); ?>
                                </div>
                                <div class="linktext m-0 py-0 px-4"><?= $this->link("masonryTileLink4"); ?></div>
                                <div class="px-4 py-2">
                                    <?= $this->textarea("masonryTileText4", [
                                        "nl2br" => true,
                                        "height" => 80
                                    ]); ?>
                                </div>
                            </div>
                        <?php else: ?>
                            <a href="<?= $this->link("masonryTileLink4")->getHref(); ?>" class="nav-block <?= $this->select("color2")->getData(); ?>">
                                <div class="p-3 p-lg-5">
                                    <h1><span class="a nav-block-link"><?= $this->link("masonryTileLink4")->getText(); ?>&nbsp;<i class="fal fa-chevron-circle-right fa-sm"></i></span></h1>
                                    <p><?= $this->textarea("masonryTileText4", ["nl2br" => true]); ?></p>
                                </div>
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="masonry-row masonry-row-65">
                    <div class="masonry-tile">
                        <?php if ($this->editmode) : ?>
                            <div class="masonry-tile-img">
                                <div class="masonry-tile-img-bg">
                                    <?= $this->image("image2", [
                                        "hidetext" => true
                                    ]); ?>
                                </div>
                                <div class="masonry-tile-img-content">
                                    <div class="blockline">
                                        <div class="linktext"><?= $this->link("masonryTileLink2"); ?></div>
                                    </div>
                                </div>
                            </div>
                        <?php else: ?>
                            <a href="<?= $this->link("masonryTileLink2")->getHref(); ?>" class="nav-block masonry-tile-img">
                                <div class="masonry-tile-img-bg">
                                    <img src="<?= $this->image("image2")->getSrc() ; ?>" alt="<?= $this->link("masonryTileLink2")->getText(); ?>">
                                </div>
                                <div class="masonry-tile-img-content">
                                    <div class="blockline">
                                        <h1><span class="a nav-block-link"><?= $this->link("masonryTileLink2")->getText(); ?>&nbsp;<i class="fal fa-chevron-circle-right fa-sm"></i></span>
                                        </h1>
                                    </div>
                                </div>
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
