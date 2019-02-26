<?php
/**
 * @var \Pimcore\Templating\PhpEngine $this
 * @var \Pimcore\Templating\PhpEngine $view
 * @var \Pimcore\Templating\GlobalVariables $app
 */
?>
<?php
$icons = [
    "fa-chart-line" => "Applicants",
    "fa-graduation-cap" => "Enrolled",
    "fa-male" => "Male students",
    "fa-female" => "Female students",
    "fa-id-card" => "Age range",
    "fa-globe" => "Nationalities"
];

$i = 0;
$dataAosDelay = -100;
$dataDelay = 0.1;
?>

<div class="bg-copper-50 py-9">
    <div class="container text-center">
        <h2 class="mt-0 mb-5"><?= $this->input("headline"); ?></h2>
        <div class="row">
            <?php foreach ($icons as $icon => $text) : ?>
                <?php $i++; $dataAosDelay+=100; $dataDelay+=0.1; ?>
                <div class="col-6 col-xl-2 col-sm-6 mt-3 mt-xl-0">
                    <div class="flex-column" data-aos="zoom-in-up" data-aos-delay="<?= $dataAosDelay ?>">
                        <div>
                            <h1 class="m-0"><i class="fal <?= $icon ?>"></i></h1>
                        </div>
                        <div>
                        <?php switch ($icon) :
                            case 'fa-graduation-cap': ?>
                            <?php case 'fa-globe': ?>
                                <p class="h2 m-0 count-up" data-delay="<?= $dataDelay ?>"><?= $this->input("number" . $i); ?></p>
                                <?php break; ?>

                            <?php case 'fa-male': ?>
                            <?php case 'fa-female': ?>
                                <p class="h2 m-0"><span class="count-up" data-delay="<?= $dataDelay ?>"><?= $this->input("number" . $i); ?></span>%</p>
                                <?php break; ?>

                            <?php case 'fa-id-card': ?>
                                <p class="h2 m-0"><?= $this->input("number" . $i) . " - "; ?>
                                    <span class="count-up" data-start="<?= $this->input("number" . $i)->getData() ?>" data-delay="0.6">
                                        <?= $this->input("number-span" . $i); ?>
                                    </span>
                                </p>
                                <?php break; ?>

                            <?php default: ?>
                            <p class="h2 m-0 count-up"><?= $this->input("number" . $i); ?></p>
                            <?php break; ?>
                        <?php endswitch; ?>
                        </div>
                        <div>
                            <p class="small"><?= $text ?></p>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>
