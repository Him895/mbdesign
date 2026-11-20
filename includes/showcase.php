<?php
/**
 * Gallery + Projects pages ka common code: helpers, CSS, lightbox.
 * Isse chhedne ki zaroorat nahi. Data sirf gallery-data.php aur projects-data.php me bharna hai.
 */
require_once __DIR__ . '/config.php';

const SC_GALLERY_DIR = 'assets/img/gallery/';

/* ---------- helpers ---------- */
function sc_get($key, $default = '') {
    return (isset($_GET[$key]) && is_string($_GET[$key])) ? trim($_GET[$key]) : $default;
}
function sc_img($dir, $file) {
    return preg_match('#^(https?:)?//|^assets/#', $file) ? $file : $dir . $file;
}
function sc_pad($n) { return str_pad((string)$n, 2, '0', STR_PAD_LEFT); }
function sc_cover($dir, $images) { return !empty($images) ? sc_img($dir, $images[0]) : ''; }

function sc_gallery_all() {
    static $d = null;
    if ($d === null) { $d = require __DIR__ . '/gallery-data.php'; }
    return $d;
}
function sc_gallery_find($id) {
    foreach (sc_gallery_all() as $i => $g) {
        if ($g['id'] === $id) { $g['i'] = $i; return $g; }
    }
    return null;
}
function sc_gallery_url($g)       { return 'gallery-view.php?g=' . rawurlencode($g['id']); }

/** Photo na ho/load na ho to gold placeholder dikhta hai. */
function sc_media($src, $title) {
    echo '<span class="sc-ph">' . e(mb_substr($title, 0, 1)) . '</span>';
    if ($src !== '') {
        echo '<img src="' . e($src) . '" alt="' . e($title) . '" loading="lazy" onerror="this.remove()">';
    }
}
function sc_missing($href, $label) { ?>
<main><section class="section"><div class="wrap">
  <div class="sc-empty">
    <h2 class="title">Page not found</h2>
    <p>Ye page ya project ab available nahi hai.</p>
    <a class="btn" href="<?= e($href) ?>"><?= e($label) ?></a>
  </div>
</div></section></main>
<?php }

