<?php
/**
 * @var \Pimcore\Templating\PhpEngine $this
 * @var \Pimcore\Templating\PhpEngine $view
 * @var \Pimcore\Templating\GlobalVariables $app
 */
?>

<?php if ($this->document->getProperty('bootstrap')) : ?>

    <?php if ($this->employee) : ?>
        <?php
            $helper = $this->staff($this);
            echo $helper->StaffDetail($this->employee, array(
                'image' => $this->checkbox("displayImage")->getData(),
                'heading' => $this->checkbox("displayHeading")->getData(),
                'roleinfo' => false,
                'view' => 'Bootstrap/Staff/areablockPersonContactDetails.html.php'
            ));
        ?>
    <?php endif;?>

<?php else : ?>

    <?php if ($this->employee) : ?>
        <?php
            $helper = $this->staff($this);
            echo $helper->StaffDetail($this->employee, array(
                'image' => $this->checkbox("displayImage")->getData(),
                'heading' => $this->checkbox("displayHeading")->getData(),
                'roleinfo' => false,
                'view' => 'Staff/areablockPersonContactDetails.html.php'
            ));
        ?>
    <?php endif;?>

<?php endif; ?>
