<?php
$pageTitle = 'Terms & Conditions';
include __DIR__ . '/includes/header.php';
include __DIR__ . '/includes/page-header.php';
$clauses = require __DIR__ . '/includes/terms-data.php';
?>
<main>
<section class="section">
  <div class="wrap doc">

    <nav class="toc" aria-label="Clauses">
      <h4>Clauses</h4>
      <?php foreach ($clauses as $i => $c): ?>
        <a href="#c<?= (int)$c['n'] ?>" class="<?= $i === 0 ? 'on' : '' ?>"><i><?= (int)$c['n'] ?></i><?= e($c['title']) ?></a>
      <?php endforeach; ?>
    </nav>

    <div class="doc__body">
      <div class="terms-head reveal">
        <p class="eyebrow">Conditions of Engagement</p>
        <h2>Comprehensive Architectural Services</h2>
      </div>

      <?php foreach ($clauses as $c): ?>
        <section class="blk clause" id="c<?= (int)$c['n'] ?>">
          <div class="clause__h reveal">
            <span><?= (int)$c['n'] ?></span>
            <h2><?= e($c['title']) ?></h2>
          </div>

          <?php if (!empty($c['intro'])): ?><p class="body reveal"><?= e($c['intro']) ?></p><?php endif; ?>

          <?php if (!empty($c['items'])): ?>
            <ul class="items">
              <?php foreach ($c['items'] as $it): ?>
                <li class="reveal"><b><?= e($it[0]) ?></b><span><?= e($it[1]) ?></span></li>
              <?php endforeach; ?>
            </ul>
          <?php endif; ?>

          <?php foreach ($c['groups'] ?? [] as $g): ?>
            <div class="stage reveal"><span><?= e($g['stage']) ?></span><h4><?= e($g['name']) ?></h4></div>
            <ul class="items">
              <?php foreach ($g['items'] as $it): ?>
                <li class="reveal"><b><?= e($it[0]) ?></b><span><?= e($it[1]) ?></span></li>
              <?php endforeach; ?>
            </ul>
          <?php endforeach; ?>

          <?php if (!empty($c['payments'])): ?>
            <ol class="pay">
              <?php foreach ($c['payments'] as $p): ?>
                <li class="reveal">
                  <div class="pay__top"><strong><?= e($p[0]) ?></strong><em><?= e($p[3]) ?></em></div>
                  <p><?= e($p[1]) ?></p>
                  <small><?= e($p[2]) ?></small>
                </li>
              <?php endforeach; ?>
            </ol>
          <?php endif; ?>
        </section>
      <?php endforeach; ?>

      <div class="sign reveal">
        <span>For and behalf of</span>
        <b>M. B. DESIGN & BUILD</b>
      </div>
    </div>

  </div>
</section>
</main>
<?php include __DIR__ . '/includes/footer.php'; ?>
