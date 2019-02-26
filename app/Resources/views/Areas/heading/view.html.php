<?php
/**
 * @var \Pimcore\Templating\PhpEngine $this
 * @var \Pimcore\Templating\PhpEngine $view
 * @var \Pimcore\Templating\GlobalVariables $app
 */
?>
<?php if ($this->document->getProperty('bootstrap') && $this->editmode) : ?>
<div class="alert alert-danger" role="alert">
  Ersätt heading-elementet!
</div>
<?php endif; ?>
<h2><?php echo $this->input("heading",array("width" => $this->width));?></h2>
