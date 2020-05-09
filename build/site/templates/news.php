<?php snippet('header') ?>

<article class="mb-16">
    <header class="container">
        <?= $page->text()->kt() ?>
        <?php
            if ($hero = $page->image('hero.jpg')) :
            $thumb = $hero->thumb('news.hero');
        ?>
        <div class="text-center">
            <figure class="group inline-block shadow-cover rounded-lg overflow-hidden relative">
                <img class="group-hover:opacity-75 rounded-t-lg transition-all" src="<?= $thumb->url() ?>" title="<?= $hero->titleAttribute() ?>" alt="<?= $hero->altAttribute() ?>" width="<?= $thumb->width() ?>" height="<?= $thumb->height() ?>">
                <figcaption class="transform py-2 group-hover:-translate-y-full text-5xl absolute w-full sketch bg-red-medium transition-all"><?= $hero->caption()->html() ?></figcaption>
            </figure>
        </div>
        <?php endif ?>
    </header>
    <hr>
    <section class="js-list">
        <h2 class="mb-12 text-center"><?= t('home_ueberschrift-liste') ?></h2>
        <?php foreach($news as $article) : ?>
            <?php
                $images = $article->images();
            ?>
            <article class="js-article animation-fade-in">
                <div class="<?php e(count($images) < 3, 'container') ?>">
                    <div class="flex flex-col <?php e(count($images) < 3, 'lg:flex-row ') ?> justify-center">
                        <?php if ($images) : ?>
                        <?php if (count($images) > 2) : ?>
                        <aside class="mt-12 overflow-hidden">
                        <?= $site->useSeparator('orange-light', 'top') ?>
                        <div class="py-12 bg-orange-light">
                        <div class="container xl:px-0">
                        <?php endif ?>

                        <div class="<?php e(count($images) < 3, 'lg:mt-10 mb-8 lg:mb-0 ') ?>flex-none text-center lightgallery">
                            <?php foreach ($images as $image) : ?>
                            <?php
                                $id = $article->uid();
                                if ($image) :
                                $croppedImage = $image->thumb('news.article.full');
                                $thumb = $image->thumb('news.article.image');
                            ?>
                            <figure class="<?php e(count($images) > 2, 'm-4 ') ?>inline-block<?php e(count($images) < 3, ' lg:ml-12') ?><?php e(count($images) === 2, ' last:ml-6') ?> rounded-lg" data-lightgallery data-src="<?= $croppedImage->url() ?>" data-sub-html="<?= $image->caption()->html() ?>">
                                <img class="w-32 h-32 lg:w-48 lg:h-48 xl:w-56 xl:h-56 shadow-cover rounded-lg" data-layzr="<?= $thumb->url() ?>" title="<?= $image->caption()->html() ?>" alt="<?= $image->alt()->html() ?>" width="<?= $thumb->width() ?>" height="<?= $thumb->height() ?>">
                            </figure>
                            <?php endif ?>
                            <?php endforeach ?>
                        </div>

                        <?php if (count($images) > 2) : ?>
                        </div>
                        </div>
                        <?= $site->useSeparator('orange-light', 'bottom') ?>
                        </aside>
                        <?php endif ?>
                        <?php endif ?>

                        <div class="flex-initial <?php e(count($images) < 3, 'lg:') ?>order-first flex justify-center">
                            <div class="<?php e(count($images) > 2, 'container') ?>">
                                <time datetime="<?= $article->date()->toDate('Y-m-d') ?>">
                                    <?= $article->date()->toDate('d.m.Y') ?>
                                </time>
                                <?php e($article->subtitle()->isNotEmpty(), '<span class="subtitle">&mdash; ' . $article->subtitle()->html() . '</span>') ?>
                                <h3><?= $article->title()->html() ?></h3>
                                <?= $article->text()->kirbytext() ?>
                            </div>
                        </div>
                    </div>
                </div>

                <?php e($article !== $articleLast, '<hr class="max-w-sm">', $nothingLeft) ?>

            </article>
        <?php endforeach ?>
    </section>

    <footer class="container">
        <nav class="js-hide mb-12 flex sketch text-5xl select-none">
            <?php if ($pagination->hasPrevPage()) : ?>
            <a class="h-20 flex-1 flex justify-around items-center text-white rounded-l-lg bg-red-light hover:bg-red-medium transition-all outline-none" href="<?= $pagination->prevPageURL() ?>" rel="prev" title="<?= t('home_frueheres--title') ?>">
                <?= $site->useSVG(t('home_frueheres'), 'w-auto h-10 fill-current', 'arrow-left') ?>
                <span class="hidden md:inline"><?= t('home_frueheres') ?></span>
            </a>
            <?php else : ?>
            <span class="h-20 flex-1 rounded-l-lg bg-red-light opacity-75 cursor-not-allowed"></span>
            <?php
                endif;
                if ($pagination->hasNextPage()) :
            ?>
            <a class="js-target h-20 flex-1 flex justify-around items-center text-white rounded-r-lg bg-red-light hover:bg-red-medium transition-all outline-none" href="<?= $pagination->nextPageURL() ?>" rel="next" title="<?= t('home_aelteres--title') ?>">
                <span class="hidden md:inline"><?= t('home_aelteres') ?></span>
                <?= $site->useSVG(t('home_aelteres'), 'w-auto h-10 fill-current', 'arrow-right') ?>
            </a>
            <?php else : ?>
            <span class="h-20 flex-1 rounded-r-lg bg-red-light opacity-75 cursor-not-allowed"></span>
            <?php endif ?>
        </nav>
        <button class="js-more w-full h-20 flex-1 flex justify-around items-center text-white rounded-lg bg-red-light hover:bg-red-medium transition-all outline-none nojs-hidden" type="button" title="<?= t('home_mehr-anzeigen--title') ?>">
            <span class="sketch text-5xl select-none"><?= t('home_mehr-anzeigen') ?></span>
        </button>
    </footer>
</article>

<?php snippet('footer') ?>
