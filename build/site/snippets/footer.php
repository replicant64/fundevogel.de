    </main>
    <footer class="site-footer bg--primary center" role="contentinfo">
      <div class="site-footer_border"></div>
      <div class="wrap">
        <?= $site->footer()->html() ?>
        <nav class="footer-nav">
          <ul class="inline-list spread-out">
            <li><a href="mailto:<?= $site->mail() ?>"><span>info@fundevogel.de</span></a></li>
            <li>|</li>
            <li><a href="<?= url('/unsere-agb') ?>"><span>AGB</span></a></li>
            <li>|</li>
            <li><a href="<?= url('/widerruf') ?>"><span>Widerruf</span></a></li>
            <li>|</li>
            <li><a href="<?= url('/datenschutz') ?>"><span>Datenschutz</span></a></li>
            <li>|</li>
            <li><a href="<?= url('/impressum') ?>"><span>Impressum</span></a></li>
          </ul>
        </nav>
      </div>
    </footer>

    <?php snippet('foot'); ?>

  </body>
</html>
