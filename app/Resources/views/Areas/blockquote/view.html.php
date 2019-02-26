<?php
/**
 * @var \Pimcore\Templating\PhpEngine $this
 * @var \Pimcore\Templating\PhpEngine $view
 * @var \Pimcore\Templating\GlobalVariables $app
 */
?>

<?php if ($this->document->getProperty('bootstrap')) : ?>
<div class="m-5 text-dark-grey">
    <blockquote class="blockquote">
        <p class="mb-0"><i class="fas fa-3x fa-quote-right fa-pull-left"></i><?php echo $this->textarea("blockquote", array("nl2br" => true)); ?></p>
        <?php if (!$this->input("quoted")->isEmpty()) : echo  "<footer class='blockquote-footer text-right'><cite>" . $this->input("quoted") . "</cite></footer>"; endif; ?>
    </blockquote>
</div>
<?php else: ?>
<blockquote>
    <p><?php echo $this->textarea("blockquote", array("nl2br" => true)); ?></p>
    <?php if (!$this->input("quoted")->isEmpty()) : echo  "<footer>" . $this->input("quoted") . "</footer>"; endif; ?>
</blockquote>
<?php endif; ?>
