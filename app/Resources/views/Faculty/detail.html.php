<?php
/**
 * @var \Pimcore\Templating\PhpEngine $this
 * @var \Pimcore\Templating\PhpEngine $view
 * @var \Pimcore\Templating\GlobalVariables $app
 */

$this->extend('default.html.php');

?>
<?php $language = $this->document->getProperty('language');?>
<?php if($this->employee) : ?>
    <!-- Text content start -->
    <div id="text_wrapper" class="grid-15<?php echo ((!$this->getProperty('navStartNode')) || ($this->getProperty('push-8'))) ? " push-8 alpha" : ""; ?>">
        <article id="text_content_main">
            <!--eri-no-index-->
            <div id="share_wrapper" class="clearfix">
                <div id="share_buttons"> </div>
            </div>
            <!--/eri-no-index-->
            <header id="page_title">
                <h1><?php echo $this->translate('faculty and expertise'); ?></h1>
            </header>
            <p class="lead"> </p>
            <div class="person">
                <?php
                $member = $this->employee['faculty'];
                $uri = ($language == 'sv') ? "forskning/faculty/sokresultat" : "research/faculty/search";
                $uri = $this->baseUri . $uri;
                ?>
                <div class="clearfix">
                    <h2><?php echo $this->employee['displayname']?></h2>
                    <p>
                        <?php
                        $values = array(
                            $this->employee['academicdegree'][$language],
                            $this->employee['title'][$language]
                        );
                        ?>
                        <?php echo $this->commaSeparatedValues($values)?>
                    </p>
                    <p> <?php echo $member['biography'][$language];?></p>
                    <h3><?php echo $this->translate('research interests'); ?></h3>
                    <?php
                    $areas = array();
                    foreach($member['research']['areas'] as $i=>$area) {
                        array_push($areas, '<a href="' . $uri . '?topic=' . $area['id'] . '">' . $this->researchArea($area['id']) . '</a>');
                    }
                    ?>
                    <p>
                        <?php echo $this->commaSeparatedValues($areas)?>
                    </p>
                    <h3><?php echo $this->translate('teaching areas'); ?></h3>
                    <p> <?php echo nl2br($member['teaching']['description'][$language]);?></p>
                    <h3><?php echo $this->translate('current research'); ?></h3>
                    <p><?php echo nl2br($member['research']['description'][$language]);?><br /></p>
                    <h3><?php echo $this->translate('publications'); ?></h3>
                    <?php if (isset($this->publications)) : ?>
                        <?php foreach($this->publications as $record) : ?>
                            <p>
                                <?php echo $this->publication($record, $language)?><br>
                                <a href="http://lup.lub.lu.se/record/<?php echo $record->recordIdentifier?>"><?php echo $this->translate('show catalogue record'); ?></a>
                                <br><br>
                            </p>
                            <?php endforeach;?>
                        <?php endif;?>
                    <?php if ($member['links']) : ?>
                        <h3><?php echo $this->translate('external links'); ?></h3>
                        <?php foreach($member['links'] as $link) : ?>
                            <?php echo '<p><a href="'. $link .'">' . $link ."</a></p>"; ?>
                        <?php endforeach;?>
                    <?php endif;?>
                    <p><br></p>
                    <p><a href="<?php echo $this->facultyUri . $this->employee['uid']?>"><?php echo $this->translate('visit this faculty page in language'); ?></a></p>
                </div>
            </div>
        </article>
    </div>
    <!-- Text content end -->

    <!-- Sidebar start -->
    <div id="content_sidebar_wrapper" class="<?php echo ((!$this->getProperty('navStartNode')) || ($this->getProperty('push-8'))) ? "push-8 " : ""; ?>grid-8 omega">
        <div id="content_sidebar">
            <h2><?php echo $this->translate('contact'); ?></h2>
            <p>
                <strong><?php echo $this->employee['displayname']?></strong><br />
                <?php echo $this->commaSeparatedValues($values)?><br />
                <?php $roles = $this->employee['roles'];
                $uri = ($language == 'sv') ? "forskning/faculty/" : "research/faculty/";
                $uri = $this->baseUri . $uri;
                ?>
                <?php if(is_array($roles) && count($roles)): foreach($roles as $role) : ?>
                    <a href="<?php echo $uri?><?php echo $role['departmentnumber']?>"><?php echo $this->departmentName($role['departmentnumber'])?></a><br />
                <?php endforeach; endif; ?>
            </p>
            <p>
                <?php if($this->employee['mail']) : ?>
                    <a href="mailto:<?php echo $this->employee['mail']?>" title="<?php echo $this->employee['mail']?>"><?php echo $this->employee['mail']?></a><br>
                <?php endif;?>
                <?php if($this->employee['phone']) : ?>
                    <?php echo $this->translate('phone'); ?>: <?php echo $this->employee['phone']?><br>
                <?php endif;?>
                <?php if($this->employee['mobile']) : ?>
                    <?php echo $this->translate('mobile');?>: <?php echo $this->employee['mobile']?>
                <?php endif;?>
            </p>
            <?php if($this->employee['roomnumber']) : ?>
                <p><?php echo $this->translate('room');?>: <?php echo $this->employee['roomnumber']?></p>
            <?php endif;?>
            <?php
            $image = $this->displayImage(
            'http://static.ehl.lu.se/staff/' . $this->employee['uid'] . '.jpg',
            $this->employee['displayname'],
            'width: 224px;'
        );
        ?>
        <?php if ($image) : echo $image; endif;?>
            <p><a href="<?php echo $this->facultyUri . $this->employee['uid']?>"><?php echo $this->translate('this page in language'); ?></a></p>
        </div>
    </div>
    <!-- Sidebar end -->

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
                <h1><?php echo $this->translate('faculty and expertise'); ?></h1>
            </header>
            <p class="lead"> </p>
            <div class="person">
                <div class="clearfix">
                    <p>Faculty member page not found!</p>
                </div>
            </div>
        </article>
    </div>
    <!-- Text content end -->

    <!-- Sidebar start -->
    <div id="content_sidebar_wrapper" class="<?php echo ((!$this->getProperty('navStartNode')) || ($this->getProperty('push-8'))) ? "push-8 " : ""; ?>grid-8 omega">
        <div id="content_sidebar">
        </div>
    </div>

<?php endif;?>
