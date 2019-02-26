<?php
/**
 * @var \Pimcore\Templating\PhpEngine $this
 * @var \Pimcore\Templating\PhpEngine $view
 * @var \Pimcore\Templating\GlobalVariables $app
 */
?>

<?php if ($this->document->getProperty('bootstrap')) : ?>
<div class="container">
    <div class="row">
    <?php if($this->image): ?>
        <div class="col-sm col-lg-4 px-0">
            <?php
            if($this->image):
                echo $this->displayImage(
                    'staff/' . $this->person->getUid() . '.jpg',
                    $this->person->getDisplayName(), '', 'width: 180px;'
                );
            endif;
            ?>
        </div>
    <?php endif; ?>
        <div class="col-sm col-lg-8 px-0">
            <?php if($this->heading): ?>
            <h3><?php echo $this->heading; ?></h3>
            <?php endif; ?>
            <p><?php echo $this->roles; ?></p>
            <p>
                <?php if($this->mail): ?>
                    <a href="mailto:<?php echo $this->mail; ?>" title="<?php echo $this->mail; ?>"><?php echo $this->mail; ?></a><br>
                <?php endif; ?>
                <?php if($this->phone): ?>
                    <?php echo ucfirst($this->translate('phone')); ?>: <?php echo $this->phone; ?><br>
                <?php endif; ?>
                <?php if($this->room): ?>
                    <?php echo ucfirst($this->translate('room')); ?>: <?php echo $this->room; ?><br>
                <?php endif; ?>
            </p>
            <?php if($this->website && !$this->moreinfo): ?>
            <p><?php echo $this->translate('personal_website') ?>: <a href="<?php echo $this->website; ?>" title="<?php echo $this->website; ?>"><?php echo $this->website; ?></a></p>
            <?php endif; ?>

            <?php if($this->portalUrl && !$this->moreinfo): ?>
            <p><a href="<?php echo $this->portalUrl; ?>" title="<?php echo $this->portalUrl; ?>"><?php echo $this->translate('my_profile_lucris') ?></a></p>
            <?php endif; ?>
        </div>
    </div>
    <div class="row">
        <?php if($this->moreinfo): ?>
        <p><a href="<?php echo $this->moreinfo; ?>"><?php echo ucfirst($this->translate('show more info')); ?></a></p>
        <?php endif; ?>
    </div>
</div>
<?php else : ?>
<div class="person">
    <div class="clearfix">

        <?php
        if($this->image):
            echo $this->displayImage(
                'staff/' . $this->person->getUid() . '.jpg',
                $this->person->getDisplayName(), 'align_left', 'width: 140px;'
            );
        endif;
        ?>

        <?php if($this->heading): ?>
        <h2><?php echo $this->heading; ?></h2>
        <?php endif; ?>

        <p><?php echo $this->roles; ?></p>

        <p>
        <?php if($this->mail): ?>
            <a href="mailto:<?php echo $this->mail; ?>" title="<?php echo $this->mail; ?>"><?php echo $this->mail; ?></a><br>
        <?php endif; ?>
        <?php if($this->phone): ?>
            <?php echo ucfirst($this->translate('phone')); ?>: <?php echo $this->phone; ?><br>
        <?php endif; ?>
        <?php if($this->room): ?>
            <?php echo ucfirst($this->translate('room')); ?>: <?php echo $this->room; ?><br>
        <?php endif; ?>
        </p>

        <?php if($this->website && !$this->moreinfo): ?>
            <p><?php echo $this->translate('personal_website') ?>: <a href="<?php echo $this->website; ?>" title="<?php echo $this->website; ?>"><?php echo $this->website; ?></a></p>
        <?php endif; ?>

        <?php if($this->portalUrl && !$this->moreinfo): ?>
            <p><a href="<?php echo $this->portalUrl; ?>" title="<?php echo $this->portalUrl; ?>"><?php echo $this->translate('my_profile_lucris') ?></a></p>
        <?php endif; ?>
    </div>
</div>

<?php if($this->moreinfo): ?>
    <p><a href="<?php echo $this->moreinfo; ?>"><?php echo ucfirst($this->translate('show more info')); ?></a></p>
<?php endif; ?>


<?php endif;  ?>
