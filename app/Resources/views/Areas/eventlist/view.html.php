<?php
/**
 * @var \Pimcore\Templating\PhpEngine $this
 * @var \Pimcore\Templating\PhpEngine $view
 * @var \Pimcore\Templating\GlobalVariables $app
 */
?>
<?php
$language = $this->language;
$link = $this->href("link");
$uri = ($language == 'sv') ? '/kalendarium/' : '/calendar/';
$baseUri = ($this->baseuri == '/') ? '' : $this->baseuri;
$uri = $baseUri . $uri;
?>

<?php if ($this->document->getProperty('bootstrap') == 1) : ?>
    <?php if($this->eventList) : ?>
        <div class="col-12 my-6">
            <h2 class="nml-3"><?php echo $this->heading; ?></h2>
                <div class="border-bottom py-md-3 nm-md-3">
                <?php foreach($this->eventList as $item) :?>
                        <a href="<?php echo $uri; ?><?php echo $item->getKey(); ?>" class="card card-item nav-block bg-transparent flex-row p-0 p-md-3 mb-3 mb-md-0 nav-block-hover-plaster-25" title="<?php echo $item->getRubrik(); ?>">
                            <div class="card-date p-0">
                                <div class="calendar-date-box bg-dark">
                                    <h1><?php echo $item->getStart()->format("j"); ?></h1>
                                    <p><?php echo $item->getStart()->formatLocalized("%b"); ?></p>
                                </div>
                            </div>
                            <div class="card-body p-0 pl-3 pl-md-0">
                                <div class="meta ">
                                    <date class="meta-date" datetime="2018-04-26 13:15+01:00">
                                        <?php
                                            $date = (string) $this->calendarEventDate(
                                                $language,
                                                $item->getStart(),
                                                $item->getEnd(),
                                                $item->getShowEnd()
                                            );
                                            echo $date;
                                        ?>
                                    </date>
                                    <span class="meta-category"><?php echo $item->getCategory() ? $this->translate($item->getCategory()) : ''; ?></span>
                                </div>
                                <h3 class="nav-block-link mt-0 mb-2 h4"><?php echo $item->getRubrik();?></h3>
                            </div>
                        </a>
                <?php endforeach;?>
                </div>
            <?php if (!$this->href("link")->isEmpty()) : ?>
            <div class="mt-5 text-right font-weight-normal">
            	<a href="<?php echo $link?>" class="nav-undecorated"><?php echo $this->translate('more events'); ?>&nbsp;<i class="fal fa-chevron-circle-right fa-lg"></i></a>
            </div>
        <?php endif ; ?>
        </div>
    <?php endif;?>
<?php else: ?>
    <?php if($this->eventList) : ?>
        <div class="calendar-wrapper calendar-vertical <?php echo $this->color; ?> clearfix">
            <h2><a href="<?php echo $link?>"><?php echo $this->heading; ?></a></h2>
            <?php foreach($this->eventList as $item) :?>
                <div class="calendar-item">
                    <p class="calendar-category"><?php echo $item->getCategory() ? $this->translate($item->getCategory()) : ''; ?></p>
                    <p class="calendar-title"><a href="<?php echo $uri; ?><?php echo $item->getKey(); ?>"><?php echo $item->getRubrik()?></a></p>
                    <p class="calendar-lead"><?php echo $this->summary($item->getIngress(), $this->sammanfattning)?> </p>
                    <p class="calendar-date">
                        <?php
                            $date = (string) $this->calendarEventDate(
                                $language,
                                $item->getStart(),
                                $item->getEnd(),
                                $item->getShowEnd()
                            );
                            echo $date;
                        ?>
                    </p>
                </div>
            <?php endforeach;?>
            <p class="archive_link"><a href="<?php echo $link?>"><?php echo $this->translate('more events'); ?><span class="archive_icon"></span></a></p>
        </div>
    <?php endif;?>
<?php endif; ?>
