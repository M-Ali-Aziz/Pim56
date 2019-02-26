<?php
/**
 * @var \Pimcore\Templating\PhpEngine $this
 * @var \Pimcore\Templating\PhpEngine $view
 * @var \Pimcore\Templating\GlobalVariables $app
 */

$this->extend('objectPreview.html.php');

?>
<?php $language = $this->language; ?>

<?php if($this->event) : ?>
    <!-- Text content start -->
    <div id="text_wrapper" class="grid-15 push-8 alpha">
        <article id="text_content_main">
            <!--eri-no-index-->
            <div id="share_wrapper" class="clearfix hide-xs">
            <div id="share_buttons"> </div>
            </div>
            <!--/eri-no-index-->
            <header id="page_title">
                <?php if ($this->event->getRubrik()): ?>
                    <h1><?php echo $this->event->getRubrik() ?></h1>
                <?php endif ?>
                    <h2><?php echo $this->event->getCategory() ?></h2>
            </header>
            <?php if ($this->event->getIngress()): ?>
                <p class="lead"><?php echo $this->event->getIngress() ?></p>
            <?php endif ?>
            <div>
                <?php if ($this->event->getImage1()): ?>
                    <img src="<?php echo $this->event->getImage1()->getThumbnail("Opengraph"); ?>" width="100%">
                    <p class="image_caption"><?php echo $this->event->getCaption(); ?></p>
                <?php endif ?>
            </div>
            <?php if ($this->event->getBody()): ?>
                <p><?php echo $this->event->getBody()?></p>
            <?php endif ?>
        </article>
    </div>
    <!-- Text content end -->

    <!-- Sidebar start -->
    <div id="content_sidebar_wrapper" class="push-8 grid-8 omega">
        <div id="content_sidebar">
            <div class="promo promo_text_brown bg_white promo_txt border">
                <!-- Date -->
                <?php if ($this->event->getStart()): ?>
                    <div class="last-application-date">
                        <div class="day">
                            <span class="fa fa-calendar"></span>
                        </div>
                        <div class="text">&nbsp;</div>
                        <div class="month">
                            <?php
                                $date = $this->calendarEventDate(
                                    $language,
                                    $this->event->getStart(),
                                    $this->event->getEnd(),
                                    $this->event->getShowEnd()
                                );
                                $date = str_replace(["kl.", "at"], "<br>", $date);
                                echo $date;
                            ?>
                        </div>
                    </div>
                <?php endif ?>
            </div>
            <!-- Local -->

            <?php if ($this->lokal && !$this->event->getVenue_later()): ?>
                <div class="tab-sidebar-info">
                    <h2><?php echo $this->translate('lokal'); ?></h2>
                    <p><?php
                        $address = $this->lokal->getAddress();
                        $address = str_replace("\n", "<br>", $address);
                        echo $address;
                    ?></p>
                    <?php if ($this->coordinate): ?>
                        <iframe src="https://www.google.com/maps/embed/v1/place?key=<?php echo $this->google->browserapikey; ?>&q=<?php echo $this->coordinate; ?>&zoom=12" width="100%" frameborder="0" style="border:0" allowfullscreen></iframe>
                    <?php endif ?>
                </div>
            <?php elseif($this->event->getVenue_later()): ?>
                <div class="alert alert-info" role="alert">
                    <p><?php echo $this->translate('lokal_meddelande'); ?></p>
                </div>
            <?php endif ?>
            <!-- Contact -->
            <?php if ($this->event->getNamn() || $this->event->getEmail() || $this->event->getPhone()): ?>
                <div class="tab-sidebar-info">
                    <h2><?php echo $this->translate('kontakt'); ?></h2>
                    <?php if ($this->event->getNamn()): ?>
                        <p><strong><?php echo $this->event->getNamn(); ?></strong></p>
                    <?php endif ?>
                    <?php if ($this->event->getEmail()): ?>
                        <p><a href="mailto:<?php echo $this->event->getEmail($language); ?>"><?php echo $this->event->getEmail(); ?></a></p>
                    <?php endif ?>
                    <?php if ($this->event->getPhone()): ?>
                        <p>Telefon: <?php echo $this->event->getPhone(); ?></p>
                    <?php endif ?>
                </div>
            <?php endif ?>
        </div>
    </div>
    <!-- Sidebar end -->

    
<?php endif;?>
