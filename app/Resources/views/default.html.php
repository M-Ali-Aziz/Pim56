<?php
/**
 * @var \Pimcore\Templating\PhpEngine $this
 * @var \Pimcore\Templating\PhpEngine $view
 * @var \Pimcore\Templating\GlobalVariables $app
 */
?>
<?php if ($this->document->getProperty('bootstrap')) : ?>
<?= $this->template("new.html.php"); ?>
<?php else: ?>
<?= $this->template("old.html.php"); ?>
<?php endif; ?>
