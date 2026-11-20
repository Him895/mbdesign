<?php
require_once __DIR__ . '/includes/showcase.php';
require_once __DIR__ . '/includes/projects-lib.php';

$sKey = sc_get('status', 'completed');
$cKey = sc_get('cat');
$ok = isset(PJ_STATUSES[$sKey]) && isset(PJ_CATEGORIES[$cKey]);
if (!$ok) { http_response_code(404); $pageTitle = 'Not Found'; }
else      { $pageTitle = PJ_CATEGORIES[$cKey]['title']; $crumb = PJ_STATUSES[$sKey]['title'] . ' / ' . PJ_CATEGORIES[$cKey]['label']; }

include __DIR__ . '/includes/header.php';
include __DIR__ . '/includes/page-header.php';
sc_styles();
if (!$ok) { sc_missing('projects.php', 'Completed Projects'); include __DIR__ . '/includes/footer.php'; exit; }

$st = PJ_STATUSES[$sKey];
$cat = PJ_CATEGORIES[$cKey];
$list = pj_list($sKey, $cKey);
?>
<main>
<section class="section">
  <div class="wrap">

    <div class="sc-trail reveal">
      <a href="projects.php">Projects</a><i>&rsaquo;</i>
      <a href="<?= e(pj_status_url($sKey)) ?>"><?= e($st['title']) ?></a><i>&rsaquo;</i>
      <span><?= e($cat['title']) ?></span>
    </div>

    <div class="sc-head">
      <div>
        <p class="eyebrow reveal"><?= e($st['tab']) ?></p>
        <h2 class="title reveal" style="--d:.08s"><?= e($cat['title']) ?></h2>
        <span class="rule rule--left reveal" style="--d:.14s"></span>
      </div>
      <nav class="sc-tabs reveal" style="--d:.12s" aria-label="Category">
        <?php foreach (PJ_CATEGORIES as $k => $c): ?>
          <a href="<?= e(pj_cat_url($sKey, $k)) ?>" class="<?= $k === $cKey ? 'on' : '' ?>"><?= e($c['label']) ?> <small><?= count(pj_list($sKey, $k)) ?></small></a>
        <?php endforeach; ?>
      </nav>
    </div>

    <?php if ($list): ?>
      <div class="sc-grid">
        <?php foreach ($list as $i => $p):
          $sub = trim($p['location'] . ($p['year'] !== '' && $p['year'] !== null ? ' · ' . $p['year'] : ''), ' ·'); ?>
          <div class="reveal" style="--d:<?= ($i % 3) * 0.1 ?>s">
            <a class="sc-card" href="<?= e(pj_url($p)) ?>">
              <div class="sc-media" style="aspect-ratio:4/3">
                <span class="sc-tag"><?= e($st['tab']) ?></span>
                <?php sc_media(pj_cover($p), $p['title']); ?>
              </div>
              <div class="sc-card__b">
                <?php if ($sub !== ''): ?><em><?= e($sub) ?></em><?php endif; ?>
                <h3><?= e($p['title']) ?></h3>
                <span class="sc-more">View More <i>&rarr;</i></span>
              </div>
            </a>
          </div>
        <?php endforeach; ?>
      </div>
    <?php else: ?>
      <div class="sc-empty reveal">
        <h2 class="title">Coming soon</h2>
        <p><?= e($cat['title']) ?> (<?= e($st['tab']) ?>) abhi add nahi hue hain.</p>
        <a class="btn" href="<?= e(pj_status_url($sKey)) ?>">Back to <?= e($st['title']) ?></a>
      </div>
    <?php endif; ?>
  </div>
</section>
</main>
<?php include __DIR__ . '/includes/footer.php'; ?>