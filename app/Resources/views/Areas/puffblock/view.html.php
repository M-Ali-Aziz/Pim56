<?php
/**
 * @var \Pimcore\Templating\PhpEngine $this
 * @var \Pimcore\Templating\PhpEngine $view
 * @var \Pimcore\Templating\GlobalVariables $app
 */
?>

<div class="<?php echo $this->class; ?> clearfix">
    <?php
    echo $this->areablock("promoAreablock", [
        "toolbar" => 0,
        "allowed" => ["startpuff"],
        "params" => [
            "promo_areablock" => ["promo_areablock" => true],
            "startpuff" => [
                "itemsPerRow" => $this->itemsPerRow
            ]
        ]
    ]);
    ?>
</div>
