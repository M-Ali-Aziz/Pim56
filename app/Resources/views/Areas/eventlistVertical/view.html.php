<?php
/**
 * @var \Pimcore\Templating\PhpEngine $this
 * @var \Pimcore\Templating\PhpEngine $view
 * @var \Pimcore\Templating\GlobalVariables $app
 */
?>
<?php
$language = $this->language;
$uri = ($language == 'sv') ? '/kalendarium/' : '/calendar/';
$baseUri = ($this->baseuri == '/') ? '' : $this->baseuri;
$uri = $baseUri . $uri;
?>

<?php if($this->eventList) : ?>
    <div class="calendar-wrapper calendar-horizontal">
        <div class="calendar-main-title <?php echo $this->color; ?> clearfix">
            <h2><a href="<?php echo $uri?>"><?php echo $this->translate('calendar'); ?></a></h2>
            <p class="archive_link"><a href="<?php echo $uri?>"><?php echo $this->translate('more events'); ?><span class="archive_icon"></span></a></p>
        </div>
        <div class="calendar-items <?php echo $this->color; ?> clearfix">
            <?php
                $count = 0;
                foreach($this->eventList as $item) :
                $class = 'calendar-item start-grid-7';
                // center-(left|right) class..
                switch($count):
                    case 1:
                        $class .= ' center' . (($this->itemsPerRow>3) ? '-left' : '');
                        break;
                    case 2:
                        $class .= ($this->itemsPerRow>3) ? ' center-right' : '';
                        break;
                endswitch;
            ?>

            <div class="<?php echo $class; ?>">
            <p class="calendar-category"><?php echo $item->getCategory() ? $this->translate($item->getCategory()) : ''; ?></p>
                <p class="calendar-title"><a href="<?php echo $uri; ?><?php echo $item->getKey(); ?>"><?php echo $item->getRubrik(); ?></a></p>
                <p class="calendar-date">
                    <?php
                        $date = (string) $this->calendarEventDate(
                            $language,
                            $item->getStart(),
                            $item->getEnd(),
                            $item->getShowEnd()
                        );
                        echo $date;
                    ?>
                </p>
            </div>
            <?php $count++; endforeach;?>
        </div>
    </div>
<?php endif;?>
