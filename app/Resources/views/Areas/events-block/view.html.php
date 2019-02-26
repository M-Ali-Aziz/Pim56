<?php
/**
 * @var \Pimcore\Templating\PhpEngine $this
 * @var \Pimcore\Templating\PhpEngine $view
 * @var \Pimcore\Templating\GlobalVariables $app
 */
?>
<?php
$language = $this->language;
$uri = ($language == 'sv') ? '/kalendarium/' : '/calendar/';
$baseUri = ($this->website['baseuri'] == '/') ? '' : $this->website['baseuri'];
$uri = $baseUri . $uri;
?>

<?php
$button = 'primary';
$heading = '';
$text = '';
$datebox = 'bg-dark';

if ($this->select("color")->getData() == 'bg-bronze' || $this->select("color")->getData() == 'bg-blue'|| $this->select("color")->getData() == 'bg-dark') {
    $button = 'white';
    $heading = 'text-white';
    $text = 'text-white';
    $datebox = 'bg-white text-dark';
}
?>

<?php if($this->eventList) : ?>
<div class="<?= $this->select("color")->getData(); ?>">
    <div class="container py-4" id="calendar_cards">

        <?php if ($this->editmode): ?>
            <div class="row my-8">
                <div class="col-12 text-center">
                    <h1><?= $this->input("heading"); ?></h1>
                    <p><?= $this->textarea("beskrivning"); ?></p>
                <div class="mt-5">
                    <div class="btn btn-outline-<?= $button ; ?> mx-1 mb-3">
                        <?= $this->link("button1"); ?>
                    </div>
                    <div class="btn btn-outline-<?= $button ; ?> mx-1 mb-3">
                        <?= $this->link("button2"); ?>
                    </div>
                    <div class="btn btn-outline-<?= $button ; ?> mx-1 mb-3">
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
                        <a href="<?= $this->link("button1")->getHref(); ?>" class="btn btn-outline-<?= $button ; ?> mx-1 mb-3"><?= $this->link("button1")->getText(); ?></a>
                    <?php endif; ?>
                    <?php if (!$this->link("button2")->isEmpty()) : ?>
                        <a href="<?= $this->link("button2")->getHref(); ?>" class="btn btn-outline-<?= $button ; ?> mx-1 mb-3"><?= $this->link("button2")->getText(); ?></a>
                    <?php endif; ?>
                    <?php if (!$this->link("button3")->isEmpty()) : ?>
                        <a href="<?= $this->link("button3")->getHref(); ?>" class="btn btn-outline-<?= $button ; ?> mx-1 mb-3"><?= $this->link("button3")->getText(); ?></a>
                    <?php endif; ?>
                    </div>
                </div>
            </div>
        <?php endif; ?>
        <div class="row my-5">
            <?php
                foreach($this->eventList as $item) :
                    $date = (string) $this->calendarEventDate(
                        $language,
                        $item->getStart(),
                        $item->getEnd(),
                        $item->getShowEnd()
                    );
            ?>
            <div class="col-12 col-lg-6 col-lined">
                <a href="<?php echo $uri; ?><?php echo $item->getKey(); ?>" class="card card-item nav-block flex-row card-item-lined h-100 nav-block-hover-plaster-25 p-2 py-md-3 nmx-2 <?php echo $this->select("color")->getData(); ?>" title="<?php echo $item->getRubrik(); ?>">
                    <div class="card-date">
                        <div class="calendar-date-box bg-dark d-none d-sm-block">
                            <h1><?php echo $item->getStart()->format("j"); ?></h1>
                            <p><?php echo $item->getStart()->formatLocalized("%b"); ?></p>
                        </div>
                    </div>
                    <div class="card-body p-2 <?php echo $text ; ?>">
                        <div class="meta">
                            <date class="meta-date" datetime="2018-04-26 13:15+01:00"><?php echo $date; ?></date>
                            <span class="meta-category"><?php echo $item->getCategory() ? $this->translate($item->getCategory()) : ''; ?></span>
                        </div>
                        <h3 class="nav-block-link mt-0 mb-2 h5 <?php echo $text ; ?>"><?php echo $item->getRubrik()?></h3>
                    </div>
                </a>
            </div>
            <?php endforeach;?>
        </div>
    </div>
</div>
<?php endif;?>
