<?php
/**
* @var \Pimcore\Templating\PhpEngine $this
* @var \Pimcore\Templating\PhpEngine $view
* @var \Pimcore\Templating\GlobalVariables $app
*/
?>

<?php
//$language = $this->document->getProperty("language");
$link = $this->href("link");
$language = $this->document->getProperty("language");
$uri = ($language == 'sv') ? '/nyheter/' : '/news/';
$baseUri = ($this->baseuri == '/') ? '' : $this->baseuri;
$uri = $baseUri . $uri;
?>

<?php if ($this->document->getProperty('bootstrap')) : ?>
    <?php if($this->newsList) : ?>
    <div class="row">
        <div class="col">
            <h2 class="my-0 pb-2 border-bottom"><?php echo $this->heading; ?></h2>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <?php foreach($this->newsList as $item) :?>
                <?php
                $locale = ($item->getRubrik($language)) ? $language : false;
                if (empty($locale)) {
                    $locale = ($language == 'sv') ? 'en' : false;
                }
                ?>
                <?php if ($locale) : ?>
            <a href="<?php echo $uri?><?php echo $item->getKey()?>" class="card card-item nav-block bg-transparent card-item-lined nav-block-hover-plaster-25 px-2 flex-column flex-md-row" title="<?php echo $item->getRubrik($locale)?>">
                <div class="card-body">
                    <div class="meta ">
                        <date class="meta-date"><?php echo date("Y-m-d", $item->getCreationDate())?></date>
                        <span class="meta-category"><?php echo $item->getCategory() ? $this->translate($item->getCategory()) : ''; ?></span>
                    </div>
                    <h3 class="nav-block-link mt-0 mb-2"><?php echo $item->getRubrik($locale)?></h3>
                    <p><?php echo $this->summary($item->getIngress(), $this->sammanfattning)?></p>
                </div>
            </a>
        <?php endif;?>
    <?php endforeach;?>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <div class=" mt-5 text-right font-weight-normal">
                <a href="<?php echo $link?>" class="nav-undecorated"><?php echo $this->translate('more news'); ?>&nbsp;<i class="fal fa-chevron-circle-right  fa-lg"></i>
                </a>
            </div>

        </div>
    </div>
    <?php else : ?>
        <?php if ($language == 'sv') : ?>
            <p>Det finns för närvarande inga nyhetsartiklar!</p>
        <?php else : ?>
            <p>There are currently no news articles!</p>
        <?php endif;?>
    <?php endif;?>
<?php else : ?>
    <?php if($this->newsList) : ?>
        <div class="news-wrapper news-vertical <?php echo $this->color; ?>">
            <h2><a href="<?php echo $link?>"><?php echo $this->heading; ?></a></h2>
            <?php foreach($this->newsList as $item) :?>
                <?php
                $locale = ($item->getRubrik($language)) ? $language : false;
                if (empty($locale)) {
                    $locale = ($language == 'sv') ? 'en' : false;
                }
                ?>
                <?php if ($locale) : ?>
                    <div class="news-item">
                        <p class="news-date-category">
                            <span class="news-date"><?php echo date("Y-m-d", $item->getCreationDate())?></span>
                            <span class="news-category"><?php echo $item->getCategory() ? $this->translate($item->getCategory()) : ''; ?></span>
                        </p>
                        <p class="news-title"><a href="<?php echo $uri?><?php echo $item->getKey()?>"><?php echo $item->getRubrik($locale)?></a></p>
                        <p class="news-lead"><?php echo $this->summary($item->getIngress(), $this->sammanfattning)?></p>
                    </div>
                <?php endif;?>
            <?php endforeach;?>
            <p class="archive_link"><a href="<?php echo $link?>"><?php echo $this->translate('more news'); ?><span class="archive_icon"></span></a></p>
        </div>
    <?php else : ?>
        <?php if ($language == 'sv') : ?>
            <p>Det finns för närvarande inga nyhetsartiklar!</p>
        <?php else : ?>
            <p>There are currently no news articles!</p>
        <?php endif;?>
    <?php endif;?>
<?php endif; ?>
