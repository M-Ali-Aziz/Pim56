<?php
/**
 * @var \Pimcore\Templating\PhpEngine $this
 * @var \Pimcore\Templating\PhpEngine $view
 * @var \Pimcore\Templating\GlobalVariables $app
 */
?>
<?php
    // Todo: check if this needs to exist here (copied from news view)
    $language = $this->document->getProperty('language');
    $locale = $this->news_locale;
    if (empty($locale)) {
        $locale = ($language == 'sv') ? 'en' : false;
        if (!$locale) $this->nyheter = null;
    }
    $baseUri = ($this->website['baseuri'] == '/') ? '' : $this->website['baseuri'];
    $uri = $baseUri . $uri;
?>
<div id="text_wrapper" class="grid-15 push-8 alpha">
    <article id="text_content_main">

    <header id="page_title">
        <h1>Tagg - <?php echo $this->tag->getName(); ?></h1>
    </header>

        <?php if($this->objects && $this->paginator) : ?>
            <table class="no-border" width="432px">
                <?php foreach($this->paginator  as $item) :?>
                    <?php
                    $locale = ($item->getRubrik($language)) ? $language : false;
                    if (empty($locale)) {
                        $locale = ($language == 'sv') ? 'en' : false;
                    }
                    ?>
                    <?php if ($locale) : ?>
                        <tr>
                            <td width="70px">
                                <?php echo date("Y-m-d", $item->getCreationDate())?>
                            </td>
                            <td>
                                <a href="<?php echo $uri; ?>/<?php echo $item->getClassName(); ?>/<?php echo $item->getO_key()?>"><?php echo $item->getRubrik($locale)?></a><br>
                                <?php echo $this->summary($item->getSammanfattning($locale), $this->sammanfattning)?>
                            </td>
                        </tr>
                    <?php endif;?>
                <?php endforeach;?>
            </table>

        <?php else : ?>
            <?php if ($language == 'sv') : ?>
                <p>Det finns för närvarande inga nyhetsartiklar!</p>
            <?php else : ?>
                <p>There are currently no news articles!</p>
            <?php endif;?>
        <?php endif;?>

        <header id="page_title">
            <h2>Andra populära taggar:</h2>
        </header>

        <div class="tags-wrapper-popular tags-wrapper">
            <?php foreach ($this->popular as $tag): ?>
                <a class="tag-popular tag label label-primary" href="<?php echo $uri; ?>/tag/<?php echo strtolower($tag->getName()); ?>"><?php echo $tag->getName(); ?></a>
            <?php endforeach; ?>
        </div>

        <!-- Sidebar start -->
        <div id="content_sidebar_wrapper" class="<?php echo ((!$this->getProperty('navStartNode')) || ($this->getProperty('push-8'))) ? "push-8 " : ""; ?>grid-8 omega">
            <div id="content_sidebar">
                <?php if($this->editmode) : ?>
                    <p style="margin-bottom: 20px;"><b>Innehåll</b> (224 px bred)</p>
                <?php endif; ?>
                <?php echo $this->areablock('rightAreablock',array(
                    "toolbar"=>0,
                    "allowed"=> array("wysiwyg","snippet","youtube","image","uid","heading","rss","news","eventlist","puff"),
                    "params" => array(
                        "wysiwyg" => array("width" => 224),
                        "snippet" => array("width" => 224),
                        "heading" => array("width" => 224),
                        "image" => array("width" => 224),
                        "youtube" => array("width" => '100%', "height" => 126),
                        "video" => array("width" => '100%', "height" => 126),
                        "rss" => array(),
                        "news" => ['baseuri' => $this->website['baseuri']],
                        "eventlist" => ['baseuri' => $this->website['baseuri']],
                        "puff" => array(), "uid" => array()
                    )));?>
            </div>
        </div>
        <!-- Sidebar end -->

    </article>
</div>