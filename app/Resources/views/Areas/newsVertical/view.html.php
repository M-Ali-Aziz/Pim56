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

<?php $language = $this->document->getProperty("language"); ?>
<?php if($this->newsList && $this->newsList) : ?>
    <div class="news-wrapper news-horizontal news-large">
        <div class="news-main-title <?php echo $this->color; ?> clearfix">
            <h2><a href="<?php echo $uri?>"><?php echo $this->translate('news'); ?></a></h2>
            <p class="archive_link"><a href="<?php echo $uri; ?>"><?php echo $this->translate('more news'); ?><span class="archive_icon"></span></a></p>
        </div>

        <div class="news-items <?php echo $this->color; ?> clearfix">
            <?php
            $count = 0;
            foreach($this->newsList as $item) :
                $locale = ($item->getRubrik($language)) ? $language : false;
                if (empty($locale)) {
                    $locale = ($language == 'sv') ? 'en' : false;
                }
                ?>
                <?php if( ! $this->newsTop || ($count>0 && $locale)): ?>
                    <?php if($this->newsTop && $count==1): ?>
                        <div class="news-bottom">
                    <?php endif; ?>
                    <?php
                        $class = $this->grid;
                        // center-(left|right) class..
                        switch($count-(int)$this->newsTop):
                            case 1:
                                $class .= ' center' . (($this->itemsPerRow>3) ? '-left' : '');
                                break;
                            case 2:
                                $class .= ($this->itemsPerRow>3) ? ' center-right' : '';
                                break;
                        endswitch;
                    ?>
                        <div class="news-item <?php echo $class; ?>">
                            <p class="news-date-category">
                                <span class="news-date"><?php echo date("Y-m-d", $item->getCreationDate()); ?></span>
                                <span class="news-category"><?php echo $item->getCategory() ? $this->translate($item->getCategory()) : ''; ?></span>
                            </p>
                            <p class="news-title"><a href="<?php echo $uri?><?php echo $item->getKey(); ?>"><?php echo $item->getRubrik($locale); ?></a></p>
                            <p class="news-lead"><?php echo $this->summary($item->getIngress(), $this->sammanfattning); ?></p>
                        </div>
                <?php elseif($locale): ?>
                    <div class="news-top clearfix">
                        <div class="news-top-left grid-14 alpha">
                            <p class="news-date-category">
                                <span class="news-date"><?php echo date("Y-m-d", $item->getCreationDate()); ?></span>
                                <span class="news-category"><?php echo $item->getCategory() ? $this->translate($item->getCategory()) : ''; ?></span>
                            </p>
                            <p class="news-title">
                                <a href="<?php echo $uri; ?><?php echo $item->getKey(); ?>"><?php echo $item->getRubrik($locale); ?></a>
                            </p>
                        </div>
                        <div class="news-top-right grid-14 omega">
                            <p class="news-lead"><?php echo $this->summary($item->getIngress(), 255, ''); ?> <a href="<?php echo $uri?><?php echo $item->getKey(); ?>" class="news-readmore">[...]</a></p>
                        </div>
                    </div>
                <?php endif;?>
            <?php $count++; endforeach;?>
            <?php if($this->newsTop): ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
<?php else : ?>
    <p><?php echo $this->translate('no news'); ?>!</p>
<?php endif;?>
