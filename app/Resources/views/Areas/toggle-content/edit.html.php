<?php
/**
 * @var \Pimcore\Templating\PhpEngine $this
 * @var \Pimcore\Templating\PhpEngine $view
 * @var \Pimcore\Templating\GlobalVariables $app
 */
 ?>

<p class="info margins">Bakgrundsfärg</p>
<?php echo $this->select("color", [
        "width" => 180,
        "store" => [
            ['bg-sky-50', 'Himmel 50 %'],
            ['bg-sky-25', 'Himmel 25 %'],
            ['bg-copper-50', 'Koppar 50 %'],
            ['bg-copper-25', 'Koppar 25 %'],
            ['bg-flower-50', 'Blomma 50 %'],
            ['bg-flower-25', 'Blomma 25 %'],
            ['bg-plaster-50', 'Puts 50 %'],
            ['bg-plaster-25', 'Puts 25 %'],
            ['bg-stone-50', 'Sten 50 %'],
            ['bg-stone-25', 'Sten 25 %']
        ]
    ]); ?>
