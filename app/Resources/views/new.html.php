<?php
/**
 * @var \Pimcore\Templating\PhpEngine $this
 * @var \Pimcore\Templating\PhpEngine $view
 * @var \Pimcore\Templating\GlobalVariables $app
 */
?>

<?php
  $navigation = ($nsn = $this->getProperty('navStartNode')) ?
      $this->navigation()->buildNavigation($this->document, $nsn, "") : null;
?>

<!doctype html>
<html lang="<?php echo $this->language; ?>">
<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php
    if (!$this->editHeadTitle) {
        $this->headTitle($this->document->getTitle())->setSeparator(" | ");
        $this->headTitle($this->website['name']);
        echo $this->headTitle();
    } else {
        $this->headTitle($this->document->getTitle(). ": ");
        $this->headTitle($this->title . " | ");
        $this->headTitle($this->website["name"]);
        echo $this->headTitle();
    }
    ?>
    <meta name="description" content="<?php echo $this->document->getDescription(); ?>">
    <?php
      $this->meta(
        $this->headMeta(),
        (object)['twitter' => $this->twitter, 'opengraph' => $this->opengraph, 'googleplus' => $this->googleplus]
      );
    ?>
    <link rel="stylesheet" href="/static/toolkit/styles/main.css">
    <link rel="stylesheet" href="/static/toolkit/styles/ehl.css">
    <link rel="apple-touch-icon" sizes="180x180" href="/static/toolkit/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/static/toolkit/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/static/toolkit/favicon-16x16.png">
    <link rel="manifest" href="/static/toolkit/site.webmanifest">
    <link rel="mask-icon" href="/static/toolkit/safari-pinned-tab.svg" color="#875e29">
    <!-- /toolkit styles -->
    <?php if( !$this->editmode && !$this->getParam("pimcore_preview")): ?>
        <script type="text/javascript">
          <!--//--><![CDATA[//><!--
          var _baLocale = "se", _baMode = " ";
          //--><!]]>
        </script>
        <script type="text/javascript" src="//www.browsealoud.com/plus/scripts/ba.js"></script>
    <?php endif; ?>

    <link href="https://fonts.googleapis.com/css?family=Hind:300,400,600" rel="stylesheet">
</head>
<body>

    <header class="header nav-undecorated">
        <?php if ($this->language == 'sv'): ?>
            <?= $this->template("Bootstrap/Includes/headerSV.html.php"); ?>
        <?php else: ?>
            <?= $this->template("Bootstrap/Includes/headerEN.html.php"); ?>
        <?php endif; ?>
    </header>

    <?php if($this->breadcrumbs): ?>
    <div class="container pt-2 pt-lg-3">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb m-0 p-0 mb-0 cmb-0 font-size-sm bg-transparent">
                <?= $this->template("Bootstrap/Navigation/breadcrumb.html.php");?>
            </ol>
        </nav>
    </div>
    <?php endif; ?>

    <?php if($this->startsite): ?>
    <main role="main" class="">
        <!-- MOBILE MENU  -->
        <?php echo $this->template("Bootstrap/Navigation/mobile-menu.html.php");?>
        <?php $this->slots()->output('_content'); ?>
    </main>

    <?php elseif($this->course): ?>
    <main role="main">
        <!-- MOBILE MENU  -->
        <?php echo $this->template("Bootstrap/Navigation/mobile-menu.html.php");?>
        <?php $this->slots()->output('_content'); ?>
    </main>

    <?php elseif($this->extended): ?>
        <!-- MOBILE MENU  -->
        <?php echo $this->template("Bootstrap/Navigation/mobile-menu.html.php");?>
        <?php $this->slots()->output('_content'); ?>

    <?php elseif($this->tabs): ?>
        <!-- MOBILE MENU  -->
        <?php echo $this->template("Bootstrap/Navigation/mobile-menu.html.php");?>
        <?php $this->slots()->output('_content'); ?>

    <?php elseif($this->landing): ?>
        <!-- MOBILE MENU  -->
        <?php echo $this->template("Bootstrap/Navigation/mobile-menu.html.php");?>
        <?php $this->slots()->output('_content'); ?>

    <?php elseif($this->subsite): ?>
        <!-- MOBILE MENU  -->
        <?php echo $this->template("Bootstrap/Navigation/mobile-menu.html.php");?>
        <?php $this->slots()->output('_content'); ?>

    <?php elseif($this->solr): ?>
        <!-- MOBILE MENU  -->
        <?php echo $this->template("Bootstrap/Navigation/mobile-menu.html.php");?>
        <?php $this->slots()->output('_content'); ?>

    <?php else : ?>
    <main class="main">
        <!-- MOBILE MENU  -->
        <?php echo $this->template("Bootstrap/Navigation/mobile-menu.html.php");?>
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
                    <?php $this->slots()->output('_content'); ?>
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
    <?php endif; ?>

    <div class="bg-dark text-dark-25 pt-6 overflow-x-hidden">
        <div class="container my-0 mx-auto px-2">
            <div class="row justify-content-center border-bottom border-white mx-1 mx-lg-0 pb-4 nav-collapse font-size-sm mx-0 mx-lg-auto">
                <?php if ($this->language == 'sv'): ?>
                    <?= $this->template("Bootstrap/Includes/sitemapSV.html.php"); ?>
                <?php else: ?>
                    <?= $this->template("Bootstrap/Includes/sitemapEN.html.php"); ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <footer class="footer">
        <?php if ($this->language == 'sv'): ?>
            <?= $this->template("Bootstrap/Includes/footerSV.html.php"); ?>
        <?php else: ?>
            <?= $this->template("Bootstrap/Includes/footerEN.html.php"); ?>
        <?php endif; ?>
    </footer>


<script src="/static/toolkit/scripts/bootstrap.js" defer></script>
<script src="/static/toolkit/scripts/main.js" defer></script>
<script src="/static/toolkit/scripts/fontawesome.js" defer></script>
<?php if ($this->editmode): ?>
<!-- Pimcore_Areablock_Toolbar Fix -->
<script>$( ".pimcore_area_buttons" ).addClass( "top" );</script>
<?php endif ?>
<!-- /toolkit scripts -->
</body>
</html>
