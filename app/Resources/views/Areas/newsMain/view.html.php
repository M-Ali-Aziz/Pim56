<?php
/**
 * @var \Pimcore\Templating\PhpEngine $this
 * @var \Pimcore\Templating\PhpEngine $view
 * @var \Pimcore\Templating\GlobalVariables $app
 */
?>

<?php
$language = $this->document->getProperty("language");
$uri = ($language == 'sv') ? '/nyheter/' : '/news/';
$baseUri = ($this->baseuri == '/') ? '' : $this->baseuri;
$uri = $baseUri . $uri;
?>

<?php if ($this->document->getProperty('bootstrap')) : ?>
    <?php $language = $this->document->getProperty("language")?>
    <?php $paging = ($this->paging)? 'paginator' : 'newsList'?>
    <?php if($this->newsList) : ?>
        <div class="row">
            <div class="col">
                <h2 class="my-0 pb-2 border-bottom"><?php echo $this->heading; ?></h2>
            </div>
        </div>
        <div class="row">
            <div class="col">
            <?php foreach($this->$paging as $item) :?>
                <?php
                $locale = ($item->getRubrik($language)) ? $language : false;
                if (empty($locale)) {
                    $locale = ($language == 'sv') ? 'en' : false;
                }
                ?>
                <?php if ($locale) : ?>
                    <a href="<?php echo $uri?><?php echo $item->getKey()?>" class="card card-item nav-block card-item-lined nav-block-hover-plaster-25 px-2">
                        <div class="card-body">
                            <div class="meta">
                                <date class="meta-date"><?php echo date("Y-m-d", $item->getCreationDate())?></date>
                                <span class="meta-category"><?php echo $item->getCategory() ? $this->translate($item->getCategory()) : ''; ?></span>
                            </div>
                            <h3 class="nav-block-link mt-0 mb-2 h4"><?php echo $item->getRubrik($locale)?></h3>
                        </div>
                    </a>
                <?php endif;?>
            <?php endforeach;?>
            </div>
        </div>

    <?php else : ?>
        <?php if ($language == 'sv') : ?>
            <p>Det finns för närvarande inga nyhetsartiklar!</p>
        <?php else : ?>
            <p>There are currently no news articles!</p>
        <?php endif;?>
    <?php endif;?>

    <?php if($this->paging) : ?>
        <?php
        try {
            echo $this->render(
                "Bootstrap/Navigation/pagination.html.php",
                array(
                    'paginatorPages' => $this->paginator->getPages("Sliding"),
                    'urlprefix' => $this->document->getFullPath() . '?page=',
                    'appendQueryString' => true
                )
            );
        }
        catch (\Exception $e) {
            echo $e->getMessage();
        }
        ?>
    <?php endif;?>
<?php else: ?>
    <?php $language = $this->document->getProperty("language")?>
    <?php $paging = ($this->paging)? 'paginator' : 'newsList'?>
    <?php if($this->newsList) : ?>
        <table class="no-border" width="432px">
            <?php foreach($this->$paging as $item) :?>
                <?php
                $locale = ($item->getRubrik($language)) ? $language : false;
                if (empty($locale)) {
                    $locale = ($language == 'sv') ? 'en' : false;
                }
                ?>
                <?php if ($locale) : ?>
                    <tr>
                        <td width="70px">
                            <?php echo date("Y-m-d", $item->getCreationDate())?>
                        </td>
                        <td>
                            <a href="<?php echo $uri?><?php echo $item->getKey()?>"><?php echo $item->getRubrik($locale)?></a>
                        </td>
                    </tr>
                <?php endif;?>
            <?php endforeach;?>
        </table>

    <?php else : ?>
        <?php if ($language == 'sv') : ?>
            <p>Det finns för närvarande inga nyhetsartiklar!</p>
        <?php else : ?>
            <p>There are currently no news articles!</p>
        <?php endif;?>
    <?php endif;?>

    <?php $paginationViewPath = (($this->document->getProperty("bootstrap")) ? 'Bootstrap/Navigation/pagination.html.php' : 'Navigation/pagination.html.php'); ?>

    <?php if($this->paging) : ?>
        <?php
        try {
            echo $this->render(
                "$paginationViewPath",
                array(
                    'paginatorPages' => $this->paginator->getPages("Sliding"),
                    'urlprefix' => $this->document->getFullPath() . '?page=',
                    'appendQueryString' => true
                )
            );
        }
        catch (\Exception $e) {
            echo $e->getMessage();
        }
        ?>
    <?php endif;?>
<?php endif; ?>
