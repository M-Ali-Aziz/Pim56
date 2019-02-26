<?php
/**
 * @var \Pimcore\Templating\PhpEngine $this
 * @var \Pimcore\Templating\PhpEngine $view
 * @var \Pimcore\Templating\GlobalVariables $app
 */
?>

<?php
    $baseUri = ($this->website['baseuri'] == '/') ? '' : $this->website['baseuri'];
    $uri = $baseUri . $uri;
?>

<div class="row">
    <div class="col-12 col-lg-8 mb-6 mb-lg-0">
        <article>
            <?php if($this->nyheter) : ?>
                <h1><?php echo $this->nyheter->getRubrik() ?></h1>
                <div class="nmt-3 mb-3">
                    <p class="text-uppercase mt-0"><?php echo $this->translate('published'); ?>: <?php echo date("Y-m-d", $this->nyheter->getCreationDate())?></p>
                </div>
                <p class="lead"><?php echo $this->nyheter->getIngress(); ?></p>
                <?php if($this->nyheter->getImage1()): ?>
                    <figure class="figure">
                        <img src="<?php echo $this->nyheter->getImage1(); ?>" class="figure-img img-fluid m-0">
                        <?php if ($this->nyheter->getCaption()) : ?>
                        <figcaption class="figure-caption bg-dark text-white p-2"><?php echo $this->nyheter->getCaption(); ?></figcaption>
                        <?php endif; ?>
                    </figure>
                <?php elseif ($this->nyheter->getYouTube()) : ?>
                    <div class="embed-responsive embed-responsive-16by9">
                    	<iframe class="embed-responsive-item" src="https://www.youtube.com/embed/<?php echo $this->nyheter->getYouTube(); ?>" allowfullscreen></iframe>
                    </div>
                <?php endif; ?>
                <?php echo $this->nyheter->getBody(); ?>
            <?php else : ?>
                <p><?php echo $this->translate('this news does not exist'); ?>!</p>
            <?php endif; ?>
        </article>
    </div>
    <?php if($this->nyheter): ?>
    <div class="col-12 col-lg-4">
        <!-- Kontaktinfo -->
        <?php if($this->nyheter->getBody3()): ?>
            <div class="bg-plaster-50 mb-3 p-5">
                <h3 class="mt-0"><?php echo $this->nyheter->getRubrik3(); ?></h3>
                <?php if($this->nyheter->getImage3()): ?>
                    <img src="<?php echo $this->nyheter->getImage3(); ?>" alt="" class="w-100 mb-3">
                <?php endif; ?>
                <?php echo $this->nyheter->getBody3(); ?>

            </div>
        <?php endif; ?>
        <!-- Mer info -->
        <?php if($this->nyheter->getBody2()): ?>
            <div class="bg-sky-25 mb-3 p-5">
                <h3 class="mt-0"><?php echo $this->nyheter->getRubrik2(); ?></h3>
                <?php echo $this->nyheter->getBody2(); ?>
                <?php if($this->nyheter->getImage2()): ?>
                <img src="<?php echo $this->nyheter->getImage2(); ?>" alt="" class="w-100">
                <?php endif; ?>
            </div>
        <?php endif; ?>
    </div>
    <?php endif; ?>
</div>
