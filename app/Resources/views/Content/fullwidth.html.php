<?php
/**
 * @var \Pimcore\Templating\PhpEngine $this
 * @var \Pimcore\Templating\PhpEngine $view
 * @var \Pimcore\Templating\GlobalVariables $app
 */

$this->extend('default.html.php');

?>

<?php $language = $this->language; ?>
<?php if($this->editmode) : ?>
<style>
table, table td, table th {border:none}
.pimcore_block_button_up, .pimcore_block_button_down {display:none !important;}
#pimcore_editable_rightAreablock .pimcore_area_edit_button,
#pimcore_editable_mainAreablock .pimcore_area_edit_button {z-index: 99;}
.pimcore_area_puffblock .pimcore_block_entry {clear: none; float: left; position: relative;}
div.top-promo {overflow: hidden !important;}
div[type=slide] {display:block; width: 970px;}
.info {font-weight:700;margin:0;}
.margins {margin:8px 0 0 0;}
</style>
<?php endif; ?>

<div class="start-grid-31 alpha omega">
    <?php echo $this->areablock('mainAreablock', array(
        "toolbar"=> 0,
        "allowed"=> array("puffblock","slideshow","textfield","eventlistVertical","newsVertical"),
        "params" => array(
            "slideshow" => array(
                "width" => 976,
                "height" => 368,
                "language" => $this->language,
                "website" => $this->website,
                "startsite" => $this->startsite
            ),
            "puffblock" => array("class" => 'promo_wrapper ', 'itemsPerRow' => 4),
            "newsVertical" => [
                'baseuri' => $this->website['baseuri'],
                "grid" => 'start-grid-7',
                'itemsPerRow' => 4,
                'newsTop' => true
            ],
            "eventlistVertical" => [
                'baseuri' => $this->website['baseuri'],
                'itemsPerRow' => 4
            ],
            "textfield" => array()
        ))); ?>
</div>
