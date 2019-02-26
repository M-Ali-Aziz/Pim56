<?php
/**
 * @var \Pimcore\Templating\PhpEngine $this
 * @var \Pimcore\Templating\PhpEngine $view
 * @var \Pimcore\Templating\GlobalVariables $app
 */
?>

<div class="bg-stone-25 py-9">
    <div class="container">
        <div class="row my-8">
        <?php if ($this->editmode): ?>
            <div class="col-12 text-center">
                <h1><?= $this->input("heading"); ?></h1>
                <p><?= $this->textarea("beskrivning"); ?></p>
                <div class="mt-5">
                    <div class="btn btn-outline-dark mx-1 mb-3">
                        <?= $this->link("button1"); ?>
                    </div>
                    <div class="btn btn-outline-dark mx-1 mb-3">
                        <?= $this->link("button2"); ?>
                    </div>
                    <div class="btn btn-outline-dark mx-1 mb-3">
                        <?= $this->link("button3"); ?>
                    </div>
                </div>
            </div>
        <?php else: ?>
            <div class="col-12 text-center">
                <?php if (!$this->input("heading")->isEmpty()) : ?>
                    <h1><?= $this->input("heading")->getData(); ?></h1>
                <?php endif; ?>
                <?php if (!$this->textarea("beskrivning")->isEmpty()) : ?>
                    <p><?= $this->textarea("beskrivning")->getData(); ?></p>
                <?php endif; ?>
                <div class="mt-5">
                <?php if (!$this->link("button1")->isEmpty()) : ?>
                    <a href="<?= $this->link("button1")->getHref(); ?>" class="btn btn-outline-dark mx-1 mb-3"><?= $this->link("button1")->getText(); ?></a>
                <?php endif; ?>
                <?php if (!$this->link("button2")->isEmpty()) : ?>
                    <a href="<?= $this->link("button2")->getHref(); ?>" class="btn btn-outline-dark mx-1 mb-3"><?= $this->link("button2")->getText(); ?></a>
                <?php endif; ?>
                <?php if (!$this->link("button3")->isEmpty()) : ?>
                    <a href="<?= $this->link("button3")->getHref(); ?>" class="btn btn-outline-dark mx-1 mb-3"><?= $this->link("button3")->getText(); ?></a>
                <?php endif; ?>
                </div>
            </div>
        <?php endif; ?>
        </div>
        <div class="row">
            <div class="col-12 col-lg-4 mb-3 mx-auto">
                <?php if($this->editmode) : ?>
                    <span class="card p-2">
                        <?php echo $this->image("image1", array("class" => 'card-img-top')); ?>
                        <div class="card-body">
                            <h2 class="card-title mt-0"><?php echo $this->input("rubrik1"); ?></h2>
                            <p class="card-text"><?php echo $this->textarea("text1"); ?></p>
                            <?php echo $this->link("readmore1"); ?>
                        </div>
                    </span>
                <?php else: ?>
                    <a href="<?php echo $this->link("readmore1")->getHref(); ?>" class="card p-2 nav-block">
                        <?php echo $this->image("image1", array("class" => 'card-img-top')); ?>
                        <div class="card-body">
                            <h2 class="card-title mt-0"><?php echo $this->input("rubrik1"); ?></h2>
                            <p class="card-text"><?php echo $this->textarea("text1"); ?></p>
                            <div class="nav-block-link"><?php echo $this->link("readmore1")->getText(); ?>&nbsp;<i class="fal fa-chevron-circle-right fa-lg"></i></div>
                        </div>
                    </a>
                <?php endif; ?>
            </div>
            <div class="col-12 col-md-6 col-lg-4 mb-3 mx-auto">
                <?php if($this->editmode) : ?>
                    <span class="card p-2">
                        <?php echo $this->image("image2", array("class" => 'card-img-top')); ?>
                        <div class="card-body">
                            <h2 class="card-title mt-0"><?php echo $this->input("rubrik2"); ?></h2>
                            <p class="card-text"><?php echo $this->textarea("text2"); ?></p>
                            <?php echo $this->link("readmore2"); ?>
                        </div>
                    </span>
                <?php else: ?>
                    <a href="<?php echo $this->link("readmore2")->getHref(); ?>" class="card p-2 nav-block">
                        <?php echo $this->image("image2", array("class" => 'card-img-top')); ?>
                        <div class="card-body">
                            <h2 class="card-title mt-0"><?php echo $this->input("rubrik2"); ?></h2>
                            <p class="card-text"><?php echo $this->textarea("text2"); ?></p>
                            <div class="nav-block-link"><?php echo $this->link("readmore2")->getText(); ?>&nbsp;<i class="fal fa-chevron-circle-right fa-lg"></i></div>
                        </div>
                    </a>
                <?php endif; ?>
            </div>
            <div class="col-12 col-md-6 col-lg-4 mb-3 mx-auto">
                <?php if($this->editmode) : ?>
                    <span class="card p-2">
                        <?php echo $this->image("image3", array("class" => 'card-img-top')); ?>
                        <div class="card-body">
                            <h2 class="card-title mt-0"><?php echo $this->input("rubrik3"); ?></h2>
                            <p class="card-text"><?php echo $this->textarea("text3"); ?></p>
                            <?php echo $this->link("readmore3"); ?>
                        </div>
                    </span>
                <?php else: ?>
                    <a href="<?php echo $this->link("readmore3")->getHref(); ?>" class="card p-2 nav-block">
                        <?php echo $this->image("image3", array("class" => 'card-img-top')); ?>
                        <div class="card-body">
                            <h2 class="card-title mt-0"><?php echo $this->input("rubrik3"); ?></h2>
                            <p class="card-text"><?php echo $this->textarea("text3"); ?></p>
                            <div class="nav-block-link"><?php echo $this->link("readmore3")->getText(); ?>&nbsp;<i class="fal fa-chevron-circle-right fa-lg"></i></div>
                        </div>
                    </a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
