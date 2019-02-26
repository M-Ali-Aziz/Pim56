<?php
/**
 * @var \Pimcore\Templating\PhpEngine $this
 * @var \Pimcore\Templating\PhpEngine $view
 * @var \Pimcore\Templating\GlobalVariables $app
 */
?>

<?php if($this->editmode) : ?>
<style type="text/css">
    .card-img {height:190px;}
    .card-img .pimcore_tag_image {height:100%;}
    .card-img img {width:100%; height:100%;}
</style>
<?php endif; ?>
<style type="text/css">
    .h-100 a {height:100%;}
</style>

<?php $store = [
    ['nav-block-sky-50 nav-block-fade-sky-50', 'Himmel 50 %'],
    ['nav-block-copper-50 nav-block-fade-copper-50', 'Koppar 50 %'],
    ['nav-block-flower-50 nav-block-fade-flower-50', 'Blomma 50 %'],
    ['nav-block-plaster-50 nav-block-fade-plaster-50', 'Puts 50 %'],
]; ?>

<?php if($this->editmode) : ?>
<div class="mb-3">
    <?= $this->select("color".$suffix, [
    "reload" => "true",
    "width" => 150,
    "store" => $store
    ]); ?>
    <span class="card <?= $this->select("color".$suffix)->getData(); ?>">
        <div class="card-img p-2">
            <?= $this->image("image".$suffix, [
                "hidetext" => true
            ]); ?>
        </div>
        <div class="card-body">
            <h3 class="nav-block-link m-0"><?= $this->link("link".$suffix) ; ?></h3>
            <p class="mt-3"><?= $this->input("lead".$suffix) ; ?></p>
        </div>
    </span>
</div>
<?php else : ?>
<div class="mb-3 h-100">
    <a href="<?= $this->link("link".$suffix)->getHref(); ?>" class="card nav-block <?= $this->select("color".$suffix)->getData(); ?>">
        <?php if (!$this->image("image".$suffix)->isEmpty()) : ?>
        <div class="card-img p-2">
            <div class="card-img-container">
                <img src="<?= $this->image("image".$suffix)->getSrc() ; ?>" alt="<?= $this->link("link".$suffix)->getText() ; ?>">
            </div>
        </div>
        <?php endif; ?>
        <div class="card-body">
            <h3 class="nav-block-link m-0"><?= $this->link("link".$suffix)->getText() ; ?></h3>
            <p class=" mt-3"><?= $this->input("lead".$suffix)->getData() ; ?></p>
        </div>
    </a>
</div>
<?php endif; ?>
