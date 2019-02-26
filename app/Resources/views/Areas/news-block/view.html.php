<?php
/**
 * @var \Pimcore\Templating\PhpEngine $this
 * @var \Pimcore\Templating\PhpEngine $view
 * @var \Pimcore\Templating\GlobalVariables $app
 */
?>

<?php
$language = $this->document->getProperty("language");
$uri = ($language == 'sv') ? '/nyheter/' : '/news/';
$baseUri = ($this->baseuri == '/') ? '' : $this->baseuri;
$uri = $baseUri . $uri;
?>

<?php $language = $this->document->getProperty("language"); ?>
<?php if($this->newsList && count($this->newsList)) : ?>
<div class="<?php echo $this->select("color")->getData(); ?>">
    <div class="container py-4">
        <?php if ($this->editmode): ?>
            <div class="row my-8">
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
            <div class="row my-8">
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
            </div>
        <?php endif; ?>
        <div class="row mb-8">
        <?php
            $count = 0;
            foreach($this->newsList as $item) :
            $locale = ($item->getRubrik($language)) ? $language : false;
            if (empty($locale)) {
                $locale = ($language == 'sv') ? 'en' : false;
            }
        ?>
        <?php if (! $this->newsTop || ($count>0 && $locale)): ?>
            <?php if ($this->newsTop && $count==1) : ?>
            <div class="col-12 col-lg-6">
            <?php endif; ?>
            <?php
                $class = "col-12";
                $rowStart = "<div class='row'>";
                $rowEnd = "</div>";
                switch($count-(int)$this->newsTop):
                    case 0:
                        $class .= ' col-md-6 mb-5';
                        $rowStart = "<div class='row'>";
                        $rowEnd = "";
                        break;
                    case 1:
                        $class .= ' col-md-6 mb-5';
                        $rowStart = "";
                        $rowEnd = "</div>";
                        break;
                    case 2:
                        $class .= ' col-md-6 mb-5 mb-md-0';
                        $rowStart = "<div class='row'>";
                        $rowEnd = "";
                        break;
                    case 3:
                        $class .= ' col-md-6';
                        $rowStart = "";
                        $rowEnd = "</div>";
                        break;
                endswitch;
            ?>
            <?php echo $rowStart; ?>
                <div class="<?php echo $class; ?>">
                    <a href="<?php echo $uri?><?php echo $item->getKey(); ?>" class="card nav-block h-100">
                        <div class="card-img p-2">
                            <div class="card-img-container">
                                <img src="<?php echo $item->getImage1(); ?>" alt="">
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="meta ">
                                <date class="meta-date"><?php echo date("Y-m-d", $item->getCreationDate()); ?></date>
                                <span class="meta-category"><?php echo $item->getCategory() ? $this->translate($item->getCategory()) : ''; ?></span>
                            </div>
                            <h3 class="nav-block-link m-0"><?php echo $item->getRubrik($locale); ?></h3>
                        </div>
                    </a>
                </div>
            <?php echo $rowEnd; ?>
            <?php elseif($locale): ?>
                <div class="col-12 col-lg-6 mb-5 mb-lg-0">
                    <a href="<?php echo $uri; ?><?php echo $item->getKey(); ?>" class="card nav-block h-100">
                        <div class="card-img p-2">
                            <div class="card-img-container">
                                <img src="<?php echo $item->getImage1(); ?>" alt="">
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="meta ">
                                <date class="meta-date"><?php echo date("Y-m-d", $item->getCreationDate()); ?></date>
                                <span class="meta-category"><?php echo $item->getCategory() ? $this->translate($item->getCategory()) : ''; ?></span>
                            </div>
                            <h3 class="h2 nav-block-link m-0"><?php echo $item->getRubrik($locale); ?></h3>
                            <p class=" mt-3"><?php echo $item->getIngress(); ?></p>
                        </div>
                    </a>
                </div>
            <?php endif;?>
        <?php $count++; endforeach;?>
            <?php if($this->newsTop): ?>
            </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php else : ?>
<p><?php echo $this->translate('no news'); ?>!</p>
<?php endif;?>
