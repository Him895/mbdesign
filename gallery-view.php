<?php
require_once __DIR__ . '/includes/showcase.php';
$all = sc_gallery_all();
$g = sc_gallery_find(sc_get('g'));
if (!$g) { http_response_code(404); $pageTitle = 'Not Found'; }
else      { $pageTitle = $g['title']; $crumb = 'Gallery'; }

include __DIR__ . '/includes/header.php';
include __DIR__ . '/includes/page-header.php';
sc_styles();
?>
<style>.phead__title{font-size:clamp(2rem,5vw,3.8rem)}</style>
<?php
if (!$g) { sc_missing('gallery.php', 'Back to Gallery'); include __DIR__ . '/includes/footer.php'; exit; }

$prev = $g['i'] > 0 ? $all[$g['i'] - 1] : null;
$next = $g['i'] < count($all) - 1 ? $all[$g['i'] + 1] : null;
?>
<main>
<section class="section">
  <div class="wrap">
    <div class="sc-trail reveal">
      <a href="gallery.php">Gallery</a><i>&rsaquo;</i><span><?= e($g['title']) ?></span>
    </div>

    <div class="sc-head">
      <div>
        <p class="eyebrow reveal"><?= count($g['images']) ?> <?= count($g['images']) === 1 ? 'Photo' : 'Photos' ?></p>
        <h2 class="title reveal" style="--d:.08s"><?= e($g['title']) ?></h2>
        <span class="rule rule--left reveal" style="--d:.14s"></span>
        <?php if (!empty($g['text'])): ?><p class="reveal" style="max-width:640px;color:#3c372d"><?= e($g['text']) ?></p><?php endif; ?>
      </div>
    </div>

    <?php if ($g['images']): ?>
      <div class="sc-masonry">
        <?php foreach ($g['images'] as $i => $f): $src = sc_img(SC_GALLERY_DIR, $f); ?>
          <a class="sc-zoom reveal" style="--d:<?= ($i % 3) * 0.08 ?>s" data-lb href="<?= e($src) ?>" data-cap="<?= e($g['title']) ?>">
            <img src="<?= e($src) ?>" alt="<?= e($g['title']) ?>" loading="lazy" onerror="this.parentNode.remove()">
          </a>
        <?php endforeach; ?>
      </div>
    <?php else: ?>
      <div class="sc-empty"><h2 class="title">Photos coming soon</h2></div>
    <?php endif; ?>

    <?php if ($prev || $next): ?>
      <div class="sc-pager reveal">
        <?php if ($prev): ?><a href="<?= e(sc_gallery_url($prev)) ?>"><small>&larr; Previous</small><b><?= e($prev['title']) ?></b></a><?php else: ?><span></span><?php endif; ?>
        <?php if ($next): ?><a class="nx" href="<?= e(sc_gallery_url($next)) ?>"><small>Next &rarr;</small><b><?= e($next['title']) ?></b></a><?php else: ?><span></span><?php endif; ?>
      </div>
    <?php endif; ?>
  </div>
</section>
</main>
<?php sc_lightbox(); include __DIR__ . '/includes/footer.php'; ?>