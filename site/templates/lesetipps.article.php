<?php snippet('header') ?>

<header class="container">
    <time datetime="<?= $page->date()->toDate('Y-m-d') ?>"><?= $page->date()->toDate('d.m.Y') ?></time>
    <h2><?= $page->title()->html() ?></h2>
    <?php if ($page->hasAward()->bool()) snippet('lesetipps/award.intro') ?>
    <?= $page->text()->kt() ?>
</header>
<aside class="wave">
    <?= useSeparator('orange-light', 'top') ?>
    <div class="pt-12 pb-8 bg-orange-light">
        <div class="container lg:px-8 xl:px-12">
            <div class="flex flex-col lg:flex-row">
                <div class="flex-none flex justify-center">
                    <div class="flex items-center mb-6 lg:mb-0">
                        <div class="group relative">
                            <span class="-top-5 -left-5 absolute z-30">
                                <?= useSVG('Mehr anzeigen', 'w-10 h-10 p-2 text-white fill-current bg-red-medium rounded-full', 'plus') ?>
                            </span>
                            <div class="inset-0 w-full h-full absolute opacity-0 group-hover:opacity-100 rounded-lg bg-orange-medium text-shadow cursor-context-menu transition-all z-25 spread-out">
                                <div class="pt-8 px-4">
                                    <div class="lesetipp-overlay-section">
                                    <div class="mb-1 flex items-center">
                                        <?= useSVG('Kategorien', 'lesetipp-overlay-icon', 'folder') ?>
                                        <h4 class="lesetipp-overlay-title"><?= t('Einteilung') ?>:</h4>
                                    </div>
                                        <div class="lesetipp-overlay-body">
                                            <?php foreach ($categories as $category): ?>
                                            <a href="<?= url('lesetipps', ['params' => ['Kategorie' => rawurlencode($category)]]) ?>">
                                                <span><?= $category ?></span>
                                            </a>
                                            <?php e(A::last($categories) === $category, '', ',&nbsp;') ?>
                                            <?php endforeach ?>
                                        </div>
                                    </div>
                                    <div class="lesetipp-overlay-section">
                                        <div class="mb-1 flex items-center">
                                            <?= useSVG('Themen', 'lesetipp-overlay-icon', 'tag') ?>
                                            <h4 class="lesetipp-overlay-title"><?= t('Themen') ?>:</h4>
                                        </div>
                                        <div class="lesetipp-overlay-body">
                                            <?php foreach ($topics as $topic) : ?>
                                                <a class="inline" href="<?= url('lesetipps', ['params' => ['Thema' => rawurlencode($topic)]]) ?>">
                                                    <span><?= $topic ?></span>
                                                </a>
                                                <?php e(A::last($topics) === $topic, '', ',&nbsp;') ?>
                                            <?php endforeach ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?= $page->getBookCover('rounded-lg') ?>
                        </div>
                    </div>
                </div>
                <div class="flex-1 md:ml-16">
                    <div class="lg:text-lg">
                        <?= $page->verdict()->kt() ?>
                    </div>
                    <div class="flex flex-col my-8 text-sm">
                        <div class="flex flex-col sm:flex-row">
                            <div class="mb-4 flex-1 flex items-center">
                                <?= useSVG(t('AutorIn'), 'js-tippy lesetipp-icon', 'bulb') ?>
                                <span class="ml-4">
                                    <?= $page->author()->html() ?>
                                </span>
                            </div>
                            <?php if ($page->illustrator()->isNotEmpty()) : ?>
                            <div class="mb-4 flex-1 flex items-center">
                                <?= useSVG(t('IllustratorIn'), 'js-tippy lesetipp-icon', 'palette') ?>
                                <span class="ml-4">
                                    <?= $page->illustrator()->html() ?>
                                </span>
                            </div>
                            <?php elseif ($page->narrator()->isNotEmpty()) : ?>
                                <div class="mb-4 flex-1 flex items-center">
                                <?= useSVG(t('SprecherIn'), 'js-tippy lesetipp-icon', 'microphone') ?>
                                <span class="ml-4">
                                    <?= $page->narrator()->html() ?>
                                </span>
                            </div>
                            <?php elseif ($page->translator()->isNotEmpty()) : ?>
                            <div class="mb-4 flex-1 flex items-center">
                                <?= useSVG(t('ÜbersetzerIn'), 'js-tippy lesetipp-icon', 'globe') ?>
                                <span class="ml-4">
                                    <?= $page->translator()->html() ?>
                                </span>
                            </div>
                            <?php elseif ($page->participants()->isNotEmpty()) : ?>
                            <div class="mb-4 flex-1 flex items-center">
                                <?= useSVG(t('Mitwirkende'), 'js-tippy lesetipp-icon', 'heart') ?>
                                <span class="ml-4">
                                    <?= $page->participants()->html() ?>
                                </span>
                            </div>
                            <?php endif ?>
                        </div>
                        <div class="flex flex-col sm:flex-row">
                            <div class="mb-4 flex-1 flex items-center">
                                <?= useSVG(t('Verlag'), 'js-tippy lesetipp-icon', 'truck', 'data-tippy-placement="bottom"') ?>
                                <span class="ml-4">
                                    <?= $page->publisher()->html() ?>
                                </span>
                            </div>
                            <div class="mb-4 flex-1 flex items-center">
                                <?= useSVG('ISBN', 'js-tippy lesetipp-icon', 'book-open', 'data-tippy-placement="bottom"') ?>
                                <span class="ml-4">
                                    <?= $page->isbn()->html() ?>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="flex flex-col xs:flex-row justify-between items-center">
                        <div class="flex">
                            <?php if ($age && $period) : ?>
                            <div class="mr-6 sm:mr-8 text-center leading-tight">
                                <span class="block text-lg sm:text-2xl text-orange-dark font-bold"><?= html($age) ?></span>
                                <span class="block text-sm sm:text-lg"><?= $period ?></span>
                            </div>
                            <?php endif ?>
                            <?php if ($page->page_count()->isNotEmpty()) : ?>
                            <div class="mr-6 md:mr-8 text-center leading-tight">
                                <span class="block text-lg sm:text-2xl text-orange-dark font-bold"><?= $page->page_count()->htm() ?></span>
                                <span class="block text-sm sm:text-lg"><?= t('Seiten') ?></span>
                            </div>
                            <?php endif ?>
                            <?php if ($page->duration()->isNotEmpty()) : ?>
                            <div class="mr-6 md:mr-8 text-center leading-tight">
                                <span class="block text-lg sm:text-2xl text-orange-dark font-bold"><?= $page->duration()->htm() ?></span>
                                <span class="block text-sm sm:text-lg"><?= t('Minuten') ?></span>
                            </div>
                            <?php endif ?>
                            <?php if ($page->price()->isNotEmpty()) : ?>
                            <div class="mr-6 md:mr-8 text-center leading-tight">
                                <span class="block text-lg sm:text-2xl text-orange-dark font-bold"><?= $page->price()->html() ?> €</span>
                                <span class="block text-sm sm:text-lg"><?= t('Ladenpreis') ?></span>
                            </div>
                            <?php endif ?>
                        </div>
                        <div class="mt-12 xs:mt-0 flex-none">
                            <?php if ($page->shop()->isNotEmpty()) : ?>
                            <a class="py-3 px-5 sm:py-4 sm:px-6 rounded-full text-white text-shadow bg-red-light hover:bg-red-medium transition-all" href="<?= $page->shop() ?>" target="_blank">
                                <span class="sketch text-2xl select-none"><?= t('Zum Shop') ?> !</span>
                            </a>
                            <?php else : ?>
                            <a class="js-tippy py-3 px-5 sm:py-4 sm:px-6 rounded-full text-white text-shadow bg-red-light hover:bg-red-medium transition-all" href="mailto:<?= $site->mail() ?>" title="<?= t('Bitte besorgen') ?>" target="_blank" data-tippy-theme="fundevogel red">
                                <span class="sketch text-2xl select-none"><?= t('Vergriffen') ?> !</span>
                            </a>
                            <?php endif ?>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <?= useSeparator('orange-light', 'bottom') ?>
</aside>
<?php if ($page->conclusion()->isNotEmpty()) : ?>
<section class="container">
    <?= $page->conclusion()->kt() ?>
</section>
<?php endif ?>
<?php if ($page->isAward()->bool()) : ?>
<?php
    snippet('blocks');
    snippet('lesetipps/award.' . $award['identifier']);
?>
<?php endif ?>
<?php if ($page->hasTranslatedSiblings()) : ?>
<footer class="mt-16">
    <?php snippet('lesetipps/prevnext') ?>
</footer>
<?php endif ?>

<?php snippet('footer') ?>