/* ---------- CSS ---------- */
function sc_styles() { ?>
<style>
.sc-head{display:flex;justify-content:space-between;align-items:flex-end;gap:30px;flex-wrap:wrap;margin-bottom:50px}
.sc-count{font-family:var(--h);font-size:1.3rem;color:var(--gold-d)}
.sc-media{position:relative;overflow:hidden;background:linear-gradient(135deg,var(--gold-d),var(--ink2))}
.sc-media img{position:absolute;inset:0;width:100%;height:100%;object-fit:cover;transition:transform 1.1s var(--ease)}
.sc-ph{position:absolute;inset:0;display:grid;place-items:center;font-family:var(--h);font-size:6rem;font-weight:700;color:rgba(255,255,255,.28)}
.sc-more{display:inline-flex;align-items:center;gap:12px;margin-top:12px;font-size:.74rem;letter-spacing:.18em;text-transform:uppercase;font-weight:700;color:var(--gold-l)}
.sc-more i{display:grid;place-items:center;width:34px;height:34px;border-radius:50%;background:var(--gold);color:#fff;font-style:normal;transition:transform .45s var(--ease),background .3s}

/* gallery mosaic */
.sc-mosaic{display:grid;grid-template-columns:repeat(3,1fr);grid-auto-rows:310px;gap:22px;grid-auto-flow:dense}
.sc-cell:nth-child(5n+1){grid-column:span 2}
.sc-tile{position:relative;display:block;height:100%;border-radius:20px;overflow:hidden;color:#fff;isolation:isolate;box-shadow:0 14px 40px rgba(60,45,10,.14)}
.sc-tile .sc-media{position:absolute;inset:0}
.sc-tile::after{content:"";position:absolute;inset:0;z-index:1;background:linear-gradient(to top,rgba(10,8,4,.9),rgba(10,8,4,.05) 62%);transition:opacity .4s}
.sc-tile:hover img{transform:scale(1.09)}
.sc-tile:hover .sc-more i{transform:translateX(6px);background:#fff;color:var(--ink)}
.sc-tile__n{position:absolute;z-index:2;top:16px;left:22px;font-family:var(--h);font-size:2.3rem;font-weight:700;color:var(--gold-l);text-shadow:0 2px 12px rgba(0,0,0,.4)}
.sc-tile__cap{position:absolute;z-index:2;left:24px;right:24px;bottom:22px;transition:transform .5s var(--ease)}
.sc-tile:hover .sc-tile__cap{transform:translateY(-6px)}
.sc-tile__cap h3{font-family:var(--h);font-size:1.65rem;line-height:1.2}

/* trail + tabs */
.sc-trail{display:flex;flex-wrap:wrap;gap:10px;align-items:center;font-size:.8rem;letter-spacing:.05em;color:var(--mute);margin-bottom:34px}
.sc-trail a{color:var(--gold-d);font-weight:600}
.sc-trail a:hover{text-decoration:underline}
.sc-trail i{font-style:normal;opacity:.5}
.sc-tabs{display:inline-flex;flex-wrap:wrap;gap:6px;padding:6px;border-radius:50px;background:var(--soft);border:1px solid #eadfc6}
.sc-tabs a{padding:11px 24px;border-radius:40px;font:600 .8rem var(--b);letter-spacing:.05em;color:var(--mute);transition:.3s}
.sc-tabs a small{opacity:.7;margin-left:4px}
.sc-tabs a:hover{color:var(--gold-d)}
.sc-tabs a.on{background:var(--ink);color:#fff}

/* project categories */
.sc-cats{display:grid;grid-template-columns:repeat(3,1fr);gap:24px;margin-top:10px}
.sc-cat{position:relative;display:block;aspect-ratio:3/4;border-radius:24px;overflow:hidden;color:#fff;isolation:isolate;box-shadow:0 20px 50px rgba(60,45,10,.2)}
.sc-cat .sc-media{position:absolute;inset:0}
.sc-cat::after{content:"";position:absolute;inset:0;z-index:1;background:linear-gradient(to top,rgba(10,8,4,.92),rgba(10,8,4,.1) 65%)}
.sc-cat:hover img{transform:scale(1.1)}
.sc-cat__n{position:absolute;z-index:2;top:16px;right:24px;font-family:var(--h);font-size:5rem;font-weight:700;line-height:1;color:transparent;-webkit-text-stroke:1.5px rgba(255,255,255,.7)}
.sc-cat__cap{position:absolute;z-index:2;left:28px;right:28px;bottom:28px}
.sc-cat__cap h3{font-family:var(--h);font-size:2.1rem;line-height:1.1}
.sc-cat__cap p{color:var(--gold-l);font-size:.82rem;letter-spacing:.14em;text-transform:uppercase;margin-top:6px}
.sc-cat:hover .sc-more i{transform:translateX(6px);background:#fff;color:var(--ink)}

/* project cards */
.sc-grid{display:grid;grid-template-columns:repeat(3,1fr);gap:28px}
.sc-card{display:block;height:100%;background:#fff;border:1px solid #eee7d6;border-radius:20px;overflow:hidden;transition:transform .5s var(--ease),box-shadow .5s,border-color .4s}
.sc-card:hover{transform:translateY(-10px);box-shadow:0 30px 60px rgba(185,155,80,.25);border-color:var(--gold)}
.sc-card .sc-media{aspect-ratio:4/3}
.sc-card:hover img{transform:scale(1.08)}
.sc-card__b{padding:24px 24px 28px}
.sc-card__b em{display:block;font-style:normal;font-size:.66rem;letter-spacing:.26em;text-transform:uppercase;color:var(--gold-d);margin-bottom:8px;font-weight:700}
.sc-card__b h3{font-family:var(--h);font-size:1.5rem;line-height:1.25}
.sc-card__b .sc-more{color:var(--gold-d)}
.sc-card:hover .sc-more i{transform:translateX(6px)}
.sc-empty{text-align:center;padding:80px 24px;border:2px dashed #e0d5b8;border-radius:24px;color:var(--mute)}
.sc-empty .title{font-size:2.2rem;margin-bottom:10px;color:var(--ink)}
.sc-empty .btn{margin-top:24px}

/* gallery detail: masonry */
.sc-masonry{columns:3;column-gap:18px}
.sc-masonry a{position:relative;display:block;margin-bottom:18px;break-inside:avoid;border-radius:14px;overflow:hidden;line-height:0;background:var(--soft)}
.sc-masonry img{width:100%;height:auto;transition:transform .9s var(--ease)}
.sc-masonry a:hover img{transform:scale(1.06)}
.sc-zoom::after{content:"+";position:absolute;right:12px;top:12px;width:40px;height:40px;border-radius:50%;background:var(--gold);color:#fff;display:grid;place-items:center;font-size:1.5rem;line-height:1;opacity:0;transform:scale(.5);transition:.4s var(--ease)}
.sc-zoom:hover::after{opacity:1;transform:none}

/* project detail */
.sc-view{display:grid;grid-template-columns:4fr 7fr;gap:60px;align-items:start}
.sc-info{position:sticky;top:110px;background:var(--ink);color:#fff;border-radius:24px;padding:40px 36px;box-shadow:0 30px 70px rgba(0,0,0,.25)}
.sc-tag{position:absolute;top:14px;left:14px;z-index:2;background:var(--ink);color:var(--gold-l);font-size:.66rem;font-weight:700;letter-spacing:.14em;text-transform:uppercase;padding:6px 14px;border-radius:30px}
.sc-chip{display:inline-block;background:var(--gold);color:#fff;font-size:.66rem;letter-spacing:.2em;text-transform:uppercase;font-weight:700;padding:6px 14px;border-radius:30px}
.sc-info h2{font-family:var(--h);font-size:clamp(1.8rem,3vw,2.5rem);line-height:1.15;margin:16px 0 20px}
.sc-info p{color:#d9d2bf;font-size:.93rem;margin-bottom:18px}
.sc-meta{margin:0 0 26px}
.sc-meta li{display:flex;justify-content:space-between;gap:16px;padding:12px 0;border-bottom:1px solid rgba(255,255,255,.14);font-size:.88rem;text-align:right}
.sc-meta span{color:var(--gold-l);letter-spacing:.14em;text-transform:uppercase;font-size:.68rem;text-align:left;padding-top:2px}
.sc-btns{display:flex;flex-direction:column;gap:12px}
.sc-btns .btn{text-align:center}
.sc-btns .btn--ghost{border-color:rgba(255,255,255,.35)}
.sc-shots{display:grid;grid-template-columns:1fr 1fr;gap:18px}
.sc-shots a{position:relative;display:block;border-radius:16px;overflow:hidden;line-height:0;background:var(--soft)}
.sc-shots a:first-child{grid-column:1/-1}
.sc-shots img{width:100%;height:auto;transition:transform .9s var(--ease)}
.sc-shots a:hover img{transform:scale(1.05)}
.sc-pager{display:grid;grid-template-columns:1fr 1fr;gap:20px;margin-top:80px;padding-top:34px;border-top:1px solid #e6dfcb}
.sc-pager a{display:block;padding:24px 28px;border:1px solid #e6dfcb;border-radius:16px;transition:.4s var(--ease)}
.sc-pager a:hover{background:var(--ink);color:#fff;border-color:var(--ink);transform:translateY(-4px)}
.sc-pager small{display:block;font-size:.66rem;letter-spacing:.24em;text-transform:uppercase;color:var(--gold-d);margin-bottom:4px}
.sc-pager b{font-family:var(--h);font-size:1.4rem;font-weight:600;line-height:1.2}
.sc-pager .nx{text-align:right}

/* lightbox */
.sclb{position:fixed;inset:0;z-index:300;background:rgba(10,8,4,.94);display:flex;flex-direction:column;align-items:center;justify-content:center;gap:16px;padding:30px 70px;opacity:0;visibility:hidden;transition:opacity .35s,visibility .35s}
.sclb.open{opacity:1;visibility:visible}
.sclb img{max-width:100%;max-height:78vh;border-radius:10px;box-shadow:0 30px 80px rgba(0,0,0,.6);transform:scale(.94);transition:transform .45s var(--ease)}
.sclb.open img{transform:none}
.sclb p{font-family:var(--h);font-size:1.4rem;color:#fff;text-align:center;max-width:900px}
.sclb button{position:absolute;background:rgba(255,255,255,.1);border:0;color:#fff;width:52px;height:52px;border-radius:50%;font-size:1.7rem;cursor:pointer;transition:.3s}
.sclb button:hover{background:var(--gold)}
.sclb .x{top:22px;right:22px}.sclb .p{left:16px;top:50%;margin-top:-26px}.sclb .n{right:16px;top:50%;margin-top:-26px}
.sclb.single .p,.sclb.single .n{display:none}

@media(max-width:980px){
  .sc-mosaic{grid-template-columns:1fr 1fr;grid-auto-rows:260px}
  .sc-cell:nth-child(5n+1){grid-column:auto}
  .sc-cell:nth-child(3n+1){grid-column:span 2}
  .sc-cats,.sc-grid{grid-template-columns:1fr 1fr}
  .sc-masonry{columns:2}
  .sc-view{grid-template-columns:1fr;gap:34px}
  .sc-info{position:static}
  .sclb{padding:30px 16px}.sclb .p,.sclb .n{top:auto;bottom:22px;margin:0}
}
@media(max-width:600px){
  .sc-mosaic,.sc-cats,.sc-grid{grid-template-columns:1fr}
  .sc-cell:nth-child(n){grid-column:auto}
  .sc-mosaic{grid-auto-rows:240px}
  .sc-cat{aspect-ratio:4/5}
  .sc-masonry{columns:1}
  .sc-shots{grid-template-columns:1fr}
  .sc-pager{grid-template-columns:1fr}
}
</style>
<?php }

/* ---------- lightbox (kisi bhi <a data-lb href="big.jpg" data-cap="..."> par chalta hai) ---------- */
function sc_lightbox() { ?>
<div class="sclb" id="sclb" role="dialog" aria-modal="true" aria-label="Image preview">
  <button type="button" class="x" aria-label="Close">&times;</button>
  <button type="button" class="p" aria-label="Previous">&#8249;</button>
  <img alt=""><p></p>
  <button type="button" class="n" aria-label="Next">&#8250;</button>
</div>
<script>
(function () {
  var lb = document.getElementById('sclb'), img = lb.querySelector('img'), cap = lb.querySelector('p');
  var list = [], cur = 0;
  function open(i) {
    cur = (i + list.length) % list.length;
    img.src = list[cur].href;
    cap.textContent = list[cur].getAttribute('data-cap') || '';
    lb.classList.toggle('single', list.length < 2);
    lb.classList.add('open'); document.body.style.overflow = 'hidden';
  }
  function close() { lb.classList.remove('open'); document.body.style.overflow = ''; }
  document.addEventListener('click', function (e) {
    var a = e.target.closest ? e.target.closest('a[data-lb]') : null;
    if (!a) return;
    e.preventDefault();
    list = [].slice.call(document.querySelectorAll('a[data-lb]'));
    open(list.indexOf(a));
  });
  lb.querySelector('.x').addEventListener('click', close);
  lb.querySelector('.p').addEventListener('click', function () { open(cur - 1); });
  lb.querySelector('.n').addEventListener('click', function () { open(cur + 1); });
  lb.addEventListener('click', function (e) { if (e.target === lb) close(); });
  document.addEventListener('keydown', function (e) {
    if (!lb.classList.contains('open')) return;
    if (e.key === 'Escape') close();
    if (e.key === 'ArrowLeft' && list.length > 1) open(cur - 1);
    if (e.key === 'ArrowRight' && list.length > 1) open(cur + 1);
  });
})();
</script>
<?php }