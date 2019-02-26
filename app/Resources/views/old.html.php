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
<!DOCTYPE html>
<html lang="<?php echo $this->language; ?>">
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=Edge">
    <meta charset='UTF-8'>
    <link rel="apple-touch-icon" href="/static/images/favicons/apple-touch-icon.png" />
    <link rel="apple-touch-icon" sizes="76x76" href="/static/images/favicons/apple-touch-icon-76x76.png" />
    <link rel="apple-touch-icon" sizes="120x120" href="/static/images/favicons/apple-touch-icon-120x120.png" />
    <link rel="apple-touch-icon" sizes="152x152" href="/static/images/favicons/apple-touch-icon-152x152.png" />
    <link type="image/vnd.microsoft.icon" href="/static/images/favicons/favicon.ico" rel="shortcut icon" />
    <link media="all" href="/static/css/style.css" rel="stylesheet" type="text/css" />
    <?php if ($this->document->getProperty('LU') == 1 ) : ?>
    <link media="all" href="/static/css/handel.css" rel="stylesheet" type="text/css" />
    <?php else :  ?>
    <link media="all" href="/static/css/ehl.css" rel="stylesheet" type="text/css" />
    <?php endif; ?>
    <!--[if IE]>
    <link media="all" href="/css/ie.css" rel="stylesheet" type="text/css">
    <![endif]-->
    <link media="print" href="/static/css/print.css" rel="stylesheet" type="text/css" />
    <?php if( ! $this->editmode && ! $this->debugmode && ! $this->getParam("pimcore_preview")): ?>
    <script type="text/javascript">
      <!--//--><![CDATA[//><!--
      var _baLocale = "se", _baMode = " ";
      //--><!]]>
    </script>
    <script type="text/javascript" src="//www.browsealoud.com/plus/scripts/ba.js"></script>
    <?php endif; ?>
    <meta id="viewport" content="width=device-width, initial-scale=1" name="viewport">
    <?php
    $this->headTitle($this->document->getTitle())->setSeparator(" | ");
    $this->headTitle($this->website['name']);
    echo $this->headTitle();
    ?>
    <meta name="description" content="<?php echo $this->document->getDescription(); ?>">
    <?php 
      $this->meta(
        $this->headMeta(),
        (object)['twitter' => $this->twitter, 'opengraph' => $this->opengraph, 'googleplus' => $this->googleplus]
      );
    ?>
