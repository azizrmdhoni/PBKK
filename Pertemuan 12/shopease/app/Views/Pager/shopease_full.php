<?php

use CodeIgniter\Pager\PagerRenderer;

/**
 * Template pagination ShopEase.
 *
 * @var PagerRenderer $pager
 */
$pager->setSurroundCount(2);
?>
<nav class="pager" aria-label="Navigasi halaman">
    <ul class="pagination">
        <?php if ($pager->hasPrevious()): ?>
            <li><a href="<?= $pager->getFirst() ?>" aria-label="Halaman pertama">&laquo;</a></li>
            <li><a href="<?= $pager->getPrevious() ?>" aria-label="Halaman sebelumnya">&lsaquo;</a></li>
        <?php endif; ?>

        <?php foreach ($pager->links() as $link): ?>
            <li<?= $link['active'] ? ' class="active"' : '' ?>>
                <a href="<?= $link['uri'] ?>"<?= $link['active'] ? ' aria-current="page"' : '' ?>><?= $link['title'] ?></a>
            </li>
        <?php endforeach; ?>

        <?php if ($pager->hasNext()): ?>
            <li><a href="<?= $pager->getNext() ?>" aria-label="Halaman berikutnya">&rsaquo;</a></li>
            <li><a href="<?= $pager->getLast() ?>" aria-label="Halaman terakhir">&raquo;</a></li>
        <?php endif; ?>
    </ul>
</nav>
