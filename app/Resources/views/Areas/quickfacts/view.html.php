<?php
/**
 * @var \Pimcore\Templating\PhpEngine $this
 * @var \Pimcore\Templating\PhpEngine $view
 * @var \Pimcore\Templating\GlobalVariables $app
 */
?>

<div class="infobox bg-copper-50 mb-3">
    <div class="row mb-3">
        <div class="col-2 text-center"><i class="far fa-graduation-cap fa-lg"></i></div>
        <div class="col">
            <p class="m-0"><strong>Next programme start</strong></p>
            <p><?= $this->input("startDate"); ?></p>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-2 text-center"><i class="far fa-calendar-alt fa-lg"></i></div>
        <div class="col">
            <p class="m-0"><strong>Arrival day</strong></p>
            <p><?= $this->input("arrivalDay"); ?></p>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-2 text-center"><i class="far fa-clock fa-lg"></i></div>
        <div class="col">
            <p class="m-0"><strong>Application deadline</strong></p>
            <p><?= $this->input("applicationDeadline"); ?></p>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-2 text-center"><i class="far fa-hourglass-start fa-lg"></i></div>
        <div class="col">
            <p class="m-0"><strong>Duration</strong></p>
            <p><?= $this->input("duration"); ?></p>
        </div>
    </div>
    <div class="row mb-0">
        <div class="col-2 text-center"><i class="far fa-money-bill-alt fa-lg"></i></div>
        <div class="col">
            <p class="m-0"><strong>Tuition fee</strong></p>
            <p><?= $this->input("fee"); ?></p>
        </div>
    </div>
    <?php if($this->document->getProperty('apply1')) { ?>
        <div class="mt-3">
            <a href="https://www.universityadmissions.se/intl/search?period=HT_2019&freeText=<?php echo $this->document->getProperty('code')?>" class="btn btn-dark">Apply online now</a>
        </div>
    <?php } ?>
</div>
