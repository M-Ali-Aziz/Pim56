<?php
/**
 * @var \Pimcore\Templating\PhpEngine $this
 * @var \Pimcore\Templating\PhpEngine $view
 * @var \Pimcore\Templating\GlobalVariables $app
 */

use \Pimcore\Model\DataObject;

?>

<?php if($this->editmode) : ?>
    <div>
        <?php echo $this->areablock('slideshowAreablock',array(
            "toolbar"=> 0,
            "allowed"=> array("slide"),
            "params" => array(
                "slide" => array("width" => $this->width,"height" => $this->height),
            )
        )); ?>
    </div>
<?php endif; ?>

<?php if(!$this->editmode) : ?>

<div class="cycle-slideshow"
    data-cycle-slides="div.top-promo"
    data-cycle-timeout="10000"
    data-cycle-log="false"
    data-cycle-prev="#prev"
    data-cycle-next="#next"
    data-cycle-auto-height="container"
    data-cycle-swipe=true
    data-cycle-pager=".slideshow-pager"
    data-cycle-swipe-fx=scrollHorz
    data-cycle-loader="wait">

<?php 

    // $language = $this->language;
    // $baseUri = ($this->website['baseuri'] == '/') ? '' : $this->website['baseuri'];
    // $webbplats = $this->website['subdomain'];

    // $match = str_replace(',', '|', \Pimcore\Tool\Frontend::getWebsiteConfig()->newsSiteSlideshow);
    // if($this->startsite && strlen($match) && preg_match('/('.$match.')/',$webbplats))
    // {
    //     // load slides from news items ...
    //     $list = new DataObject\News\Listing();
    //     $list->setOrderKey("o_creationDate");
    //     $list->setOrder("desc");
    //     $list->setLimit(2);
    //     $list->setCondition(strtoupper($language) . ' = 1 AND Slide IS NOT NULL AND Webb LIKE "%' . $webbplats . '%"');
    //     $news = $list->load();

    //     foreach($news as $newsItem)
    //     {
    //         $class = "top-promo-overlay";
    //         $class .= (($newsItem->getSigill() == 1) ? " top-promo-watermark" : "");

    //         $uri = $baseUri . $uri;

    //         echo $this->template('Slideshow/partialSlide.html.php', array(
    //             'image_src' => $newsItem->getSlide()->getFullPath(),
    //             'target_href' => $baseUri . (($language == 'sv') ? '/nyheter/' : '/news/') . $newsItem->getKey(),
    //             'class' => $class,
    //             'color' => ($newsItem->getBGColor()) ? $newsItem->getBGColor() : 'bg_blue',
    //             'title' => $newsItem->getSlideH1(),
    //             'lead' => $newsItem->getSlideLead()
    //         ));
    //     }
    // }

    echo $this->areablock('slideshowAreablock',array(
        "toolbar"=> 0,
        "allowed"=> array("slide"),
        "params" => array(
            "slide" => array("width" => $this->width,"height" => $this->height),
        )
    )); 

?>
</div>

<div class="slideshow-pager"></div>
<div class="slider-controls clearfix">
    <a id="prev" class="slider-control cycle-prev">&nbsp;</a>
    <a class="slider-control-resumed slider-control slider-control-playpause">&nbsp;</a>
    <a id="next" class="slider-control cycle-next">&nbsp;</a>
</div>
<?php endif; ?>
