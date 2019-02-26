<?php
/**
 * @var \Pimcore\Templating\PhpEngine $this
 * @var \Pimcore\Templating\PhpEngine $view
 * @var \Pimcore\Templating\GlobalVariables $app
 */
?>

<?php if ($this->editmode) : ?>
<div style="border: solid orange 1px; margin-bottom: 10px;">
    <div style="margin: 5px;"><?= $this->image("heroImage", ["width" => 540]); ?></div>
    <div style="margin: 5px;"><?= $this->input("heroTitle", ["width" => 540]); ?></div>
    <div style="margin: 5px;"><?= $this->input("heroSubTitle", ["width" => 540]); ?></div>
</div>
<?php else: ?>

<div class="hero hero-img">
    <?php if (!$this->image("heroImage")->isEmpty()) { ?>
    <div class="img-bg">
        <img src="<?= $this->image("heroImage")->getSrc(); ?>" alt="<?= $this->image("heroImage")->getAlt(); ?>">
    </div>
    <?php } ?>
    <?php if (!$this->input("heroTitle")->isEmpty()) { ?>
    <div class="hero-title">
        <h1><?= $this->input("heroTitle")->getData(); ?></h1>
        <?php if (!$this->input("heroSubTitle")->isEmpty()) { ?>
        <P><?= $this->input("heroSubTitle")->getData(); ?></P>
        <?php  } ?>
    </div>
    <?php  } ?>
</div>
<?php endif; ?>