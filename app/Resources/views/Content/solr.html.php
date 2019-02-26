<?php
/**
 * @var \Pimcore\Templating\PhpEngine $this
 * @var \Pimcore\Templating\PhpEngine $view
 * @var \Pimcore\Templating\GlobalVariables $app
 */

$this->extend('default.html.php');

?>
<?php $language = $this->document->getProperty('language'); ?>
<?php if($this->editmode) : ?>
<style>
table, table td, table th {border:none}
.pimcore_block_button_up, .pimcore_block_button_down {display:none !important;}
#pimcore_editable_mainAreablock .pimcore_area_edit_button {z-index: 999;}
</style>
<?php endif; ?>

<?php if ($this->document->getProperty('bootstrap')) : ?>
    <?= $this->template("Bootstrap/Content/solr.html.php"); ?>
<?php else: ?>
    
<?php echo $this->areablock('mainAreablock',array(
    "toolbar"=>0,
    "allowed"=>array("wysiwyg"),
    "params" => array(
        "wysiwyg" => array("width" => '100%')
    ))); ?>
<?php endif; ?>

