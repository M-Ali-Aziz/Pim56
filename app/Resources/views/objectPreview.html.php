<?php
/**
 * @var \Pimcore\Templating\PhpEngine $this
 * @var \Pimcore\Templating\PhpEngine $view
 * @var \Pimcore\Templating\GlobalVariables $app
 */
?>
<!DOCTYPE html>
<html lang="<?php echo $this->language; ?>">
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=Edge" />
    <meta charset='UTF-8'/>
    <link media="all" href="/static/css/style.css" rel="stylesheet" type="text/css">
    <link media="all" href="/static/css/ehl.css" rel="stylesheet" type="text/css">
    <meta id="viewport" content="width=device-width, initial-scale=1" name="viewport">
</head>
<body>
    <!-- Vanliga startsidor och undersidor -->
    <div id="content_wrapper" class="container-31 clearfix">
        <div id="content" class="grid-31 clearfix">
          <?php $this->slots()->output('_content'); ?>
        </div>
    </div>
</body>
</html>
