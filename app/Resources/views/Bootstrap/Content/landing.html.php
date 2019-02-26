<?php
/**
 * @var \Pimcore\Templating\PhpEngine $this
 * @var \Pimcore\Templating\PhpEngine $view
 * @var \Pimcore\Templating\GlobalVariables $app
 */

$this->extend('default.html.php');
?>

<?php if($this->editmode) : ?>
<style>
table, table td, table th {border:none}
.pimcore_block_button_up .pimcore_block_button_down, .pimcore_open_link_button {display:none !important;}
.pimcore_open_link_button {display:none !important;}
#pimcore_editable_rightAreablock .pimcore_area_edit_button,
#pimcore_editable_mainAreablock .pimcore_area_edit_button {z-index: 9999;}
.x-window .pimcore_tag_input {border: 1px solid #dedbd9;}
.info {font-weight:700;margin:0;}
.margins {margin:8px 0 0 0;}
.embed-responsive {z-index:1;}
.pimcore_area_entry {margin-bottom: 40px!important;}
.main{overflow:visible;}
.pimcore_area_buttons {display: block;visibility: visible !important;}
</style>
<?php endif; ?>

<!-- <div class="container pt-2 pt-lg-3">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb m-0 p-0 mb-0 cmb-0 font-size-sm bg-transparent">
            <?php // echo $this->template("Bootstrap/Navigation/breadcrumb.html.php");?>
        </ol>
    </nav>
</div> -->

<main>
    <?php if ($this->document->getProperty('section')) : ?>
    <div class="container">
        <div class="row p-3">
            <div class="col p-4 bg-plaster-50 nav-undecorated">
                <h1 class="h2 my-0"><a href="<?php echo ($this->getProperty('navStartNode')); ?>"><?php echo ($this->document->getProperty('section')); ?></a></h1>
            </div>
        </div>
    </div>
    <?php endif; ?>
    <?= $this->areablock('mainAreablock', [
        "allowed" => ["carousel","hero","cards-block","news-block","events-block", "puff-block3333", "masonry-a", "masonry-b", "masonry-c", "masonry-d"],
        "group" => [
            "Standard" => ["carousel","hero","cards-block","news-block","events-block","puff-block3333"],
            "Masonry" => ["masonry-a", "masonry-b", "masonry-c", "masonry-d"]
        ],
        "params" => [
            "news-block" => ['baseuri' => $this->website['baseuri'],
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
                'containerClass' => 'container mb-5 mt-4 mt-lg-8',
                'colClass' => 'col-12 col-sm-6 col-lg-4 col-xl-3 mb-5'
            ]
        ]
    ]); ?>
</main>
