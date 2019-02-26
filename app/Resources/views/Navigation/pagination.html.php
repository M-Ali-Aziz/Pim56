<?php
/**
 * @var \Pimcore\Templating\PhpEngine $this
 * @var \Pimcore\Templating\PhpEngine $view
 * @var \Pimcore\Templating\GlobalVariables $app
 */
?>
<!--eri-no-index-->
<div class="pagination">
    <p class="paging clearfix">
        <!-- First page link -->
        <?php if (isset($this->paginatorPages->previous)): ?>
            <a href="<?= $this->urlprefix . $this->paginatorPages->first; ?>">&laquo;</a>
        <?php else: ?>
            <span class="disabled">&laquo;</span>
        <?php endif; ?>
        <!-- Previous page link -->
        <?php if (isset($this->paginatorPages->previous)): ?>
            <a href="<?= $this->urlprefix . $this->paginatorPages->previous; ?>">&lsaquo;</a>
        <?php else: ?>
            <span class="disabled">&lsaquo;</span>
        <?php endif; ?>
        <!-- Numbered page links -->
        <?php foreach ($this->paginatorPages->pagesInRange as $page): ?>
            <?php if ($page != $this->paginatorPages->current): ?>
                <a href="<?= $this->urlprefix . $page; ?>"><?= $page; ?></a>
            <?php else: ?>
                <strong class="active_letter"><?= $page; ?></strong>
            <?php endif; ?>
        <?php endforeach; ?>
        <!-- Next page link -->
        <?php if (isset($this->paginatorPages->next)): ?>
            <a href="<?= $this->urlprefix . $this->paginatorPages->next; ?>">&rsaquo;</a>
        <?php else: ?>
            <span class="disabled">&rsaquo;</span>
        <?php endif; ?>
        <!-- Last page link -->
        <?php if (isset($this->paginatorPages->next)): ?>
            <a href="<?= $this->urlprefix . $this->paginatorPages->last; ?>">&raquo;</a>
        <?php else: ?>
            <span class="disabled">&raquo;</span>
        <?php endif; ?>
    </p>
    <p class="paging">
        <span>Visar sida <?= $this->paginatorPages->current; ?> av <?= $this->paginatorPages->last; ?></span>
    </p>
</div>
<!--/eri-no-index-->
