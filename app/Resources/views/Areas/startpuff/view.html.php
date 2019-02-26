<?php
/**
 * @var \Pimcore\Templating\PhpEngine $this
 * @var \Pimcore\Templating\PhpEngine $view
 * @var \Pimcore\Templating\GlobalVariables $app
 */
?>
<?php
$color = $this->select("color")->getData();
if(empty($color)) $color = 'bg_blue';

$puff = $this->select("puff")->getData();
if(empty($puff)) $puff = 'promo_txt_large';

$link = $this->href("promo_href");
if ($this->href("promo_href") == '') {
    $link = $this->input("promo_link");
}

$width = (($this->document->getProperty('DropdownMenu') == 1) AND ($this->document->getProperty('landingPage') == 1)) ? " grid-7" : " start-grid-8";

    //get rid of right/left gutters using alpha/omega classes
    $gutter = $this->gutters[$this->brick->getIndex()];
    ?>

    <?php if($puff == 'promo_txt_small' || $puff== 'promo_txt_large') : ?>
        <div class="promo_box">
            <div class="promo promo_text_brown <?php echo $color; ?> <?php echo $puff; ?> <?php echo $width; ?> <?php echo $gutter; ?>">
                <a href="<?php echo $link; ?>">
                    <p class="promo_title"><?php echo $this->input("promo_title"); ?></p>
                    <p class="promo_lead"><?php echo $this->input("promo_lead"); ?></p>
                    <span class="promo_icon"></span>
                </a>
            </div>
        </div>
    <?php else : ?>
        <div class="promo_box">
            <div class="promo promo_text_brown <?php echo $color; ?> <?php echo $puff; ?> <?php echo $width; ?> <?php echo $gutter; ?>">
                <a href="<?php echo $link; ?>">
                    <div class="promo_image" style="background-image:url('<?php echo $this->href("promo_image"); ?>');">
                        <span class="promo_icon"></span>
                    </div>
                    <p class="promo_title"><?php echo $this->input("promo_title"); ?></p>
                    <p class="promo_lead"><?php echo $this->input("promo_lead"); ?></p>
                </a>
            </div>
        </div>
    <?php endif; ?>
