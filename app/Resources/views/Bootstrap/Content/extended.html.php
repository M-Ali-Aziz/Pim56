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

.pimcore_open_link_button {display:none !important;}
#pimcore_editable_rightAreablock .pimcore_area_edit_button,
#pimcore_editable_mainAreablock .pimcore_area_edit_button {z-index: 99;}
.x-window .pimcore_tag_input {border: 1px solid #dedbd9;}
.info {font-weight:700;margin:0;}
.margins {margin:8px 0 0 0;}
.embed-responsive {z-index:1;}
.pimcore_area_entry {margin: 60px 0 40px!important;}
.main{overflow:visible;}
.pimcore_area_buttons {display: block;visibility: visible !important;}
</style>
<?php endif; ?>

<?php
$navigation = ($nsn = $this->getProperty('navStartNode')) ?
$this->navigation()->buildNavigation($this->document, $nsn, "") : null;
$hero = ($this->getProperty('Hero')) ? $this->getProperty('Hero')->getPath() . $this->getProperty('Hero')->getFilename() : null;
?>

    <div class="row">
        <div class="col-12">
            <?php if ($hero) : ?>
                <div class="hero hero-img">
                    <div class="img-bg">
                        <div class="img-bg">
                            <img src="<?= $hero; ?>" alt="">
                        </div>
                    </div>
                </div>
            <?php else : ?>
                <?php echo $this->areablock('headerAreablock', [
                    "allowed"=> ["carousel"]]); ?>
            <?php endif; ?>
        </div>
    </div>

    <div class="container pt-2 pt-lg-3">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb m-0 p-0 mb-0 cmb-0 font-size-sm bg-transparent">
                <?= $this->template("Bootstrap/Navigation/breadcrumb.html.php");?>
            </ol>
        </nav>
    </div>

    <main role="main" class="my-4 my-lg-8">
        <?php if ($this->document->getProperty('section')) : ?>
        <div class="container nmt-6">
            <div class="row p-3">
                <div class="col p-4 bg-plaster-25">
                    <h1 class="h3 my-0"><a href="<?php echo ($this->getProperty('navStartNode')); ?>"><?php echo ($this->document->getProperty('section')); ?></a></h1>
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
                        <div class="col-12 col-lg-8 mb-6 mb-lg-0">
                            <article>
                                <?php if($this->editmode) : ?>
                                    <h1><?php echo $this->input("title"); ?></h1>
                                    <div class="nmt-3 mb-3">
                                    	<?= $this->input("kicker", ["class" => 'text-uppercase mt-0']); ?>
                                    </div>
                                    <?= $this->textarea("lead", ["class" => 'lead']); ?>
                                <?php else : ?>
                                    <?php if (!$this->input("title")->isEmpty()) : ?>
                                        <h1><?php echo $this->input("title"); ?></h1>
                                    <?php endif; ?>
                                    <?php if (!$this->input("kicker")->isEmpty()) : ?>
                                        <div class="nmt-3 mb-3">
                                        	<p class="text-uppercase mt-0"><strong><?php echo $this->input("kicker"); ?></strong></p>
                                        </div>
                                    <?php endif; ?>
                                    <?php if (!$this->textarea("lead")->isEmpty()): ?>
                                        <p class='lead'><?php echo $this->textarea("lead"); ?></p>
                                    <?php endif; ?>
                                <?php endif; ?>
                                <?php echo $this->areablock('mainAreablock', [
                                    "allowed"=> ["wysiwyg","image","blockquote","infobox","snippet","youtube","snippet","youtube","accordion","toggle-portrait","toggle-content","rss","newsMain","eventlist","heading"],
                                    "sorting"=> ["wysiwyg","image","blockquote","infobox","snippet","youtube","snippet","youtube","accordion","toggle-portrait","toggle-content","rss","newsMain","eventlist","heading"],
                                    "params" => [
                                        "newsMain" => ['baseuri' => $this->website['baseuri']],
                                        "toggle-content" => ["forceEditInView" => true],
                                        "toggle-portrait" => ["forceEditInView" => true]
                                    ]
                                ]);?>
                            </article>
                        </div>
                        <div class="col-12 col-lg-4">
                            <?php echo $this->areablock('rightAreablock', [
                                "allowed"=> ["wysiwyg","image","infobox","puff","uid","snippet","youtube","rss","news","heading","quickfacts","blockquote"],
                                "sorting"=> ["wysiwyg","image","infobox","puff","uid","snippet","youtube","rss","news","heading","quickfacts","blockquote"],
                                "params" => [
                                    "news" => ['baseuri' => $this->website['baseuri']],
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
