<?php
/**
 * @var \Pimcore\Templating\PhpEngine $this
 * @var \Pimcore\Templating\PhpEngine $view
 * @var \Pimcore\Templating\GlobalVariables $app
 */

$this->extend('default.html.php');

?>
<?php $language = $this->document->getProperty('language');?>
<!-- Text content start -->
<div id="text_wrapper" class="grid-15<?php echo ((!$this->getProperty('navStartNode')) || ($this->getProperty('push-8'))) ? " push-8 alpha" : ""; ?>">
    <article id="text_content_main">
        <!--eri-no-index-->
        <div id="share_wrapper" class="clearfix">
            <div id="share_buttons"> </div>
        </div>
        <!--/eri-no-index-->
        <header id="page_title">
            <?php echo $this->faculty->getNamn(); ?>
            <h1><?php echo $this->translate('faculty and expertise'); ?></h1>
            <h2><?php echo ($this->orgunit['name'][$language] ? $this->orgunit['name'][$language] : '')?></h2>
        </header>
        <p class="lead"> </p>
        <?php if($this->staffList) : ?>
            <?php foreach($this->staffList as $employee) : ?>
                <?php if (isset($employee['faculty'])) : ?>
                    <div class="person">
                        <hr>
                        <div class="clearfix">
                            <h2><?php echo $employee['displayname']?></h2>
                            <p>
                                <?php
                                $values = array(
                                    $employee['academicdegree'][$language],
                                    $employee['title'][$language]
                                );
                                echo $this->commaSeparatedValues($values);
                                ?>
                            </p>
                            <p>
                                <a href="mailto:<?php echo $employee['mail']?>"><?php echo $employee['mail']?></a><br>
                                <?php echo $this->translate('phone'); ?>: <?php echo $employee['phone']?>
                            </p>
                            <?php $uri = ($language == 'sv') ? "forskning/faculty/" : "research/faculty/";?>
                            <p><a href="<?php echo $this->baseUri . $uri?><?php echo $employee['uid']?>"><?php echo $this->translate('show more info'); ?></a></p>
                        </div>
                    </div>
                <?php endif;?>
            <?php endforeach;?>
        <?php endif;?>
    </article>
</div>
<!-- Text content end -->

<!-- Sidebar start -->
<div id="content_sidebar_wrapper" class="<?php echo ((!$this->getProperty('navStartNode')) || ($this->getProperty('push-8'))) ? "push-8 " : ""; ?>grid-8 omega">
    <div id="content_sidebar">
        <?php echo $this->render('Staff/partialOrgContactDetails.html.php', array(
                'name'      => $this->faculty->getNamn(),
                'visiting'  => $this->faculty->getBesoksadress(),
                'postal'    => $this->faculty->getPostadress(),
                'internal'  => $this->faculty->getHamtstalle(),
                'phone'     => $this->faculty->getTelephoneNumber(),
                'website'   => $this->orgunit['homepage'][$language]
            ));
        ?>
    </div>
    <?php if($this->orgunit) : ?>
    <div id="content_sidebar">
        <?php echo $this->render('Staff/partialOrgContactDetails.html.php', array(
                'name'      => $this->orgunit['name'][$language],
                'visiting'  => $this->orgunit['address']['street'],
                'postal'    => $this->orgunit['address']['postofficebox'],
                'internal'  => $this->orgunit['address']['registeredaddress'],
                'phone'     => $this->orgunit['phonenumber'],
                'website'   => $this->orgunit['homepage'][$language]
            ));
        ?>
    </div>
    <?php endif;?>
</div>
<!-- Sidebar end -->
