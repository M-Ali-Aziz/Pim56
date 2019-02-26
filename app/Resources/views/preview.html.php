<?php
/**
 * @var \Pimcore\Templating\PhpEngine $this
 * @var \Pimcore\Templating\PhpEngine $view
 * @var \Pimcore\Templating\GlobalVariables $app
 */
?>
<?php if ($this->document->getProperty('NewTemplate') == 1 ) : ?>
<?php //Förberedelse för ny mall ?>
<?php else :  ?>
<?php
  $navigation = ($nsn = $this->getProperty('navStartNode')) ?
      $this->navigation()->BuildNavigation($this->document, $nsn, "") : null;
?>
<!DOCTYPE html>
<html lang="<?php echo $this->language; ?>">
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=Edge" />
    <meta charset='UTF-8'/>
    <link rel="apple-touch-icon" href="/static/images/favicons/apple-touch-icon.png">
    <link rel="apple-touch-icon" sizes="76x76" href="/static/images/favicons/apple-touch-icon-76x76.png">
    <link rel="apple-touch-icon" sizes="120x120" href="/static/images/favicons/apple-touch-icon-120x120.png">
    <link rel="apple-touch-icon" sizes="152x152" href="/static/images/favicons/apple-touch-icon-152x152.png">
    <link type="image/vnd.microsoft.icon" href="/static/images/favicons/favicon.ico" rel="shortcut icon">
    <link media="all" href="/static/css/style.css" rel="stylesheet" type="text/css">
    <?php if ($this->document->getProperty('LU') == 1 ) : ?>
    <link media="all" href="/static/css/handel.css" rel="stylesheet" type="text/css">
    <?php else :  ?>
    <link media="all" href="/static/css/ehl.css" rel="stylesheet" type="text/css">
    <?php endif; ?>
    <!--[if IE]>
    <link media="all" href="/css/ie.css" rel="stylesheet" type="text/css">
    <![endif]-->
    <meta id="viewport" content="width=device-width, initial-scale=1" name="viewport">
    <?php
    $this->headTitle($this->document->getTitle())->setSeparator(" | ");
    $this->headTitle($this->website['name']);
    echo $this->headTitle();
    ?>
    <?php echo $this->headMeta(); ?>
    <meta name="description" content="<?php echo $this->document->getDescription(); ?>">
</head>
<body>
    <?php if ($this->document->getProperty('DropdownMenu') == 1 AND (!$this->document->getProperty('LeftNav') == 1)) : ?>
    <!-- Tabbade sidor på lusem.lu.se -->
    <div id="content_wrapper" class="container-31 clearfix tabs">
        <?php if ($this->document->getProperty('section')) : ?>
        <div id="page_header" class="grid-31 bg_green">
          <div class="subsite">
            <a href="<?php echo ($this->getProperty('navStartNode')); ?>"><?php echo ($this->document->getProperty('section')); ?></a>
          </div>
        </div>
        <?php endif; ?>
        <div <?php echo (!$this->startsite) ? "id='content'" : ""; ?> class="grid-31 clearfix">
            <div id="text_wrapper" class="grid-31 alpha omega">
              <?php if ($this->document->getProperty('tabPageTitle') == 1) : ?>
                <header id="page-title">
                  <h1><?php echo ($this->document->getProperty('tabTitle')); ?></h1>
                  <h2><?php echo ($this->document->getProperty('tabSubTitle')); ?></h2>
                </header>
              <?php else: ?>
              <?php if ($this->document->getProperty('tabs') == 1 ) : ?>
                <?php
                if($navigation) {
                  // $this->navigation()->menu()->setUseTranslator(false);
                  echo $this->navigation()->menu()
                  ->setPartial(array('Navigation/tabs.html.php', 'website'))
                  ->renderMenu($navigation);
                }
                ?>
              <?php endif; ?>
              <?php $this->slots()->output('_content'); ?>
            </div>
        </div>
    </div>
    <?php else: ?>
    <!-- Vanliga startsidor och undersidor -->
    <div id="content_wrapper" class="container-31 clearfix">
        <?php if ($this->document->getProperty('section')) : ?>
        <div id="page_header" class="grid-31 bg_green">
          <div class="subsite">
            <a href="<?php echo ($this->getProperty('navStartNode')); ?>"><?php echo ($this->document->getProperty('section')); ?></a>
          </div>
        </div>
        <?php endif; ?>
        <div <?php echo (!$this->startsite) ? "id='content'" : ""; ?> class="grid-31 clearfix">
          <?php
          if($navigation) {
            // $this->navigation()->menu()->setUseTranslator(false);
            $menu = $this->navigation()->menu();
            $menu->setPartial('Navigation/left.html.php');
            echo $menu->render($navigation);
          }
          ?>
          <?php $this->slots()->output('_content'); ?>
        </div>
    </div>
    <?php endif; ?>
</body>
</html>
<?php endif; ?>
