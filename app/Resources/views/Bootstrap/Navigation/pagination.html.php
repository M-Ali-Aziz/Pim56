<?php
/**
 * @var \Pimcore\Templating\PhpEngine $this
 * @var \Pimcore\Templating\PhpEngine $view
 * @var \Pimcore\Templating\GlobalVariables $app
 */
?>
<nav aria-label="Pagination" class="my-3">
    <ul class="pagination pagination-sm">
        <!-- Previous page link -->
        <?php if (isset($this->paginatorPages->previous)): ?>
            <li class="page-item">
                <a class="page-link" href="<?= $this->urlprefix . $this->paginatorPages->previous; ?>"><span class="page-icon"><i class="fal fa-chevron-left fa-sm"></i></span><span class="page-label"> Föregående</span></a>
            </li>
        <?php else: ?>
            <li class="page-item disabled">
                <a class="page-link" href="<?= $this->urlprefix . $this->paginatorPages->previous; ?>"><span class="page-icon"><i class="fal fa-chevron-left fa-sm"></i></span><span class="page-label"> Föregående</span></a>
            </li>
        <?php endif; ?>
        <!-- Numbered page links -->
        <?php foreach ($this->paginatorPages->pagesInRange as $page): ?>
            <?php if ($page != $this->paginatorPages->current): ?>
                <li class="page-item">
                    <a class="page-link" href="<?= $this->urlprefix . $page; ?>"><?= $page; ?></a>
                </li>
            <?php else: ?>
                <li class="page-item active">
                    <a class="page-link" href="<?= $this->urlprefix . $page; ?>"><?= $page; ?></a>
                </li>
            <?php endif; ?>
        <?php endforeach; ?>
        <!-- Next page link -->
        <?php if (isset($this->paginatorPages->next)): ?>
            <li class="page-item">
                <a class="page-link" href="<?= $this->urlprefix . $this->paginatorPages->next; ?>"><span class="page-label">Nästa </span><span class="page-icon"><i class="fal fa-chevron-right fa-sm"></i></span></a>
            </li>
        <?php else: ?>
            <li class="page-item disabled">
                <a class="page-link" href="<?= $this->urlprefix . $this->paginatorPages->next; ?>"><span class="page-label">Nästa </span><span class="page-icon"><i class="fal fa-chevron-right fa-sm"></i></span></a>
            </li>
        <?php endif; ?>
    </ul>
</nav>
