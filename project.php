<?php
require_once __DIR__ . '/includes/showcase.php';
require_once __DIR__ . '/includes/projects-lib.php';

$p = pj_find(sc_get('id'));
if (!$p) { http_response_code(404); $pageTitle = 'Not Found'; }
else      { $pageTitle = $p['title']; $crumb = 'Project'; }

include __DIR__ . '/includes/header.php';
include __DIR__ . '/includes/page-header.php';
sc_styles();
?>
<style>.phead__title{font-size:clamp(2rem,5vw,3.8rem)}</style>
<?php
if (!$p) { sc_missing('projects.php', 'All Projects'); include __DIR__ . '/includes/footer.php'; exit; }

$sKey = $p['status_key']; $cKey = $p['cat_key'];
$st  = $sKey !== '' ? PJ_STATUSES[$sKey]   : null;
$cat = $cKey !== '' ? PJ_CATEGORIES[$cKey] : null;
$shots = pj_gallery($p);

$meta = [];
foreach (['Location' => 'location', 'Year' => 'year', 'Scale / Area' => 'area', 'Client' => 'client'] as $label => $col) {
    if (isset($p[$col]) && trim((string)$p[$col]) !== '') $meta[$label] = trim((string)$p[$col]);
}

// prev / next: usi status + category ke andar
$same = ($sKey !== '' && $cKey !== '') ? pj_list($sKey, $cKey) : [];
$prev = $next = null;
foreach ($same as $i => $q) {
    if ($q['id'] == $p['id']) {
        $next = isset($same[$i - 1]) ? $same[$i - 1] : null;   // newer
        $prev = isset($same[$i + 1]) ? $same[$i + 1] : null;   // older
        break;
    }
}
?>
<main>
<section class="section">
  <div class="wrap">

    <div class="sc-trail reveal">
      <a href="projects.php">Projects</a><i>&rsaquo;</i>
      <?php if ($st): ?><a href="<?= e(pj_status_url($sKey)) ?>"><?= e($st['title']) ?></a><i>&rsaquo;</i><?php endif; ?>
      <?php if ($st && $cat): ?><a href="<?= e(pj_cat_url($sKey, $cKey)) ?>"><?= e($cat['title']) ?></a><i>&rsaquo;</i><?php endif; ?>
      <span><?= e($p['title']) ?></span>
    </div>

    <div class="sc-view">
      <aside class="sc-info reveal">
        <?php if ($st): ?><span class="sc-chip"><?= e($st['tab']) ?></span><?php endif; ?>
        <h2><?= e($p['title']) ?></h2>
        <?php if ($meta): ?>
          <ul class="sc-meta">
            <?php if ($cat): ?><li><span>Category</span><?= e($cat['label']) ?></li><?php endif; ?>
            <?php foreach ($meta as $k => $v): ?><li><span><?= e($k) ?></span><?= e($v) ?></li><?php endforeach; ?>
          </ul>
        <?php endif; ?>
        <?php if (trim((string)$p['description']) !== ''): ?><p><?= nl2br(e($p['description'])) ?></p><?php endif; ?>
        <div class="sc-btns">
          <a href="contact.php" class="btn">Enquire About This</a>
          <?php if ($st && $cat): ?><a href="<?= e(pj_cat_url($sKey, $cKey)) ?>" class="btn btn--ghost">&larr; All <?= e($cat['label']) ?></a><?php endif; ?>
        </div>
      </aside>

      <div>
        <?php if ($shots): ?>
          <div class="sc-shots">
            <?php foreach ($shots as $i => $f): ?>
              <div class="reveal" style="--d:<?= min($i, 4) * 0.08 ?>s;<?= $i === 0 ? 'grid-column:1/-1' : '' ?>">
                <a class="sc-zoom" data-lb href="<?= e(sc_img('', $f)) ?>" data-cap="<?= e($p['title']) ?>" style="display:block;position:relative;border-radius:16px;overflow:hidden;line-height:0;background:var(--soft)">
                  <img src="<?= e(sc_img('', $f)) ?>" alt="<?= e($p['title']) ?>" loading="lazy" style="width:100%;height:auto" onerror="this.parentNode.parentNode.remove()">
                </a>
              </div>
            <?php endforeach; ?>
          </div>
        <?php else: ?>
          <div class="sc-empty"><h2 class="title">Photos coming soon</h2><p>Is project ki photos jald add hongi.</p></div>
        <?php endif; ?>
      </div>
    </div>

    <?php if ($prev || $next): ?>
      <div class="sc-pager reveal">
        <?php if ($prev): ?><a href="<?= e(pj_url($prev)) ?>"><small>&larr; Previous project</small><b><?= e($prev['title']) ?></b></a><?php else: ?><span></span><?php endif; ?>
        <?php if ($next): ?><a class="nx" href="<?= e(pj_url($next)) ?>"><small>Next project &rarr;</small><b><?= e($next['title']) ?></b></a><?php else: ?><span></span><?php endif; ?>
      </div>
    <?php endif; ?>
  </div>
</section>
</main>
<?php sc_lightbox(); include __DIR__ . '/includes/footer.php'; ?>