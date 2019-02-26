<?php
/**
 * @var \Pimcore\Templating\PhpEngine $this
 * @var \Pimcore\Templating\PhpEngine $view
 * @var \Pimcore\Templating\GlobalVariables $app
 */
?>
<p class="info">Rubrik:</p>
<?php echo $this->input("heading"); ?>

<p class="info margins">Länk till RSS-flöde:</p>
<?php echo $this->input("rss"); ?>

<p class="info margins">Antal poster som ska visas (0-20) (default = 10)</p>
<?php
	echo $this->numeric("limit", array(
    "minValue" => 0,
    "maxValue" => 20
	));
?>

<p class="info margins">Rubrik på länk till webbplats för mer nyheter</p>
<?php echo $this->input("linkHeading"); ?>

<p class="info margins">Länk till webbplats för mer nyheter (http://...)</p>
<?php echo $this->input("linkUrl"); ?>

<p class="info margins">Som standard visas det ut en kort beskrivning under varje nyhet. Ändra standardvisning genom att klicka i ett alternativ nedan.</p>

<div style="margin:5px 0 5px 0;">
    <div><?php echo $this->checkbox("descriptionLong"); ?><span style="display: inline-block; margin-top: 3px;">Visa lång beskrivning för varje post</span></div>
</div>

<div style="margin:5px 0 5px 0;">
    <div><?php echo $this->checkbox("descriptionNone"); ?><span style="display: inline-block; margin-top: 3px;">Visa inte någon beskrivning</span></div>
</div>

<div style="margin:5px 0 5px 0;">
    <div><?php echo $this->checkbox("pagination"); ?><span style="display: inline-block; margin-top: 3px;">Paginering</span></div>
</div>
