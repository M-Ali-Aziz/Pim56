<?php
/**
 * @var \Pimcore\Templating\PhpEngine $this
 * @var \Pimcore\Templating\PhpEngine $view
 * @var \Pimcore\Templating\GlobalVariables $app
 */
?>
<?php echo $this->wysiwyg("content",array(
    "width" => $this->width,
    "customConfig" => "/static/js/ckeditor.js"
));
?>
