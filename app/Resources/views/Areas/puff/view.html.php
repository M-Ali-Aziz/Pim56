<?php
/**
 * @var \Pimcore\Templating\PhpEngine $this
 * @var \Pimcore\Templating\PhpEngine $view
 * @var \Pimcore\Templating\GlobalVariables $app
 */
?>


<?php
$color = $this->select("color")->getData();
if(empty($color)) $color = 'bg_blue bg-sky-50';

$puff = $this->select("puff")->getData();
if(empty($puff)) $puff = 'promo_txt_large';
if ($puff == 'promo_txt_small promo_mini') : $puff = 'promo_txt_mini'; endif;

$link = $this->href("promo_href");
if ($this->href("promo_href") == '') {
    $link = $this->input("promo_link");
}
?>

<?php if ($this->document->getProperty('bootstrap')) : ?>
    <?php if($puff == 'promo_txt_small' || $puff== 'promo_txt_large' || $puff== 'promo_txt_mini') : ?>
        <div class="mb-3">
            <a href="<?php echo $link; ?>" class="card nav-block <?php echo $color; ?>">
                <div class="card-body">
                    <h3 class="nav-block-link m-0"><?php echo $this->input("promo_title"); ?></h3>
                    <p class=" mt-3"><?php echo $this->input("promo_lead"); ?></p>
                </div>
            </a>
        </div>
    <?php else : ?>
        <div class="mb-3">
            <a href="<?php echo $link; ?>" class="card nav-block <?php echo $color; ?>">
                <div class="card-img">
                    <div class="card-img-container">
                        <img src="<?php echo $this->href("promo_image"); ?>" alt="<?php echo $this->input("promo_title"); ?>">
                    </div>
                </div>
                <div class="card-body">
                    <h3 class="nav-block-link m-0"><?php echo $this->input("promo_title"); ?></h3>
                    <p class=" mt-3"><?php echo $this->input("promo_lead"); ?></p>
                </div>
            </a>
        </div>
    <?php endif; ?>
<?php else : ?>
    <?php if($puff == 'promo_txt_small' || $puff== 'promo_txt_large' || $puff== 'promo_txt_mini') : ?>
        <div class="promo_box">
            <div class="promo promo_text_brown <?php echo $color; ?> <?php echo $puff; ?>">
                <a href="<?php echo $link; ?>">
                    <p class="promo_title"><?php echo $this->input("promo_title"); ?></p>
                    <p class="promo_lead"><?php echo $this->input("promo_lead"); ?></p>
                    <span class="promo_icon"></span>
                </a>
            </div>
        </div>
    <?php else : ?>
        <div class="promo_box">
            <div class="promo promo_text_brown <?php echo $color; ?> <?php echo $puff; ?>">
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
<?php endif; ?>
