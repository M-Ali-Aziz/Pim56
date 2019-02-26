<?php
/**
 * @var \Pimcore\Templating\PhpEngine $this
 * @var \Pimcore\Templating\PhpEngine $view
 * @var \Pimcore\Templating\GlobalVariables $app
 */
?>

<div class="bg-dark d-none d-lg-block">
    <div class="container-fluid mw-xl py-0">
        <nav class="navbar navbar-expand-md navbar-dark bg-dark font-size-sm p-0 text-white">
            <div class="collapse navbar-collapse nmx-2" id="navbarSupportedContent">
                <ul class="navbar-nav bd-navbar-nav flex-row">
                    <li class="nav-item"><a class="nav-link" href="<?php echo $this->translate('university_url'); ?>">Till <?php echo $this->translate('university_name'); ?></a></li>
                </ul>
                <ul class="navbar-nav flex-row ml-auto">
                    <li class="nav-item">
                        <a class="nav-link px-3" href="/student">Student</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link px-3" href="/naringsliv/alumni">Alumn</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link px-3" href="https://staff.lusem.lu.se">Medarbetare</a>
                    </li>
                </ul>
                <ul class="navbar-nav flex-row ml-5">
                    <li class="nav-item">
                        <a class="nav-link px-3" href="/biblioteket">Bibliotek</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link px-3" href="/karriarcenter">Karriärcenter</a>
                    </li>
                </ul>
            </div>
        </nav>
    </div>
</div>
<div class="border-bottom">
    <div class="container-fluid mw-xl">
        <div class="row m-0 py-3"><?php //tagit bort "py-lg-5" ?>
            <div class="col p-0">
                <div class="d-flex justify-content-between align-items-center h-100">
                    <div class="header-logo header-logo-lu flex-grow-1 flex-lg-grow-0">
                        <a href="/" title="Ekonomihögskolan | Lunds universitet">
                            <img src="/static/toolkit/images/logo/logo_ehl@1x.png" srcset="/static/toolkit/images/logo/logo_ehl@1x.png 1x, /static/toolkit/images/logo/logo_ehl@2x.png 2x" alt="Ekonomihögskolan | Lunds universitet" class="mw-100">
                        </a>
                    </div>
                    <div class="flex-shrink-1 flex-lg-shrink-0 flex-grow-0 d-flex flex-column justify-content-between h-100 mh-120">
                        <div class="h-lg-auto flex-column justify-content-between align-items-end font-size-sm font-size-sm-base flex-grow-0">
                            <nav class="nav text-center h-100 h-lg-auto align-items-center d-lg-none flex-nowrap">
                                <div class="nav-item">
                                    <a class="ml-2 p-1 d-block nav-undecorated" href="#header-search-form" data-toggle="collapse" aria-controls="header-search-form" aria-expanded="false" aria-label="Visa och dölj sökfölt"><i class="fal fa-search"></i><br>Sök</a>
                                </div>
                                <div class="nav-item">
                                    <a class="ml-2 p-1 d-block nav-undecorated" href="https://lusem.lu.se"><i class="fal fa-globe"></i><br>English</a>
                                </div>
                            </nav>
                            <div class="d-none d-lg-flex flex-column flex-xl-row w-100 justify-content-end">
                                <nav class="nav align-items-center justify-content-end flex-1 mb-3 mb-xl-0">
                                    <div class="nav-item flex-xl-grow-1">
                                        <form class="form-inline pr-xl-3" id="searchsiteform" action="<?php echo $this->searchUrl; ?>" method="get" accept-charset="UTF-8">
                                            <div class="input-group input-group-round input-group-sm w-100 flex">
                                                <input type="search" class="form-control form-control-sm border-right-0" id="searchsite" name="query" value="">
                                                <input id="searchsite_tab" type="hidden" name="tab" value="undefined">
                                                <input id="searchsite_page" type="hidden" name="page" value="1">
                                                <div class="input-group-append">
                                                    <button class="btn btn-primary px-2" type="submit" id="searchsite_submit">
                                                        <span class="mr-2"><?php echo $this->translate('search'); ?></span>
                                                        <i class="fal fa-search"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </nav>
                                <nav class="nav align-items-center justify-content-end">
                                    <div class="nav-item d-none d-lg-block">
                                        <a href="#" class="nav-link px-0 ml-4" onclick="toggleBar();" title="<?php echo $this->translate('browse_aloud'); ?>" id="bapluslogo" data-bapdf="372"><span class="mr-1"><i class="fal fa-lg fa-volume"></i></span>Lyssna</a>
                                    </div>
                                    <div class="nav-item">
                                        <a href="https://lusem.lu.se/" class="nav-link px-0 ml-4"><span class="mr-1"><i class="fal fa-lg fa-globe"></i></span>English</a>
                                    </div>
                                </nav>
                            </div>
                        </div>
                        <div class="row mt-6 d-none d-xl-block font-size-xl-lg font-weight-light"><?php //lagt till "mt-6" ?>
                            <?php echo $this->template('Bootstrap/Navigation/main.html.php', [
                              'domainname' => $this->website['domainname']
                              ]
                            );?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?= $this->template("Bootstrap/Navigation/mobile-mainnav.html.php", [
      'domainname' => $this->website['domainname']
    ]);?>
    <div class="header-search-form collapse collapse-lg pb-2 px-2" id="header-search-form">
        <form class="form-inline px-lg-3" id="searchsiteform" action="<?php echo $this->searchUrl; ?>" method="get" accept-charset="UTF-8">
            <div class="input-group input-group-round input-group-sm w-100 flex">
                <input type="search" class="form-control form-control-sm border-right-0" id="header-search-field-mobile" name="query" value="">
                <input id="searchsite_tab" type="hidden" name="tab" value="undefined">
                <input id="searchsite_page" type="hidden" name="page" value="1">
                <div class="input-group-append">
                    <button class="btn btn-primary px-2" type="submit" id="searchsite_submit">
                        <span class="mr-2"><?php echo $this->t('search'); ?></span>
                        <i class="fal fa-search"></i>
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
