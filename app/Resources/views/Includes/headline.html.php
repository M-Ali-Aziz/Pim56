<?php
/**
 * @var \Pimcore\Templating\PhpEngine $this
 * @var \Pimcore\Templating\PhpEngine $view
 * @var \Pimcore\Templating\GlobalVariables $app
 */
?>
<?php if($this->editmode) : ?>

    <header id="page_title">
        <h1><?php echo $this->input("title"); ?></h1>
        <h2><?php echo $this->input("kicker"); ?></h2>
    </header>
    <p class='lead'><?php echo $this->textarea("lead"); ?></p>

<?php else : ?>

    <header id="page_title">
        <?php if (!$this->input("title")->isEmpty()) : ?>
            <h1><?php echo $this->input("title")->getData(); ?></h1>
        <?php endif; ?>

        <?php if (!$this->input("kicker")->isEmpty()) : ?>
            <h2><?php echo $this->input("kicker"); ?></h2>
        <?php endif; ?>
    </header>

    <?php if (!$this->textarea("lead")->isEmpty()): ?>
        <p class='lead'><?php echo $this->textarea("lead"); ?></p>
    <?php endif; ?>

<?php endif; ?>