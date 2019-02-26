<?php
/**
 * @var \Pimcore\Templating\PhpEngine $this
 * @var \Pimcore\Templating\PhpEngine $view
 * @var \Pimcore\Templating\GlobalVariables $app
 */
?>

<?php
$color = $this->select("color")->getData();
if(empty($color)) $color = 'bg-sky-50';
$readmore = $this->link("readmore");
$readmoreText = $this->link("readmore")->getText();
if ($this->link("readmore")->getText() == '') {
    $readmoreText = "Läs mer";
}
?>

<?php if($this->editmode) : ?>
<style>
.pimcore_area_infobox .pimcore_tag_input {
    font-family: "Georgia",serif;
    font-weight: 500;
    line-height: 1.2;
    font-size: 1.5rem;
}

</style>
<div class="alert alert-warning" role="alert">
  Ange bakgrundsfärg, rubrik, text och eventuell högerställd länk.
</div>
<?php echo $this->select("color", [
        "width" => 160,
        "reload" => "true",
        "store" => [
            ['bg-sky-50', 'Himmel 50 %'],
            ['bg-sky-25', 'Himmel 25 %'],
            ['bg-copper-50', 'Koppar 50 %'],
            ['bg-copper-25', 'Koppar 25 %'],
            ['bg-flower-50', 'Blomma 50 %'],
            ['bg-flower-25', 'Blomma 25 %'],
            ['bg-plaster-50', 'Puts 50 %'],
            ['bg-plaster-25', 'Puts 25 %'],
            ['bg-stone-50', 'Sten 50 %'],
            ['bg-stone-25', 'Sten 25 %']
        ]
    ]); ?>
<?php endif; ?>

<div class="<?php echo $color; ?> mb-6 p-5">
    <p class="h3 mt-0 mb-3"><?php echo $this->input("heading"); ?></p>
    <?php echo $this->wysiwyg("content", array (
            "customConfig" => "/static/js/ckeditor.js"
        )); ?>
    <?php if($this->editmode) : ?>
        <div class="text-right font-weight-normal">
                <?php echo $this->link("readmore"); ?>
        </div>
        <?php else: ?>
        <?php if (!$this->link("readmore")->isEmpty()) : ?>
        <div class="text-right font-weight-normal">
            <a href="<?php echo $this->link("readmore")->getHref(); ?>" class="nav-undecorated" title="<?php echo $this->link("readmore")->getTitle(); ?>"><?php echo $readmoreText; ?> <span class="ml-1"><i class="fal fa-chevron-circle-right fa-lg"></i></span></a>
        </div>
        <?php endif; ?>
        <?php endif; ?>
</div>
