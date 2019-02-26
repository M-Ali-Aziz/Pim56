<?php
/**
 * @var \Pimcore\Templating\PhpEngine $this
 * @var \Pimcore\Templating\PhpEngine $view
 * @var \Pimcore\Templating\GlobalVariables $app
 */

$this->extend('default.html.php');

?>




<?php $language = $this->language; ?>
<!-- Text content start -->
<div id="text_wrapper" class="grid-15 push-8 alpha">
    <article id="text_content_main">
        <!--eri-no-index-->
        <div id="share_wrapper" class="clearfix">	</div>
        <!--/eri-no-index-->
        <header id="page_title">
            <h1>Sidan kan inte hittas</h1>
            <h2>Page not found</h2>
        </header>
        <p>Sidan du letar efter kan tyvärr inte hittas. Det kan bero på att sidan har tagits bort eller flyttats. Kontrollera gärna att URL:en inte innehåller några skrivfel om du matat in den själv i webbläsaren. Vi är tacksamma om du vill meddela den brutna länken till <?php echo $this->pageManager($this); ?>.</p>
        <p><em>We’re sorry for the inconvenience, but the page you requested does not exist or has been moved. Please notify <?php echo $this->pageManager($this); ?> if you were linked to this page from another part of our website.</em></p>
    </article>
</div>
<!-- Text content end -->
