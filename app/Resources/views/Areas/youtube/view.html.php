<?php
/**
 * @var \Pimcore\Templating\PhpEngine $this
 * @var \Pimcore\Templating\PhpEngine $view
 * @var \Pimcore\Templating\GlobalVariables $app
 */
?>

<?php if ($this->document->getProperty('bootstrap') == 1) : ?>
    <?php if (!$this->input("heading")->isEmpty()) : ?>
        <?php echo  "<h2>" . $this->input("heading") . "</h2>"; ?>
    <?php endif; ?>
    <?php if (!$this->input("id")->isEmpty()) : ?>
        <div class="embed-responsive embed-responsive-16by9">
        	<iframe class="embed-responsive-item" src="https://www.youtube.com/embed/<?php echo $this->input("id"); ?>" allowfullscreen></iframe>
        </div>
    <?php endif; ?>
<?php else: ?>
    <?php if (!$this->input("heading")->isEmpty()) : ?>
        <?php echo  "<h2>" . $this->input("heading") . "</h2>"; ?>
    <?php endif; ?>
    <?php if (!$this->input("id")->isEmpty()) : ?>
        <iframe width="<?php echo $this->width;?>" height="<?php echo $this->height;?>" src="https://www.youtube.com/embed/<?php echo $this->input("id"); ?>?rel=0&amp;showinfo=0" frameborder="0" allowfullscreen></iframe>
    <?php endif; ?>
<?php endif; ?>
