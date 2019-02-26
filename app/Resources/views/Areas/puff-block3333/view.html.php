<?php
/**
 * @var \Pimcore\Templating\PhpEngine $this
 * @var \Pimcore\Templating\PhpEngine $view
 * @var \Pimcore\Templating\GlobalVariables $app
 */
?>


<?php $numbers = $this->itemsPerRow; ?>
<div class="<?php echo $this->containerClass; ?>">
    <div class="row">
        <?php for($t=0; $t<$numbers; $t++) { ?>
            <div class="<?php echo $this->colClass; ?>">
                <?php if($this->editmode) { ?>
                    <div>
                        <?= $this->select("type_".$t, [
                            "width" => 150,
                            "reload" => true,
                            "store" => [["direkt","Redigera direkt"], ["snippet","Infoga snippet"]]
                        ]); ?>
                    </div>
                <?php } ?>
                <?php
                    $type = $this->select("type_".$t)->getData();
                    if($type == "direkt") {
                        echo $this->template("Bootstrap/Snippet/teaser.html.php", ["suffix" => $t]);
                    } else { ?>
                        <div class="<?= ($this->editmode) ? 'mt-6' : 'h-100'; ?>">
                            <?= $this->snippet("teaser_".$t); ?>
                        </div>
                    <?php }
                ?>
            </div>
        <?php } ?>
    </div>
</div>
