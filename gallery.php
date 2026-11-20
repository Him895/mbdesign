<?php
require_once __DIR__ . '/includes/showcase.php';
$pageTitle = 'Gallery';
include __DIR__ . '/includes/header.php';
include __DIR__ . '/includes/page-header.php';
sc_styles();
$items = sc_gallery_all();
?>
<main>
<section class="section">
  <div class="wrap">
    <div class="sc-head">
      <div>
        <p class="eyebrow reveal">Portfolio</p>
        <h2 class="title reveal" style="--d:.08s">Gallery</h2>
        <span class="rule rule--left reveal" style="--d:.14s"></span>
      </div>
      <p class="sc-count reveal" style="--d:.1s"><?= count($items) ?> collections</p>
    </div>

    <?php if ($items): ?>
      <div class="sc-mosaic">
        <?php foreach ($items as $i => $g): ?>
          <div class="sc-cell reveal" style="--d:<?= ($i % 3) * 0.1 ?>s">
            <a class="sc-tile" href="<?= e(sc_gallery_url($g)) ?>">
              <div class="sc-media" style="position:absolute;inset:0"><?php sc_media(sc_cover(SC_GALLERY_DIR, $g['images']), $g['title']); ?></div>
              <span class="sc-tile__n"><?= sc_pad($i + 1) ?></span>
              <div class="sc-tile__cap">
                <h3><?= e($g['title']) ?></h3>
                <span class="sc-more">View More <i>&rarr;</i></span>
              </div>
            </a>
          </div>
        <?php endforeach; ?>
      </div>
    <?php else: ?>
      <div class="sc-empty"><h2 class="title">Coming soon</h2><p>Gallery jald add hogi.</p></div>
    <?php endif; ?>
  </div>
</section>
</main>
<?php include __DIR__ . '/includes/footer.php'; ?>