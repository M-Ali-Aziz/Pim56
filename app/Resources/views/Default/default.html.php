<?php
/**
 * @var \Pimcore\Templating\PhpEngine $this
 * @var \Pimcore\Templating\PhpEngine $view
 * @var \Pimcore\Templating\GlobalVariables $app
 */
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>404 - Not Found</title>
</head>
<body>
    <?php header("HTTP/1.0 404 Not Found");?>
    <h1>Not Found</h1>
    <p>The requested URL <?php echo $_SERVER['REQUEST_URI']?> was not found on this server.</p>
    <p>This is an error, please contact <?php echo $_SERVER['SERVER_ADMIN']?>.</p>
</body>
</html>
