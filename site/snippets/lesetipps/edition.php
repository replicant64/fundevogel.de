<?php
    $isDossier = $page->intendedTemplate() == 'contact.press';
    $class = $isDossier ? 'rounded-lg' : 'rounded-t-lg';
?>

<a class="<?php e($page->intendedTemplate() != 'lesetipps.archive', 'last:ml-4 xs:last:ml-6 sm:last:ml-10 ') ?> group table relative" href="<?= $edition->url() ?>" target="_blank">
    <figure class="rounded-lg">
        <?= $edition->getFront($class) ?>
        <?php if (!$isDossier) : ?>
        <figcaption class="small-caption is-pdf"><?= $caption ?></figcaption>
        <?php endif ?>
    </figure>
    <?php snippet('download', ['file' => $edition]) ?>
</a>
