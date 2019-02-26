<?php
/**
 * @var \Pimcore\Templating\PhpEngine $this
 * @var \Pimcore\Templating\PhpEngine $view
 * @var \Pimcore\Templating\GlobalVariables $app
 */

$this->extend('default.html.php');

?>

<?php $language = $this->language;?>
<?php if($this->editmode) : ?>
<style>
table, table td, table th {border:none}
.pimcore_block_button_up, .pimcore_block_button_down {display:none !important;}
#pimcore_editable_rightAreablock .pimcore_area_edit_button,
#pimcore_editable_mainAreablock .pimcore_area_edit_button {z-index: 99;}
#content_sidebar table {margin-bottom:0;}
.info {font-weight:700;margin:0;}
.margins {margin:8px 0 0 0;}
</style>
<?php endif; ?>
<div class="row">
    <div class="col-12 col-lg-8 mb-6 mb-lg-0">
        <article>
            <h1><?php echo $this->translate('contact'); ?></h1>
            <h2><?php echo $this->translate('search_person'); ?></h2>
            <p><?php echo $this->translate('search_lusem_staff'); ?>.</p>
            <div>
                <form action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="post" name="form" onsubmit="return validate();">
                    <input id="searchpers" name="visa" type="hidden" value="2" />
                    <input id="searcha" name="q" size="30" type="text" value="<?php echo $this->query;?>" />
                    <input name="btnSearch" class="btn btn-primary" type="submit" value="<?php echo $this->translate('search'); ?>" />
                </form>
            </div>

            <?php
                if($this->staffList) :
                    $helper = $this->staff($this, $this->staffList);
                    echo $helper->staffList(array(
                        'image' => false,
                        'room' => false,
                        'roleinfo' => false,
                        'moreinfo' => true,
                    ));
            ?>
            <?php elseif($this->query) : ?>
                <p><?php echo $this->translate('no matching search results'); ?></p>
            <?php else: ?>
            <?php echo $this->areablock('mainAreablock',array(
                "toolbar"=>0,
                "allowed"=>array("wysiwyg","snippet","youtube","image")
                ));?>
            <?php endif;?>

        </article>
    </div>
    <div class="col-12 col-lg-4">
        <?php echo $this->areablock('rightAreablock',array(
            "toolbar"=>0,
            "allowed"=> array("wysiwyg","snippet","youtube","image","uid","infobox","puff")
            ));?>
    </div>
</div>
