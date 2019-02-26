<?php
/**
 * @var \Pimcore\Templating\PhpEngine $this
 * @var \Pimcore\Templating\PhpEngine $view
 * @var \Pimcore\Templating\GlobalVariables $app
 */
?>
<?php $language = $this->language; ?>


<?php if($this->editmode) : ?>
<style>
    table, table td, table th {border:none;}
    #pimcore_editable_rightAreablock .pimcore_area_edit_button,
    #pimcore_editable_mainAreablock .pimcore_area_edit_button {z-index: 9999;}
    /*.pimcore_tag_input, .pimcore_tag_textarea {padding:5px 10px 0 10px;}*/
    .x-window .pimcore_tag_input {border: 1px solid #dedbd9;}
    .info {font-weight:700;margin:0;}
    .margins {margin:8px 0 0 0;}
    .embed-responsive {z-index:1;}
    .pimcore_area_entry {margin: 60px 0 40px!important;}
    .main{overflow:visible;}
    .pimcore_area_buttons {display:block; visibility:visible!important;}
</style>
<?php endif; ?>

<div class="row">
    <div class="col-12 col-lg-8 mb-6 mb-lg-0">
        <article>
            <?php if($this->editmode) : ?>
                <h1><?php echo $this->input("title"); ?></h1>
                <div class="nmt-3 mb-3">
                	<?= $this->input("kicker", ["class" => 'text-uppercase mt-0']); ?>
                </div>
                <?= $this->textarea("lead", ["class" => 'lead']); ?>
            <?php else : ?>
                <?php if (!$this->input("title")->isEmpty()) : ?>
                    <h1><?php echo $this->input("title"); ?></h1>
                <?php endif; ?>
                <?php if (!$this->input("kicker")->isEmpty()) : ?>
                    <div class="nmt-3 mb-3">
                    	<p class="text-uppercase mt-0"><strong><?php echo $this->input("kicker"); ?></strong></p>
                    </div>
                <?php endif; ?>
                <?php if (!$this->textarea("lead")->isEmpty()): ?>
                    <p class='lead'><?php echo $this->textarea("lead"); ?></p>
                <?php endif; ?>
            <?php endif; ?>
            <?php echo $this->areablock('mainAreablock',[
                "allowed"=>["wysiwyg","image","blockquote","infobox","snippet","youtube","accordion","toggle-portrait","toggle-content","rss","newsMain","eventlist","video","eventlistMain","heading"],
                "sorting"=>["wysiwyg","image","blockquote","infobox","snippet","youtube","accordion","toggle-portrait","toggle-content","rss","newsMain","eventlist","video","eventlistMain","heading"],
                "params" => [
                    "newsMain" => ['baseuri' => $this->website['baseuri']],
                    "toggle-content" => ["forceEditInView" => true],
                    "toggle-portrait" => ["forceEditInView" => true]
                ]
            ]);?>
        </article>
    </div>
    <div class="col-12 col-lg-4">
        <?php echo $this->areablock('rightAreablock',[
            "allowed"=> ["wysiwyg","image","infobox","snippet","puff","uid","youtube","rss","news","heading"],
            "sorting"=> ["wysiwyg","image","infobox","snippet","puff","uid","youtube","rss","news","heading"],
            "params" => [
                "news" => ['baseuri' => $this->website['baseuri']]
            ]
        ]);?>
    </div>
</div>
