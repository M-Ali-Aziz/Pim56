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

$link = $this->href("promo_href");
if ($this->href("promo_href") == '') {
    $link = $this->input("promo_link");
}

$top_promo_class = "top-promo-overlay";
$top_promo_class .= (($this->checkbox("sigill")->isChecked()) ? " top-promo-watermark" : "");

    // load partial
    echo $this->template('Slideshow/partialSlide.html.php', array(
        'image_src' => $this->href("promo_image"),
        'class' => $top_promo_class,
        'target_href' => $link,
        'color' => $color,
        'title' => $this->input("promo_title"),
        'lead' => $this->input("promo_lead")
    ));
?>
