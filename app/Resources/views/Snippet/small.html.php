<?php
/**
 * @var \Pimcore\Templating\PhpEngine $this
 * @var \Pimcore\Templating\PhpEngine $view
 * @var \Pimcore\Templating\GlobalVariables $app
 */
?>
<?php if($this->editmode) : ?>
<style>
table, table td, table th {border:none}
.pimcore_block_button_up, .pimcore_block_button_down {display:none !important;}
#pimcore_editable_areablock .pimcore_area_edit_button{z-index: 999;}
p {font-family:Arial,sans-serif;font-size:12px;}
</style>
<p><b>Snippet för bl a faktarutor, text och bilder i högerkolumnen</b></p>
<p>Lägg till, ta bort och flytta element</p>
<?php endif; ?>

<?php if ($this->document->getProperty('bootstrap')) : ?>
    <?php echo $this->areablock('snippet',array(
        "toolbar"=>0,
        "allowed"=> ["wysiwyg","image","infobox","puff","uid","youtube","rss","heading"],
        "sorting"=> ["wysiwyg","image","infobox","puff","uid","youtube","rss","heading"]
    ));?>
<?php else : ?>
<?php echo $this->areablock('snippet',array(
    "toolbar"=>0,
    "allowed"=>array("heading","wysiwyg","image","youtube"),
    "params" => array(
        "wysiwyg" => array("width" => 224),
        "heading" => array("width" => 224),
        "image" => array("width" => 224),
        "youtube" => array("width" => 224, "height" => 126)
    )));?>
<?php endif; ?>
