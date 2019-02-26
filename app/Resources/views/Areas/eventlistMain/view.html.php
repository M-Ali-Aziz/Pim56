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

<?php if ($this->document->getProperty('bootstrap')) : ?>
    <div class="alert alert-danger" role="alert">
      Ersätt kalenderelement!
    </div>
<?php else : ?>

    <?php if($this->eventList) : ?>
        <div class="calendar-wrapper calendar-vertical" style="padding:0; margin-top:30px">
            <?php foreach($this->eventList as $item) :?>
                <div class="calendar-item">
                    <p class="calendar-category"><?php echo $item->getCategory() ? $this->translate($item->getCategory()) : ''; ?></p>
                    <p class="calendar-title"><a href="<?php echo $uri; ?><?php echo $item->getKey(); ?>"><?php echo $item->getRubrik()?></a></p>
                    <p class="calendar-lead"><?php echo $this->summary($item->getIngress(), $this->sammanfattning)?></p>
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
            <?php endforeach;?>
        </div>
    <?php endif;?>

<?php endif; ?>
