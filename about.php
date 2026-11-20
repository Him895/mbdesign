<?php
$pageTitle = 'About Us';
include __DIR__ . '/includes/header.php';
include __DIR__ . '/includes/page-header.php';
$story = $site['story'];
$principles = [
    ['Team Approach',       $story[2]],
    ['Creative Thinking',   $story[3]],
    ['Open-Minded',         $story[4]],
];
$team = $site['team'];
?>
<main>

  <!-- INTRO -->
  <section class="section">
    <div class="wrap intro">
      <div class="pic reveal">
        <img src="<?= e($site['about_img']) ?>" alt="MB Design & Build interior" onerror="this.remove()">
        <div class="pic__badge"><b>2009</b><span>Since</span></div>
      </div>
      <div>
        <p class="eyebrow reveal">Who we are</p>
        <h2 class="title reveal" style="--d:.08s">About us</h2>
        <span class="rule rule--left reveal" style="--d:.14s"></span>
        <p class="quote reveal" style="--d:.18s"><?= e($story[0]) ?></p>
        <p class="lead reveal" style="--d:.24s"><?= e($story[1]) ?></p>
        <a href="firm.php" class="btn reveal" style="--d:.3s">Firm Resources</a>
      </div>
    </div>

    <div class="wrap">
      <div class="principles">
        <?php foreach ($principles as $i => $p): ?>
          <div class="pr reveal" style="--d:<?= $i * 0.12 ?>s">
            <span class="pr__n">0<?= $i + 1 ?></span>
            <h3><?= e($p[0]) ?></h3>
            <p><?= e($p[1]) ?></p>
          </div>
        <?php endforeach; ?>
      </div>
    </div>
  </section>

  <!-- TEAM -->
  <section class="section team">
    <div class="wrap">
      <p class="eyebrow reveal">The people</p>
      <h2 class="title title--light reveal" style="--d:.08s">Our Team Members</h2>
      <div class="team__grid">
        <?php foreach ($team as $i => $m): ?>
          <article class="person<?= $i === 0 ? ' person--lead' : '' ?> reveal" style="--d:<?= $i * 0.1 ?>s">
            <span class="person__ph"><?= e(initials($m['name'])) ?></span>
            <img src="<?= e($m['img']) ?>" alt="<?= e($m['name']) ?>" loading="lazy" onerror="this.remove()">
            <div class="person__info">
              <h3><?= e($m['name']) ?></h3>
              <p><?= e($m['role']) ?></p>
            </div>
          </article>
        <?php endforeach; ?>
      </div>
    </div>
  </section>

</main>
<?php include __DIR__ . '/includes/footer.php'; ?>
