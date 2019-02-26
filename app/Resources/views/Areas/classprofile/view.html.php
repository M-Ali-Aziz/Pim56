<?php
/**
 * @var \Pimcore\Templating\PhpEngine $this
 * @var \Pimcore\Templating\PhpEngine $view
 * @var \Pimcore\Templating\GlobalVariables $app
 */
?>
<div id="infographics" class="border bg_white">
    <div class="header">
        <h2><?php echo $this->input("rubrik"); ?></h2>
    </div>
    <div class="applications">
        <div class="infographics-bar-wrap">
            <div class="applications-bar" style="width:<?php echo $this->input("applications-bar"); ?>;">
                <div class="applications-stat"><?php echo $this->input("applications-stat"); ?></div>
            </div>
            <div class="enrolled-bar" style="width:<?php echo $this->input("enrolled-bar"); ?>;">
                <div class="enrolled-stat"><?php echo $this->input("enrolled-stat"); ?></div>
            </div>
            <div class="applications-label">applicants</div>
            <div class="enrolled-label">enrolled</div>
        </div>
    </div>
    <div class="gender">
        <div class="gender-inner">
            <div class="infographics-bar-wrap">
                <div class="male-bar" style="width:<?php echo $this->input("male-bar"); ?>;">
                    <div class="male-stat"><?php echo $this->input("male-bar"); ?></div>
                </div>
                <div class="female-bar" style="width:<?php echo $this->input("female-bar"); ?>;">
                    <div class="female-stat"><?php echo $this->input("female-bar"); ?></div>
                </div>
                <div class="male-label">male</div>
                <div class="female-label">female</div>
            </div>
        </div>
    </div>
    <div class="age-nationalities">
        <div class="age"><span class="text">Age range:</span> <span class="stat"><?php echo $this->input("age-range"); ?></span></div>
        <div class="nationalities"><span class="text">Nationalities:</span> <span class="stat"><?php echo $this->input("nationalities"); ?></span></div>
    </div>
</div>
