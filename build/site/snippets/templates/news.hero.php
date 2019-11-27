<?php
  if ($hero = $page->image('hero.jpg')) :
  $thumb = $hero->thumb('news.hero');
?>
<figure class="fig has-hover">
  <img src="<?= $thumb->url() ?>" title="<?= $hero->titleAttribute() ?>" alt="<?= $hero->altAttribute() ?>" width="<?= $thumb->width() ?>" height="<?= $thumb->height() ?>">
  <figcaption class="sketch bg--primary"><?= $hero->caption()->html() ?></figcaption>
</figure>
<?php endif ?>