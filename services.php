<?php
$pageTitle = 'Our Services';
include __DIR__ . '/includes/header.php';
include __DIR__ . '/includes/page-header.php';

/* Service name + image. Images yahan rakho: assets/img/services/  */
$services = [
    ['Architectural Consultants',                                       'assets/img/pr8.jpg'],
    ['Landscape Designing',                                             'assets/img/g3.jpg'],
    ['Interior Designing',                                              'assets/img/g7.jpg'],
    ['Vastu Shastra Consultants',                                       'assets/img/g6.jpg'],
    ['Buildings Construction',                                          'assets/img/pr25.jpg'],
    ['Pre-Design Services',                                             'assets/img/g1.jpg'],
    ['Master Planning',                                                 'assets/img/m.jpg'],
    ['3D-Views Designing & Walkthrough',                                'assets/img/ser.jpg'],
    ['Turn Key Projects ( Residential & Commercial )',                  'assets/img/3d.jpg'],
    ['Sanctioning From Various Government / Non - Government Authorities', 'assets/img/gov.jpg'],
];
$pad = function ($i) { return str_pad($i + 1, 2, '0', STR_PAD_LEFT); };
?>
<style>
.sv-intro{max-width:720px;margin-bottom:60px}
.sv{display:grid;grid-template-columns:1.15fr 1fr;gap:80px;align-items:start}
.sv-list{border-top:1px solid #e6dfcb}
.sv-item{position:relative;display:grid;grid-template-columns:56px 1fr 30px;align-items:center;gap:10px;padding:26px 0;border-bottom:1px solid #e6dfcb;cursor:pointer;outline:0;transition:padding .5s var(--ease)}
.sv-item::after{content:"";position:absolute;left:0;bottom:-1px;height:2px;width:0;background:var(--gold);transition:width .6s var(--ease)}
.sv-n{font-family:var(--h);font-size:1.15rem;color:var(--gold-d)}
.sv-item h3{font-family:var(--h);font-size:clamp(1.5rem,2.6vw,2.2rem);line-height:1.15;font-weight:600;color:#a39d8f;transition:color .4s}
.sv-arrow{opacity:0;transform:translateX(-10px);transition:.4s var(--ease);color:var(--gold-d);font-size:1.5rem}
.sv-item.on{padding-left:18px}
.sv-item.on::after{width:100%}
.sv-item.on h3{color:var(--ink)}
.sv-item.on .sv-arrow{opacity:1;transform:none}
.sv-inline{display:none}
.sv-stage{position:sticky;top:110px}

/* ✅ CHANGED: 4/5 → 4/3 (box shape, less stretching = sharper image) */
.sv-frame{position:relative;isolation:isolate;aspect-ratio:4/3;border-radius:22px;overflow:hidden;background:linear-gradient(135deg,var(--gold-d),var(--ink2));box-shadow:0 40px 80px rgba(60,45,10,.28)}
.sv-frame::after{content:"";position:absolute;inset:0;background:linear-gradient(to top,rgba(10,8,4,.85),transparent 45%);z-index:1;pointer-events:none}

/* ✅ CHANGED: scale(1.08) → scale(1) — no zoom blur */
.sv-slide{position:absolute;inset:0;opacity:0;transform:scale(1);transition:opacity .7s var(--ease),transform 1.2s var(--ease)}
.sv-slide.on{opacity:1;transform:scale(1)}

.sv-slide img{position:absolute;inset:0;width:100%;height:100%;object-fit:cover}
.sv-ph{position:absolute;inset:0;display:grid;place-items:center;font-family:var(--h);font-size:8rem;font-weight:700;color:rgba(255,255,255,.28)}
.sv-cap{position:absolute;left:26px;right:26px;bottom:24px;z-index:2;color:#fff;display:flex;gap:14px;align-items:baseline}
.sv-cap b{font-family:var(--h);font-size:2.2rem;color:var(--gold-l)}
.sv-cap span{font-family:var(--h);font-size:1.5rem;line-height:1.2}
.sv-cta{margin-top:90px;padding:50px 40px;border-radius:22px;background:var(--ink);color:#fff;display:flex;justify-content:space-between;align-items:center;gap:24px;flex-wrap:wrap}
.sv-cta h3{font-family:var(--h);font-size:clamp(1.8rem,3.4vw,2.6rem);line-height:1.15}
@media(max-width:980px){
  .sv{grid-template-columns:1fr;gap:0}
  .sv-stage{display:none}
  .sv-item,.sv-item.on{grid-template-columns:44px 1fr;padding:24px 0}
  .sv-arrow{display:none}
  .sv-item h3,.sv-item.on h3{color:var(--ink)}
  .sv-inline{display:block;grid-column:1/-1;margin-top:12px;width:100%;aspect-ratio:16/10;object-fit:cover;border-radius:14px;background:linear-gradient(135deg,var(--gold-l),var(--gold-d))}
}
</style>

<main>
<section class="section">
  <div class="wrap">
    <div class="sv-intro">
      <p class="eyebrow reveal">What we do</p>
      <h2 class="title reveal" style="--d:.08s"><?= count($services) ?> services. One team.</h2>
      <span class="rule rule--left reveal" style="--d:.14s"></span>
    </div>

    <div class="sv">
      <ol class="sv-list">
        <?php foreach ($services as $i => $s): ?>
          <li class="sv-item reveal<?= $i === 0 ? ' on' : '' ?>" tabindex="0" style="--d:<?= min($i, 5) * 0.05 ?>s">
            <span class="sv-n"><?= $pad($i) ?></span>
            <h3><?= e($s[0]) ?></h3>
            <span class="sv-arrow">&rarr;</span>
            <img class="sv-inline" src="<?= e($s[1]) ?>" alt="<?= e($s[0]) ?>" loading="lazy" onerror="this.remove()">
          </li>
        <?php endforeach; ?>
      </ol>

      <div class="sv-stage" aria-hidden="true">
        <div class="sv-frame">
          <?php foreach ($services as $i => $s): ?>
            <figure class="sv-slide<?= $i === 0 ? ' on' : '' ?>">
              <span class="sv-ph"><?= $pad($i) ?></span>
              <img src="<?= e($s[1]) ?>" alt="" loading="lazy" onerror="this.remove()">
            </figure>
          <?php endforeach; ?>
          <div class="sv-cap"><b><?= $pad(0) ?></b><span><?= e($services[0][0]) ?></span></div>
        </div>
      </div>
    </div>

    <div class="sv-cta reveal">
      <h3>Have a project in mind?</h3>
      <a href="contact.php" class="btn">Contact Us</a>
    </div>
  </div>
</section>
</main>

<script>
(function () {
  var items = [].slice.call(document.querySelectorAll('.sv-item'));
  var slides = document.querySelectorAll('.sv-slide');
  var cap = document.querySelector('.sv-cap');
  function show(i) {
    items.forEach(function (it, k) { it.classList.toggle('on', k === i); });
    slides.forEach(function (s, k) { s.classList.toggle('on', k === i); });
    cap.querySelector('b').textContent = String(i + 1).padStart(2, '0');
    cap.querySelector('span').textContent = items[i].querySelector('h3').textContent;
  }
  items.forEach(function (it, i) {
    ['mouseenter', 'focus', 'click'].forEach(function (ev) {
      it.addEventListener(ev, function () { show(i); });
    });
  });
})();
</script>
<?php include __DIR__ . '/includes/footer.php'; ?>