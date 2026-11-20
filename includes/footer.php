<?php $c = $site['contact']; ?>
<footer class="footer" id="contact">
  <div class="wrap cta">
    <p class="eyebrow reveal">Let's talk</p>
    <h2 class="reveal" style="--d:.08s">Let's build something remarkable.</h2>
    <a class="cta__mail reveal" style="--d:.16s" href="mailto:<?= e($c['emails'][0]) ?>"><?= e($c['emails'][0]) ?></a>
  </div>
  <div class="wrap footer__grid">
    <div class="reveal">
      <h4>Address</h4>
      <p><b>Head Office :</b><br><?= e($c['head'][0]) ?><br><?= e($c['head'][1]) ?></p>
      <p><b>Branch Office :</b><br><?= e($c['branch'][0]) ?><br><?= e($c['branch'][1]) ?></p>
    </div>
    <div class="reveal" style="--d:.12s">
      <h4>Email</h4>
      <?php foreach ($c['emails'] as $m): ?><p><a href="mailto:<?= e($m) ?>"><?= e($m) ?></a></p><?php endforeach; ?>
      <h4>Contact</h4>
      <?php foreach ($c['phones'] as $p): ?><p><a href="tel:<?= e(str_replace(' ', '', $p)) ?>"><?= e($p) ?></a></p><?php endforeach; ?>
    </div>
    <div class="reveal" style="--d:.24s">
      <h4>Follow</h4>
      <div class="social">
        <a href="<?= e($c['social']['facebook']) ?>" aria-label="Facebook"><svg viewBox="0 0 24 24"><path d="M14 8V6.5c0-.7.3-1 1-1h2V2h-3c-3 0-4 2-4 4.2V8H8v3.5h2V22h4v-10.5h2.7L17 8h-3z"/></svg></a>
        <a href="<?= e($c['social']['instagram']) ?>" aria-label="Instagram"><svg viewBox="0 0 24 24"><path d="M7 2h10a5 5 0 015 5v10a5 5 0 01-5 5H7a5 5 0 01-5-5V7a5 5 0 015-5zm0 2a3 3 0 00-3 3v10a3 3 0 003 3h10a3 3 0 003-3V7a3 3 0 00-3-3H7zm5 3.5A4.5 4.5 0 1112 16.5 4.5 4.5 0 0112 7.5zm0 2A2.5 2.5 0 1012 14.5 2.5 2.5 0 0012 9.5zM17.5 6a1 1 0 110 2 1 1 0 010-2z"/></svg></a>
        <a href="<?= e($c['social']['youtube']) ?>" aria-label="YouTube"><svg viewBox="0 0 24 24"><path d="M21.6 7.2a2.5 2.5 0 00-1.8-1.8C18.2 5 12 5 12 5s-6.2 0-7.8.4A2.5 2.5 0 002.4 7.2C2 8.8 2 12 2 12s0 3.2.4 4.8a2.5 2.5 0 001.8 1.8C5.8 19 12 19 12 19s6.2 0 7.8-.4a2.5 2.5 0 001.8-1.8c.4-1.6.4-4.8.4-4.8s0-3.2-.4-4.8zM10 15V9l5.2 3-5.2 3z"/></svg></a>
      </div>
    </div>
  </div>
  <div class="wrap footer__bottom">
    <span>&copy; <?= date('Y') ?> <?= e($site['name']) ?>. All Rights Reserved.</span>
    <span>Design By : <a href="https://kvorage.in" target="_blank" rel="noopener">kvorage.in</a></span>
  </div>
</footer>

<a href="#top" class="totop" id="totop" aria-label="Back to top">&#8593;</a>
<script src="assets/js/main.js"></script>
</body>
</html>
