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
<p><b>Snippet för puffar som kan återanvändas på flera ställen</b></p>
<?php endif; ?>

<?php if ($this->document->getProperty('bootstrap')) : ?>
    <?php echo $this->areablock('snippet',array(
        "toolbar"=>0,
        "allowed"=>array("puff"),
        "params" => array(
        	"puff" => array()
    	)
    ));?>
<?php else: ?>
    <?php echo $this->areablock('snippet',array(
        "toolbar"=>0,
        "allowed"=>array("puff"),
        "params" => array(
        	"puff" => array()
    	)
    ));?>
<?php endif; ?>
