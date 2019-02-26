<?php
/**
 * @var \Pimcore\Templating\PhpEngine $this
 * @var \Pimcore\Templating\PhpEngine $view
 * @var \Pimcore\Templating\GlobalVariables $app
 */
?>
<p class="h3 mt-0 mb-3"><?php echo ucfirst($this->translate('contact_details')); ?></p>
<p><strong><?php echo $this->name; ?></strong></p>
<p><?php echo ucfirst($this->translate('visiting_address')); ?>:<br> <?php echo $this->visiting; ?></p>
<p><?php echo ucfirst($this->translate('postal_address')); ?>:<br> <?php echo $this->postal; ?></p>
<p><?php echo ucfirst($this->translate('internal_mail')); ?>: <?php echo $this->internal; ?></p>
<p><?php echo ucfirst($this->translate('phone')); ?>: <?php echo $this->phone; ?></p>
<p><a href="<?php echo $this->website; ?>"><?php echo ucfirst($this->translate('visit_website')); ?></a></p>

<?php if($this->gm_key && $this->gm_q): ?>
<iframe class="w-100" height="300px" frameborder="0" style="border:0" src="https://www.google.com/maps/embed/v1/place?key=<?php echo $this->gm_key; ?>&q=<?php echo $this->gm_q; ?>&zoom=12"></iframe>
<?php endif; ?>
