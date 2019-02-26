<?php
/**
 * @var \Pimcore\Templating\PhpEngine $this
 * @var \Pimcore\Templating\PhpEngine $view
 * @var \Pimcore\Templating\GlobalVariables $app
 */

$language = $this->language;
?>

<?php if($this->editmode) : ?>
<style>
table, table td, table th {border:none}
.pimcore_block_button_up .pimcore_block_button_down, .pimcore_open_link_button {display:none !important;}
.pimcore_open_link_button {display:none !important;}
#pimcore_editable_rightAreablock .pimcore_area_edit_button,
#pimcore_editable_mainAreablock .pimcore_area_edit_button {z-index: 9999;}
.info {font-weight:700;margin:0;}
.margins {margin:8px 0 0 0;}
.main{overflow:visible;}
.pimcore_area_buttons {display: block;visibility: visible !important;}
.pimcore_editable .pimcore_tag_snippet {width:100%; height:100%;!important;display: block!important;}
</style>
<?php endif; ?>

<?php echo $this->areablock('mainAreablock', [
    "allowed"=> ["carousel","cards-block","news-block","events-block","puff-block3333"],
    "toolbar"=> 0,
    "params" => [
        "news-block" => [
            'baseuri' => $this->website['baseuri'],
            'itemsPerRow' => 4,
            'newsTop' => true,
            "forceEditInView" => true
        ],
        "events-block" => [
            'baseuri' => $this->website['baseuri'],
            "forceEditInView" => true
        ],
        "puff-block3333" => [
            "itemsPerRow" => 4,
            'containerClass' => 'container mb-4 mt-4 mt-lg-8 mb-lg-8',
            'colClass' => 'col-12 col-sm-6 col-lg-4 col-xl-3'
        ]
    ]
]); ?>