</head>
<body>
    <a id="scroll_to_top"></a>
    <?php if (!$this->editmode) : ?>
      <?= $this->template("Navigation/hamburger.html.php");?>
    <?php endif;?>
    <div id="page_wrapper" class="<?php echo $this->document->getProperty('templateType');?>">
        <div id="lu_header_wrapper">
          <div id="lu_header_content">
            <div id="lu_header" class="clearfix">
              <?= $this->template("Includes/header" . ucfirst($this->language) . ".html.php"); ?>
            </div>
          </div>
          <div id="lu_header_button_wrapper">
            <p id="lu_header_button" class="<?php echo $this->translate('language_shortcode'); ?>"><?php echo str_replace('http://www.','', $this->translate('university_url')); ?></p>
          </div>
        </div>
        <div id="lu_overlay" class="hide"></div>
        <div id="toolbar_wrapper">
          <div id="toolbar_content" class="container-31 clearfix">
            <nav id="toolbar_navigation_left">
              <ul>
                <li class="hide-xs"><a href="<?php echo $this->translate('university_url'); ?>"><?php echo $this->translate('university_name'); ?></a></li>
                <li class="show-xs <?php echo $this->translate('language_shortcode'); ?>" id="responsive-toolbar-logo"><a href="<?php echo $this->translate('university_url'); ?>"></a></li>
              </ul>
            </nav>
            <nav id="toolbar_navigation_right">
              <ul>
                <li class="hide-xs"><a href="#" onclick="toggleBar();" title="<?php echo $this->translate('browse_aloud'); ?>" class="logo" id="bapluslogo" data-bapdf="372"><?php echo $this->translate('browse_aloud'); ?></a></li>
                <li id="responsive-search" class="show-xs"><a>Sök</a></li>
                <?php if(count($this->website['languages']) > 1): ?>
                <li id="link-international" class="<?php echo $this->translate('language_shortcode'); ?>"><?php echo $this->languageSelector($this); ?></li>
                <?php endif; ?>
              </ul>
            </nav>
          </div>
        </div>
        <div id="responsive_search_wrapper">
            <form id="responsive_search" action="<?php echo $this->searchUrl; ?>" method="get" accept-charset="UTF-8">
                <input id="responsive_search_submit" type="submit" value="">
                <span id="responsive_search_span">
                    <span id="responsive_search_icon"></span>
                    <input id="responsive_search_tab" type="hidden" name="tab" value="customsites">
                    <input id="responsive_search_text" type="text" placeholder="<?php echo $this->translate('search'); ?>" name="query" value="" maxlength="128">
                    <input id="responsive_search_page" type="hidden" name="page" value="1">
                </span>
            </form>
        </div>
        <div id="header_wrapper" class="container-31 clearfix">
          <header id="header_content" class="grid-31 clearfix">
            <div id="header_titles" class="clearfix">
              <h1 id="main_title" class="<?php echo $this->subdomain ?>"><a href="<?php echo $this->website['baseuri']?>"><span><?php echo $this->website['title']?></span></a></h1>
              <h2 id="main_sub_title"><span><?php echo $this->website['subtitle']?></span></h2>
            </div>
            <div class="show-xs">
              <button id="hamburger-icon" type="button">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
              </button>
            </div>
            <?php if ($this->document->getProperty('LU') == 1 ) : ?>
              <a id="<?php echo ($this->language == 'sv') ? "header_logo" : "header_logo_en"; ?>" href="<?php echo $this->translate('university_url'); ?>"></a>
            <?php else :  ?>
              <a id="<?php echo ($this->language == 'sv') ? "header_logo" : "header_logo_en"; ?>" href="<?php echo $this->translate('site_url'); ?>"></a>
            <?php endif; ?>
            <?php if (($this->subdomain == 'ehl') || ($this->subdomain == 'lusem')) : ?>
              <?php
              echo $this->template('Navigation/targetgroups.html.php', [
                'pages' => $this->targetgroups,
                'language'  => $this->language
                ]
              );
              ?>
            <?php endif; ?>
          </header>
        </div>
      
        <div id="navigation_wrapper" class="container-31 hide-xs">
          <div id="navigation_content" class="grid-31">
            <?php if ($this->document->getProperty('DropdownMenu') == 1 AND !$this->editmode AND !$this->getParam("pimcore_preview")) : ?>
              <nav id="menuzord" class="menuzord grid-23 alpha">
                <?= $this->template("Navigation/dropdown.html.php");?>
              </nav>
            <?php else: ?>
              <nav id="main_navigation" class="grid-23 alpha">
                <?php echo $this->template('Navigation/main.html.php', [
                  'pages' => $this->mainMenu
                  ]
                );?>
              </nav>
            <?php endif; ?>
            <div id="searchshortcuts" class="grid-8 omega">
                <div id="search">
                    <form id="searchsiteform" action="<?php echo $this->searchUrl; ?>" method="get" accept-charset="UTF-8">
                        <input id="searchsite_submit" type="submit" value="<?php echo $this->translate('search'); ?>">
                        <input id="searchsite_tab" type="hidden" name="tab" value="undefined">
                        <input id="searchsite" type="text" name="query" value="">
                        <input id="searchsite_page" type="hidden" name="page" value="1">
                    </form>
                </div>
            </div>
          </div>
        </div>

        <?php if($this->breadcrumbs): ?>
        <div id="breadcrumb_wrapper" class="container-31 clearfix">
          <nav id="breadcrumb_content" class="grid-31">
            <ul class="clearfix">
              <?= $this->template("Navigation/breadcrumb.html.php");?>
            </ul>
          </nav>
        </div>
        <?php endif; ?>

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
                  <?php endif; ?>
                  <?php if ($this->document->getProperty('tabs') == 1 ) : ?>
                    <?php
                    if($navigation) {
                      $menu = $this->navigation()->menu();
                      $menu->setPartial('Navigation/tabs.html.php');
                      echo $menu->render($navigation);
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
                    $menu = $this->navigation()->menu();
                    $menu->setPartial('Navigation/left.html.php');
                    echo $menu->render($navigation);
                  }
                ?>
                <?php $this->slots()->output('_content'); ?>
            </div>
            </div>
          <?php endif; ?>

          <div id="footer_wrapper">
              <div id="footer_content" class="container-31">
                  <h2 class="hide">Sidöversikt</h2>
                  <div class="columns clearfix">
                  <?php if (($this->language == 'sv') && ($this->document->getProperty('LU') != 1 )) : ?>
                    <?= $this->template("Includes/sitemap.html.php"); ?>
                  <?php endif; ?>
                  </div>
                  <div id="footer_logo_information_wrapper" class="clearfix">
                      <div id="<?php echo ($this->language == 'sv') ? "footer_logo" : "footer_logo_en"; ?>"></div>
                      <?php
                          $height = 'min-height:117px;';
                          if($this->document->getProperty('LU') == 1) $height = 'min-height:125px;';
                          if($this->language == 'en') $height = 'min-height:105px;';
                      ?>
                      <div id="contact_information_wrapper" style="<?php echo $height; ?>">
                          <div id="contact_information">
                              <p class="nbm">
                              <?php echo str_replace("\n", "<br>", $this->website['name'])  ; ?><br>
                              <?php echo $this->website['adress']; ?><br>
                              <?php echo $this->translate('phone'); ?>: <?php echo $this->phoneNumber($this->website['phone']); ?><br>
                              <?php if ($this->website['mail']) : ?>
                                <a href="mailto:<?php echo $this->website['mail']; ?>"><?php echo $this->website['mail']; ?></a><br>
                              <?php endif;?>
                              <?php if($this->website['siteInfo']['uri']): ?>
                                <a href="<?php echo $this->website['siteInfo']['uri']; ?>"><?php echo $this->website['siteInfo']['label']; ?></a>
                              <?php endif; ?>
                              </p>
                          </div>
                      </div>
                  </div>
                  <div id="footer_extra_logos" class="clearfix">
                    <?php if ($this->document->getProperty('LU') == 1 ) : ?>
                      <a id="footer_hur" href="http://www.handelsradet.nu" title="Handelsrådet"></a>
                    <?php else :  ?>
                      <a id="footer_equis" href="http://www.efmd.org" title="Accredited by EQUIS"></a>
                    <?php endif; ?>
                    <a id="footer_leru" href="https://www.leru.org"></a>
                    <a id="footer_u21" href="https://www.universitas21.com"></a>
                  </div>
            </div>
        </div>
    </div>
    <script src="/static/js/lu.js"></script>
    <!--[if lt IE 9]>
    <script src="/static/js/html5shiv-printshiv.js"></script>
    <![endif]-->
</body>
</html>
