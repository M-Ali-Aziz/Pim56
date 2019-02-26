<?php
/**
 * @var \Pimcore\Templating\PhpEngine $this
 * @var \Pimcore\Templating\PhpEngine $view
 * @var \Pimcore\Templating\GlobalVariables $app
 */

$this->extend('default.html.php');

?>
<?php $language = $this->language;?>

<?php if ($this->document->getProperty('bootstrap')) : ?>
    <div class="row">
        <div class="col-12 col-lg-8 mb-6 mb-lg-0">
            <article>
                <h1><?php echo $this->translate('contact'); ?></h1>
                <div class="nmt-3 mb-3">
                    <p class="text-uppercase mt-0"><?php echo $this->org->getName($language); ?></p>
                </div>
                <?php
                    if($this->staffList) :
                        $helper = $this->staff($this, $this->staffList);
                        echo $helper->staffList(array(
                            'image' => false,
                            'room' => false,
                            'department' => $this->org->getDepartmentNumber(),
                            'roleinfo' => false,
                            'moreinfo' => true
                        ));
                    ?>
                    <?php else : ?>
                    <p><?php echo $this->translate('no search result'); ?> - <?php echo $this->translate('check organisational number'); ?>!</p>
                <?php endif;?>
            </article>
        </div>
        <div class="col-12 col-lg-4">
            <?php if($this->org) : ?>
            <div class="bg-plaster-50 mb-6 p-5">
                <?php echo $this->render('Bootstrap/Staff/partialOrgContactDetails.html.php', array(
                        'name'      => $this->org->getName($this->language),
                        'visiting'  => $this->org->getStreet() . ', ' . $this->org->getLocation(),
                        'postal'    => str_replace('$',', ',$this->org->getPostalAdress()),
                        'internal'  => $this->org->getPostOfficeBox(),
                        'phone'     => $this->org->getTelephoneNumber() ? $this->org->getTelephoneNumber() : $this->org->getVxNumber(),
                        'website'   => $this->org->getUrl(),
                        'gm_key' => $this->google->browserapikey,
                        'gm_q'      => str_replace(array('<','>'), '', $this->org->getGpsC())
                    ));
                ?>
            </div>
            <?php endif;?>
        </div>
    </div>
<?php else : ?>

<!-- Text content start -->
<div id="text_wrapper" class="grid-15<?php echo ((!$this->getProperty('navStartNode')) || ($this->getProperty('push-8'))) ? " push-8 alpha" : ""; ?>">
    <article id="text_content_main">
        <!--eri-no-index-->
        <div id="share_wrapper" class="clearfix">
            <div id="share_buttons"> </div>
        </div>
        <!--/eri-no-index-->
        <header id="page_title">
            <h1><?php echo $this->translate('contact'); ?></h1>
            <h2><?php echo $this->org->getName($language); ?></h2>
        </header>
        <p class="lead"> </p>
        <?php
            if($this->staffList) :

                $helper = $this->staff($this, $this->staffList);

                echo $helper->staffList(array(
                    'image' => false,
                    'room' => false,
                    'department' => $this->org->getDepartmentNumber(),
                    'roleinfo' => false,
                    'moreinfo' => true
                ));
        ?>
        <?php else : ?>
            <p><?php echo $this->translate('no search result'); ?> - <?php echo $this->translate('check organisational number'); ?>!</p>
        <?php endif;?>
    </article>
</div>
<!-- Text content end -->

<!-- Sidebar start -->
<div id="content_sidebar_wrapper" class="<?php echo ((!$this->getProperty('navStartNode')) || ($this->getProperty('push-8'))) ? "push-8 " : ""; ?>grid-8 omega">
    <?php if($this->org) : ?>
    <div id="content_sidebar">
        <?php echo $this->render('Staff/partialOrgContactDetails.html.php', array(
                'name'      => $this->org->getName($this->language),
                'visiting'  => $this->org->getStreet() . ', ' . $this->org->getLocation(),
                'postal'    => str_replace('$',', ',$this->org->getPostalAdress()),
                'internal'  => $this->org->getPostOfficeBox(),
                'phone'     => $this->org->getTelephoneNumber() ? $this->org->getTelephoneNumber() : $this->org->getVxNumber(),
                'website'   => $this->org->getUrl(),
                'gm_key' => $this->google->browserapikey,
                'gm_q'      => str_replace(array('<','>'), '', $this->org->getGpsC())
            ));
        ?>
    </div>
    <?php endif;?>
</div>
<!-- Sidebar end -->

<?php endif; ?>
