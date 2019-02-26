<?php
/**
 * @var \Pimcore\Templating\PhpEngine $this
 * @var \Pimcore\Templating\PhpEngine $view
 * @var \Pimcore\Templating\GlobalVariables $app
 */
?>
<?php if ($this->document->getProperty('bootstrap') == 1) : ?>
    <?php if($this->editmode) : ?>
        <figure class="figure" style="width: 100%;">
            <?php echo $this->image("image", array("hidetext" => true, "class" => 'figure-img img-fluid m-0')); ?>
            <figcaption class="figure-caption bg-dark text-white p-2"><?php echo $this->input("figcaption"); ?></figcaption>
        </figure>
    <?php else : ?>
        <figure class="figure">
            <?php echo $this->image("image", array("class" => 'figure-img img-fluid m-0')); ?>
            <?php if (!$this->input("figcaption")->isEmpty()) : ?>
            <figcaption class="figure-caption bg-dark text-white p-2"><?php echo $this->input("figcaption"); ?></figcaption>
            <?php endif; ?>
        </figure>
    <?php endif; ?>
<?php else : ?>
    <?php echo "<div>" . $this->image("image", array("width" => $this->width)) . "</div>"; ?>
<?php endif; ?>
