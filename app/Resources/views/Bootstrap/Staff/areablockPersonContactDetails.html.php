<?php
/**
 * @var \Pimcore\Templating\PhpEngine $this
 * @var \Pimcore\Templating\PhpEngine $view
 * @var \Pimcore\Templating\GlobalVariables $app
 */
?>

<div class="bg-plaster-50 mb-6 p-5">
    <?php if($this->heading): ?>
    <p class="h3 mt-0 mb-3"><?php echo $this->translate('contact'); ?></p>
    <?php endif;  ?>
    <p>
        <strong><?php echo $this->person->getDisplayName(); ?></strong>
        <br>
        <?php echo $this->roles; ?>
    </p>

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

    <?php
        if($this->image) :
            echo $this->displayImage(
                'staff/' . $this->person->getUid() . '.jpg',
                $this->person->getDisplayName(),
                'w-100',
                ''
            );
        endif;
    ?>
</div>
