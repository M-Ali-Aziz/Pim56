<?php
/**
 * @var \Pimcore\Templating\PhpEngine $this
 * @var \Pimcore\Templating\PhpEngine $view
 * @var \Pimcore\Templating\GlobalVariables $app
 */
?>
<?php if($this->document->getProperty('apply1') == 1) { ?>
    <div class="promo_box">
        <div class="promo promo_text_brown bg_white promo_txt border">
            <div class="last-application-date">
                <div class="day">15</div>
                <div class="text">Last application date</div>
                <div class="month">January 2018</div>
            </div>
        </div>
    </div>
    <div class="promo"><a href="https://www.universityadmissions.se/intl/search?period=HT_2018&freeText=<?php echo $this->document->getProperty('code')?>" class="btn-lg apply btn-default btn-block" role="button" onclick="ga('send', 'event', 'MSc Programmes', 'apply', '<?php echo $this->document->getProperty('MSc')?>');"><i class="fa fa-user-plus"></i> Apply online now</a></div>
    <?php } ?>
    <?php if($this->document->getProperty('apply2') == 1) { ?>
        <div class="promo_box">
            <div class="promo promo_text_brown bg_white promo_txt border">
                <div class="last-application-date">
                    <div class="day">15</div>
                    <div class="text">Last application date</div>
                    <div class="month">January 2018</div>
                </div>
                <div class="service-opens">
                    <div class="text">The application service opens mid-October.</div>
                </div>
            </div>
        </div>
        <?php } ?>
        <?php if($this->document->getProperty('apply3') == 1) { ?>
            <div class="promo_box">
                <div class="promo promo_text_brown bg_white promo_txt border">
                    <div class="last-application-date">
                        <div class="day">15</div>
                        <div class="text">Last application date</div>
                        <div class="month">January 2018</div>
                    </div>
                    <div class="service-opens">
                        <div class="text">Closed for applications.<br>Don't forget to submit your documents!</div>
                    </div>
                </div>
            </div>
            <?php } ?>
            <?php if($this->document->getProperty('apply4') == 1) { ?>
                <div class="promo_box">
                    <div class="promo promo_text_brown bg_white promo_txt border">
                        <div class="last-application-date">
                            <div class="day">15</div>
                            <div class="text">Last application date</div>
                            <div class="month">January 2018</div>
                        </div>
                        <div class="service-opens">
                            <div class="text">Closed for applications.</div>
                        </div>
                    </div>
                </div>
                <?php }  ?>