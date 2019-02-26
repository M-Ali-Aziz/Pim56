<?php
/**
 * @var \Pimcore\Templating\PhpEngine $this
 * @var \Pimcore\Templating\PhpEngine $view
 * @var \Pimcore\Templating\GlobalVariables $app
 */
?>

<?php if ($this->editmode): ?>
<style>
    .pimcore_block_button_up, .pimcore_block_button_down {display:block!important;}
    .pimcore_block_amount {display:none!important;}
</style>
<?php endif; ?>

<?php $id = "accordion-" . uniqid(); ?>

<?php if ($this->document->getProperty('bootstrap')) : ?>
    <div class="accordion" id="<?= $id ?>">
        <?php while($this->block("accordion")->loop()) : ?>
            <?php $entryId = $id . "-" . $this->block("accordion")->getCurrent(); ?>
            <?php if ($this->editmode): ?>
                <div class="card">
                    <div class="card-header bg-plaster-50" id="heading <?= $id ?>">
                        <div class="pt-3 pl-3"><strong>Rubrik</strong></div>
                        <?= $this->input("headline", ["class" => "mt-3 ml-3 mr-3 mb-2 nmt-1"]); ?>
                        <div class="pt-0 pl-3"><strong>Kurskod</strong></div>
                        <?= $this->input("kurskod", ["class" => "ml-3 mr-3 mb-2 nmt-1"]); ?>
                        <div class="pt-0 pl-3"><strong>Visa ut kursplan från UBAS</strong>&nbsp;&nbsp;&nbsp;Engelsk: <?= $this->checkbox("kursplan"); ?>&nbsp;&nbsp;&nbsp;Svensk: <?= $this->checkbox("kursplanSV"); ?></div>
                    </div>
                    <div id="<?= $entryId ?>" class="collapse show" aria-labelledby="heading <?= $id ?>" data-parent="#accordion">
                        <div class="card-body">
                            <?= $this->wysiwyg("text", array("customConfig" => "/static/js/ckeditor.js")); ?>
                        </div>
                    </div>
                </div>
            <?php else: ?>
                <div class="card">
                    <div class="card-header bg-plaster-50" id="heading-<?= $entryId ?>">
                        <h5>
                            <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapse-<?= $entryId ?>" aria-expanded="true" aria-controls="collapse-<?= $entryId ?>">
                                <div class="float-right">
                                    <span class="collapse-hide"><i class="fal fa-chevron-up"></i></span>
                                    <span class="collapse-show"><i class="fal fa-chevron-down"></i></span>
                                </div>
                                <?= $this->input("headline")->getData(); ?>
                            </button>
                        </h5>
                    </div>
                    <div id="collapse-<?= $entryId ?>" class="collapse" aria-labelledby="heading-<?= $entryId ?>" data-parent="#<?= $id ?>">
                        <div class="card-body">
                            <?= $this->wysiwyg("text")->getData(); ?>
                            <p class="text-right">
                            <?php if (!$this->input('kurskod')->isEmpty()) : ?>
                                <?= $this->translate('course_code'); ?>: <?= $this->input("kurskod")->getData(); ?>
                            <?php endif; ?>
                            <?php if ($this->checkbox('kursplan')->isChecked()) : ?>
                                | <a href="http://kursplaner.lu.se/pdf/kurs/en/<?php echo $this->input("kurskod")->getData(); ?>"><?= $this->translate('download_syllabus'); ?></a>
                            <?php elseif ($this->checkbox('kursplanSV')->isChecked()) : ?>
                                | <a href="http://kursplaner.lu.se/pdf/kurs/<?php echo $this->input("kurskod")->getData(); ?>"><?= $this->translate('download_syllabus'); ?></a>
                            <?php endif; ?>
                            </p>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        <?php endwhile; ?>
    </div>
<?php else : ?>
    <?php if ($this->editmode) : ?>
    <style>
    .pimcore_block_button_up, .pimcore_block_button_down {display:block!important;}
    .pimcore_block_amount {display:none!important;}
    </style>
    <?php $id = "accordion-" . uniqid();?>
    <div class="panel-group">
        <?php while($this->block("accordion")->loop()) : ?>
            <?php $entryId = $id . "-" . $this->block("accordion")->getCurrent(); ?>
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <p class="info">Rubrik:</p><?php echo $this->input("headline"); ?>
                    <p class="info margins">Kurskod:</p><?php echo $this->input("kurskod"); ?>
                    <span>Visa ut engelsk kursplan från UBAS:</span> <?php echo $this->checkbox("kursplan"); ?>
                </div>
                <div id="<?= $entryId ?>">
                    <div class="panel-body">
                        <?= $this->wysiwyg("text"); ?>
                    </div>
                </div>
            </div>
        <?php endwhile; ?>
    </div>
    <?php else : ?>
        <?php $id = "accordion-" . uniqid();?>
        <div class="panel-group" id="<?= $id ?>" role="tablist">
            <?php while($this->block("accordion")->loop()) : ?>
                <?php $entryId = $id . "-" . $this->block("accordion")->getCurrent(); ?>
                <div class="panel panel-primary">
                    <div class="panel-heading collapsed" data-toggle="collapse" data-parent="#<?= $id ?>" data-target="#<?= $entryId ?>" role="tab">
                        <h4 class="panel-title accordion-toggle"><?php echo $this->input("headline") ?></h4>
                    </div>
                    <div id="<?= $entryId ?>" class="panel-collapse collapse ?>">
                        <div class="panel-body">
                            <?= $this->wysiwyg("text") ?>
                            <?php if ($this->input('kurskod') != '') : ?>
                                <p class="align_right">Course code: <?php echo $this->input("kurskod"); ?>
                                <?php endif; ?>
                                <?php if ($this->checkbox('kursplan') == '1') : ?>
                                    | <a href="http://kursplaner.lu.se/pdf/kurs/en/<?php echo $this->input("kurskod"); ?>">Download curriculum</a>
                                <?php endif; ?>
                            </p>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>
    <?php endif; ?>
<?php endif; ?>
