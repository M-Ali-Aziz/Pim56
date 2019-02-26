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

<?php
$navigation = ($nsn = $this->getProperty('navStartNode')) ?
$this->navigation()->buildNavigation($this->document, $nsn, "") : null;
?>

<div class="container pt-2 pt-lg-3">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb m-0 p-0 mb-0 cmb-0 font-size-sm bg-transparent">
            <?php echo $this->template("Bootstrap/Navigation/breadcrumb.html.php");?>
        </ol>
    </nav>
</div>



<main role="main" class="my-4 my-lg-8">
    <?php if ($this->document->getProperty('section')) : ?>
    <div class="container nmt-6">
        <div class="row p-3">
            <div class="col p-4 bg-plaster-50 nav-undecorated">
                <h1 class="h2 my-0"><a href="<?php echo ($this->getProperty('navStartNode')); ?>"><?php echo ($this->document->getProperty('section')); ?></a></h1>
            </div>
        </div>
    </div>
    <?php endif; ?>
    <div class="container">
        <div class="row">
            <div class="d-none d-xl-block col-xl-3 collapse">
                <?php
                if($navigation) {
                  $menu = $this->navigation()->menu();
                  $menu->setPartial('Bootstrap/Navigation/left.html.php');
                  echo $menu->render($navigation);
                }
                ?>
            </div>
            <div class="col-12 col-xl-9 mb-6 mb-xl-0">
                <div class="row">
                    <div class="col-12 col-lg-12 mb-6 mb-lg-0">
                        <?php echo $this->areablock('mainAreablock', [
                            "allowed"=> ["carousel","puff-block3333"],
                            "toolbar"=> 0,
                            "params" => [
                                "carousel" => [
                                    'subsiteClass' => 'subsite-item-height',
                                    'subsiteCaption' => 'subsite-caption'
                                ],
                                "puff-block3333" => [
                                    "itemsPerRow" => 3,
                                    'containerClass' => 'container mb-4 mt-2 mt-lg-4 px-0',
                                    'colClass' => 'col-12 col-sm-6 col-lg-4 col-xl-4'
                                ]
                            ]
                        ]); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
