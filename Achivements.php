<?php
$pageTitle = 'Our Achievement';
include __DIR__ . '/includes/header.php';
include __DIR__ . '/includes/page-header.php';

/* Images yahan rakho: assets/img/achievements/
   Naya achievement jodna ho to bas ek line aur add karo: [image, caption, category] */
$items = [
    ['assets/img/ach1.jpg', 'Appreciation from Grow-Trees',                          'Certificates'],
    ['assets/img/ach2.jpg',    'Cadence School of Fashion & Interior',                  'Certificates'],
    ['assets/img/ach3.jpg',  'Best Designers Awards from Green Lam',                  'Awards'],
    ['assets/img/ach5.jpg',     'Meet with Jaquar Chairman Mr. L. N. Mehra',             'Meetings'],
    ['assets/img/ach4.jpg',       'Certified by Institute of Indian Interior Designers',   'Certificates'],
    ['assets/img/kkk.jpg',    'iDesign Excellence Awards 2.0 - Excellence in Interior Designs', 'Awards'],
    // TODO: baaki achievements (screenshots me aage ke nahi dikhe) yahan add karne hain.
];
$cats = array_values(array_unique(array_column($items, 2)));
?>
<style>
.ach{background:radial-gradient(ellipse at 80% 0,#3a2f17 0,var(--ink) 55%);color:#fff;position:relative;overflow:hidden}
.ach .title{color:#fff}
.ach-head{display:flex;justify-content:space-between;align-items:flex-end;gap:30px;flex-wrap:wrap;margin-bottom:50px}
.ach-pills{display:flex;flex-wrap:wrap;gap:10px}
.ach-pills button{border:1px solid rgba(185,155,80,.7);background:none;color:var(--gold-l);padding:10px 22px;border-radius:40px;font:600 .78rem var(--b);letter-spacing:.05em;cursor:pointer;transition:.3s}
.ach-pills button small{opacity:.7;margin-left:4px}
.ach-pills button:hover,.ach-pills button.on{background:var(--gold);border-color:var(--gold);color:#fff}
.ach-grid{columns:3;column-gap:24px}
.ach-item{break-inside:avoid;margin-bottom:24px;display:block;width:100%}
.ach-item[hidden]{display:none}
.ach-card{display:block;width:100%;padding:10px;border:1px solid rgba(185,155,80,.45);border-radius:18px;background:rgba(255,255,255,.04);cursor:zoom-in;text-align:left;color:inherit;font:inherit;transition:transform .5s var(--ease),border-color .4s,box-shadow .5s,background .4s}
.ach-card:hover{transform:translateY(-8px);border-color:var(--gold);background:rgba(185,155,80,.1);box-shadow:0 30px 60px rgba(0,0,0,.45)}
.ach-pic{position:relative;overflow:hidden;border-radius:10px;line-height:0}
.ach-pic img{width:100%;height:auto;transition:transform 1s var(--ease)}
.ach-card:hover .ach-pic img{transform:scale(1.07)}
.ach-pic::after{content:"+";position:absolute;right:12px;top:12px;width:40px;height:40px;border-radius:50%;background:var(--gold);color:#fff;display:grid;place-items:center;font-size:1.5rem;line-height:1;opacity:0;transform:scale(.5);transition:.4s var(--ease)}
.ach-card:hover .ach-pic::after{opacity:1;transform:none}
.ach-ph{aspect-ratio:4/3;display:grid;place-items:center;font-size:3.4rem;color:rgba(185,155,80,.6);background:linear-gradient(135deg,#2c2414,#16140f);border-radius:10px}
.ach-cap{padding:16px 8px 8px}
.ach-cap em{display:block;font-style:normal;font-size:.66rem;letter-spacing:.26em;text-transform:uppercase;color:var(--gold);margin-bottom:6px}
.ach-cap span{font-family:var(--h);font-size:1.35rem;line-height:1.25}

/* lightbox */
.lb{position:fixed;inset:0;z-index:300;background:rgba(10,8,4,.94);display:flex;flex-direction:column;align-items:center;justify-content:center;gap:16px;padding:30px 70px;opacity:0;visibility:hidden;transition:opacity .35s,visibility .35s}
.lb.open{opacity:1;visibility:visible}
.lb img{max-width:100%;max-height:78vh;border-radius:10px;box-shadow:0 30px 80px rgba(0,0,0,.6);transform:scale(.94);transition:transform .45s var(--ease)}
.lb.open img{transform:none}
.lb p{font-family:var(--h);font-size:1.5rem;color:#fff;text-align:center;max-width:900px}
.lb button{position:absolute;background:rgba(255,255,255,.1);border:0;color:#fff;width:52px;height:52px;border-radius:50%;font-size:1.7rem;cursor:pointer;transition:.3s}
.lb button:hover{background:var(--gold)}
.lb-x{top:22px;right:22px}
.lb-p{left:16px;top:50%;margin-top:-26px}
.lb-n{right:16px;top:50%;margin-top:-26px}
@media(max-width:980px){.ach-grid{columns:2}.lb{padding:30px 16px}.lb-p,.lb-n{top:auto;bottom:22px;margin:0}}
@media(max-width:600px){.ach-grid{columns:1}}
</style>

<main>
<section class="section ach">
  <div class="wrap">
    <div class="ach-head">
      <div>
        <p class="eyebrow reveal">Recognition</p>
        <h2 class="title reveal" style="--d:.08s">Our Achievement</h2>
      </div>
      <div class="ach-pills reveal" style="--d:.12s">
        <button type="button" class="on" data-f="all">All <small><?= count($items) ?></small></button>
        <?php foreach ($cats as $cat): ?>
          <button type="button" data-f="<?= e($cat) ?>"><?= e($cat) ?> <small><?= count(array_filter($items, function ($x) use ($cat) { return $x[2] === $cat; })) ?></small></button>
        <?php endforeach; ?>
      </div>
    </div>

    <div class="ach-grid">
      <?php foreach ($items as $i => $it): ?>
        <div class="ach-item reveal" data-cat="<?= e($it[2]) ?>" style="--d:<?= ($i % 3) * 0.1 ?>s">
          <button type="button" class="ach-card" data-full="<?= e($it[0]) ?>" data-cap="<?= e($it[1]) ?>">
            <div class="ach-pic">
              <img src="<?= e($it[0]) ?>" alt="<?= e($it[1]) ?>" loading="lazy" onerror="this.parentNode.innerHTML='<div class=&quot;ach-ph&quot;>&#9733;</div>'">
            </div>
            <div class="ach-cap"><em><?= e($it[2]) ?></em><span><?= e($it[1]) ?></span></div>
          </button>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>
</main>

<div class="lb" id="lb" role="dialog" aria-modal="true" aria-label="Image preview">
  <button type="button" class="lb-x" aria-label="Close">&times;</button>
  <button type="button" class="lb-p" aria-label="Previous">&#8249;</button>
  <img alt="">
  <p></p>
  <button type="button" class="lb-n" aria-label="Next">&#8250;</button>
</div>

<script>
(function () {
  var all = [].slice.call(document.querySelectorAll('.ach-item'));
  var pills = document.querySelectorAll('.ach-pills button');
  var lb = document.getElementById('lb'), lbImg = lb.querySelector('img'), lbCap = lb.querySelector('p');
  var shown = [], cur = 0;

  pills.forEach(function (b) {
    b.addEventListener('click', function () {
      var f = b.getAttribute('data-f');
      pills.forEach(function (o) { o.classList.toggle('on', o === b); });
      all.forEach(function (it) {
        it.hidden = !(f === 'all' || it.getAttribute('data-cat') === f);
        if (!it.hidden) it.classList.add('in');
      });
    });
  });

  function visible() { return all.filter(function (it) { return !it.hidden; }); }
  function open(i) {
    cur = (i + shown.length) % shown.length;
    var card = shown[cur].querySelector('.ach-card');
    lbImg.src = card.getAttribute('data-full');
    lbCap.textContent = card.getAttribute('data-cap');
    lb.classList.add('open');
    document.body.style.overflow = 'hidden';
  }
  function close() { lb.classList.remove('open'); document.body.style.overflow = ''; }

  all.forEach(function (it) {
    it.querySelector('.ach-card').addEventListener('click', function () {
      shown = visible();
      open(shown.indexOf(it));
    });
  });
  lb.querySelector('.lb-x').addEventListener('click', close);
  lb.querySelector('.lb-p').addEventListener('click', function () { open(cur - 1); });
  lb.querySelector('.lb-n').addEventListener('click', function () { open(cur + 1); });
  lb.addEventListener('click', function (e) { if (e.target === lb) close(); });
  document.addEventListener('keydown', function (e) {
    if (!lb.classList.contains('open')) return;
    if (e.key === 'Escape') close();
    if (e.key === 'ArrowLeft') open(cur - 1);
    if (e.key === 'ArrowRight') open(cur + 1);
  });
})();
</script>
<?php include __DIR__ . '/includes/footer.php'; ?>