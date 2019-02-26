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
    .pimcore_block_button_up, .pimcore_block_button_down {display:none !important;}
    .pimcore_open_link_button {display:none !important;}
    #pimcore_editable_rightAreablock .pimcore_area_edit_button,
    #pimcore_editable_mainAreablock .pimcore_area_edit_button {z-index: 99;}
    .x-window .pimcore_tag_input {border: 1px solid #dedbd9;}
    .info {font-weight:700;margin:0;}
    .margins {margin:8px 0 0 0;}
    .embed-responsive {z-index:1;}
    .pimcore_area_entry {margin-bottom: 40px!important;}
    #pimcore_editable_lead {font-family: Georgia,serif; font-size: 1.3125rem; margin-bottom: 2rem;}
    .main{overflow:visible;}
    .pimcore_area_buttons {display: block;visibility: visible !important;}
</style>
<?php endif; ?>

<?php
$navigation = ($nsn = $this->getProperty('navStartNode')) ?
  $this->navigation()->buildNavigation($this->document, $nsn, "") : null;

$heroSrc = ($this->getProperty('tabHero')) ? $this->getProperty('tabHero')->getPath() . $this->getProperty('tabHero')->getFilename() : null;
?>

<div class="container pt-2 pt-lg-3">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb m-0 p-0 mb-0 cmb-0 font-size-sm bg-transparent">
            <?= $this->template("Bootstrap/Navigation/breadcrumb.html.php");?>
        </ol>
    </nav>
</div>

<main role="main" class="my-4">
    <div class="container">
        <div class="row my-3">
            <div class="col-12">
                <div class="hero hero-img">
                    <div class="img-bg">
                        <?php if ($heroSrc) { ?>
                        <div class="img-bg">
                            <img src="<?= $heroSrc; ?>" alt="">
                        </div>
                        <?php } ?>
                        <?php if ($this->getProperty('tabTitle')) { ?>
                        <div class="hero-title">
                            <h1><?= $this->getProperty('tabTitle'); ?></h1>
                            <?php if ($this->getProperty('tabSubTitle')) { ?>
                            <P><?= $this->getProperty('tabSubTitle'); ?></P>
                            <?php  } ?>
                        </div>
                        <?php  } ?>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
            <?php if($navigation) {
                $menu = $this->navigation()->menu();
                $menu->setPartial('Bootstrap/Navigation/tabs.html.php');
                echo $menu->render($navigation);
            } ?>
            </div>
        </div>

        <div class="tab-content my-5">
            <div class="row">
                <div class="col-12 col-lg-8 mb-lg-5">
                    <div class="row">
                        <div class="col-12 col-lg-10 offset-lg-1">
                        <?php if ($this->document->getProperty('tabPageTitle')) : ?>
                            <?php if($this->editmode) : ?>
                                <?php echo "<h2>" . $this->input("title") . "</h2>"; ?>
                                <?php echo "<p class='lead'>" . $this->textarea("lead") . "</p>"; ?>
                            <?php else : ?>
                                <?php echo (!$this->input("title")->isEmpty()) ? "<h2>" . $this->input("title") . "</h2>" : "" ; ?>
                                <?php echo (!$this->textarea("lead")->isEmpty()) ? "<p class='lead'>" . $this->textarea("lead") . "</p>" : "" ; ?>
                            <?php endif; ?>
                        <?php endif; ?>
                        <?php echo $this->areablock('mainAreablock',[
                            "allowed"=>["wysiwyg","image","blockquote","snippet","youtube","accordion","toggle-portrait","toggle-content","rss","news","newsMain","video", "eventlistMain", "heading"],
                            "sorting"=>["wysiwyg","image","blockquote","snippet","youtube","accordion","toggle-portrait","toggle-content","rss","news","newsMain","video", "eventlistMain", "heading"],
                            "params" => [
                                "news" => ['baseuri' => $this->website['baseuri']],
                                "newsMain" => ['baseuri' => $this->website['baseuri']],
                                "eventlistMain" => ['baseuri' => $this->website['baseuri']],
                                "toggle-content" => ["forceEditInView" => true],
                                "toggle-portrait" => ["forceEditInView" => true]
                            ]
                        ]);?>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-lg-4 col-xl-3 offset-xl-1">
                    <?php echo $this->areablock('rightAreablock',[
                        "allowed"=> ["wysiwyg","image","infobox","puff","quickfacts","blockquote","uid","snippet","youtube","rss","news","heading"],
                        "sorting"=> ["wysiwyg","image","infobox","puff","quickfacts","blockquote","uid","snippet","youtube","rss","news","heading"],
                        "params" => [
                            "news" => ['baseuri' => $this->website['baseuri']],
                            "eventlist" => ['baseuri' => $this->website['baseuri']]
                        ]
                    ]);?>
                </div>
            </div>
            <?php if (!$this->document->getProperty('DontShowPageManager')) : ?>
            <div class="row">
                <div class="col-12 col-lg-8">
                    <?php echo $this->template("Bootstrap/Includes/byline.html.php"); ?>
                </div>
            </div>
            <?php endif; ?>
        </div>
    </div>
</main>
<div>
    <div class="row">
        <div class="col-12">
            <?php echo $this->areablock('footerAreablock', [
                "allowed"=> ["cards-block","news-block","events-block", "infographics-class","puff-block3333"],
                "sorting"=> ["cards-block","news-block","events-block", "infographics-class","puff-block3333"],
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
                        'containerClass' => 'container mb-5 mt-4 mt-lg-8',
                        'colClass' => 'col-12 col-sm-6 col-lg-4 col-xl-3 mb-5'
                    ]
                ]
            ]); ?>
        </div>
    </div>
</div>
