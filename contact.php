<?php
session_start();
$pageTitle = 'Contact';
require_once __DIR__ . '/includes/config.php';
$ct = $site['contact'];

/* Enquiry yahan mail hogi. From address apne domain ka rakho. */
$mailTo   = $ct['emails'][0];
$mailFrom = 'no-reply@mbdesign.in';

$f = ['first' => '', 'last' => '', 'email' => '', 'phone' => '', 'message' => ''];
$sent = false;
$error = '';
if (empty($_SESSION['ct_token'])) $_SESSION['ct_token'] = bin2hex(random_bytes(16));

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    foreach ($f as $k => $v) $f[$k] = trim((string)($_POST[$k] ?? ''));
    $oneLine = function ($s) { return trim(preg_replace('/\s+/', ' ', $s)); };
    $f['first']  = mb_substr($oneLine($f['first']), 0, 60);
    $f['last']   = mb_substr($oneLine($f['last']), 0, 60);
    $f['phone']  = mb_substr($oneLine($f['phone']), 0, 25);
    $f['email']  = mb_substr($f['email'], 0, 120);
    $f['message'] = mb_substr($f['message'], 0, 3000);

    if (!hash_equals($_SESSION['ct_token'], (string)($_POST['token'] ?? ''))) {
        $error = 'Session expire ho gaya. Page refresh karke dobara try karein.';
    } elseif (!empty($_POST['website'])) {
        $sent = true;                       // honeypot: bots ko success dikha do, mail mat bhejo
    } elseif ($f['first'] === '' || $f['message'] === '') {
        $error = 'Please enter your name and message.';
    } elseif (!filter_var($f['email'], FILTER_VALIDATE_EMAIL)) {
        $error = 'Please enter a valid email address.';
    } else {
        $name    = trim($f['first'] . ' ' . $f['last']);
        $subject = 'Website enquiry from ' . $name;
        $body    = "New enquiry from the website\n\n"
                 . "Name:  $name\nEmail: {$f['email']}\nPhone: {$f['phone']}\n\nMessage:\n{$f['message']}\n";
        $headers = "From: MB Design Website <$mailFrom>\r\n"
                 . "Reply-To: {$f['email']}\r\n"
                 . "Content-Type: text/plain; charset=UTF-8\r\n";
        if (@mail($mailTo, '=?UTF-8?B?' . base64_encode($subject) . '?=', $body, $headers)) {
            $sent = true;
        } else {
            $error = 'Message abhi nahi ja saka. Please call us on ' . $ct['phones'][0] . ' ya email karein.';
        }
    }
    if ($sent) {
        $f = ['first' => '', 'last' => '', 'email' => '', 'phone' => '', 'message' => ''];
        $_SESSION['ct_token'] = bin2hex(random_bytes(16));
    }
}

include __DIR__ . '/includes/header.php';
include __DIR__ . '/includes/page-header.php';
?>
<style>
.ct{position:relative}
.ct-grid{display:grid;grid-template-columns:5fr 7fr;align-items:stretch;border-radius:26px;overflow:hidden;box-shadow:0 40px 90px rgba(60,45,10,.18)}
.ct-info{position:relative;overflow:hidden;background:var(--ink);color:#fff;padding:56px 46px}
.ct-info::before{content:"MB";position:absolute;right:-30px;bottom:-70px;font-family:var(--h);font-weight:700;font-size:16rem;line-height:1;color:transparent;-webkit-text-stroke:1.5px rgba(185,155,80,.25);pointer-events:none}
.ct-info h2{font-family:var(--h);font-size:clamp(2.2rem,4vw,3.2rem);line-height:1.1;margin:10px 0 34px}
.ct-card{position:relative;display:flex;gap:18px;margin-bottom:26px}
.ct-ico{flex:none;width:48px;height:48px;border-radius:50%;border:1px solid rgba(185,155,80,.6);display:grid;place-items:center;transition:.4s var(--ease)}
.ct-ico svg{width:20px;height:20px;fill:none;stroke:var(--gold-l);stroke-width:1.7;stroke-linecap:round;stroke-linejoin:round}
.ct-card:hover .ct-ico{background:var(--gold);transform:rotate(-8deg) scale(1.08)}
.ct-card:hover .ct-ico svg{stroke:#fff}
.ct-card h4{font-size:.72rem;letter-spacing:.25em;text-transform:uppercase;color:var(--gold-l);margin-bottom:4px}
.ct-card p{font-size:.92rem;color:#e8e1cf;line-height:1.6}
.ct-card a:hover{color:var(--gold-l)}
.ct-form{background:#fff;padding:56px 50px}
.ct-form h3{font-family:var(--h);font-size:2rem;margin-bottom:26px}
.ct-row{display:grid;grid-template-columns:1fr 1fr;gap:0 30px}
.fld{position:relative;margin-bottom:20px}
.fld input,.fld textarea{width:100%;border:0;border-bottom:2px solid #ddd5c0;background:transparent;padding:24px 0 10px;font:500 1rem var(--b);color:var(--ink);outline:0;transition:border-color .3s;resize:vertical}
.fld label{position:absolute;left:0;top:24px;color:var(--mute);pointer-events:none;transition:.3s var(--ease)}
.fld input:focus,.fld textarea:focus{border-color:var(--gold)}
.fld input:focus+label,.fld input:not(:placeholder-shown)+label,.fld textarea:focus+label,.fld textarea:not(:placeholder-shown)+label{top:0;font-size:.7rem;letter-spacing:.16em;text-transform:uppercase;color:var(--gold-d)}
.ct-hp{position:absolute!important;left:-9999px;opacity:0;height:0;width:0}
.ct-form .btn{border:0;cursor:pointer;font-family:var(--b);margin-top:10px}
.ct-form .btn[disabled]{opacity:.6;cursor:wait}
.ct-alert{padding:14px 18px;border-radius:10px;margin-bottom:22px;font-size:.9rem;font-weight:600;background:#fdecea;color:#a12622;border-left:4px solid #d9534f}
.ct-ok{text-align:center;padding:40px 10px}
.ct-ok i{display:grid;place-items:center;width:84px;height:84px;margin:0 auto 22px;border-radius:50%;background:var(--gold);color:#fff;font-style:normal;font-size:2.6rem;animation:ctpop .7s var(--ease)}
.ct-ok h3{margin-bottom:8px}
@keyframes ctpop{from{transform:scale(0) rotate(-90deg)}to{transform:none}}
.ct-map{margin-top:90px}
.ct-map__bar{display:flex;justify-content:space-between;align-items:center;gap:20px;flex-wrap:wrap;margin-bottom:24px}
.ct-pills{display:flex;gap:10px}
.ct-pills button{border:1px solid var(--gold);background:none;padding:10px 22px;border-radius:40px;font:600 .78rem var(--b);letter-spacing:.05em;cursor:pointer;color:var(--gold-d);transition:.3s}
.ct-pills button.on,.ct-pills button:hover{background:var(--gold);color:#fff}
.ct-map__frame{border-radius:24px;overflow:hidden;box-shadow:0 30px 70px rgba(60,45,10,.2);line-height:0}
.ct-map iframe{width:100%;height:460px;border:0;filter:grayscale(.35) contrast(1.05);transition:filter .5s}
.ct-map iframe:hover{filter:none}
@media(max-width:980px){
  .ct-grid{grid-template-columns:1fr}
  .ct-info,.ct-form{padding:40px 26px}
  .ct-row{grid-template-columns:1fr}
}
</style>

<main>
<section class="section ct">
  <div class="wrap">
    <div class="ct-grid reveal">

      <aside class="ct-info">
        <p class="eyebrow">Get in touch</p>
        <h2>Let&rsquo;s talk about your project.</h2>

        <div class="ct-card">
          <span class="ct-ico"><svg viewBox="0 0 24 24"><path d="M12 21s-7-6.2-7-11a7 7 0 0114 0c0 4.8-7 11-7 11z"/><circle cx="12" cy="10" r="2.5"/></svg></span>
          <div><h4>Head Office</h4><p><?= e($ct['head'][0]) ?><br><?= e($ct['head'][1]) ?></p></div>
        </div>
        <div class="ct-card">
          <span class="ct-ico"><svg viewBox="0 0 24 24"><path d="M12 21s-7-6.2-7-11a7 7 0 0114 0c0 4.8-7 11-7 11z"/><circle cx="12" cy="10" r="2.5"/></svg></span>
          <div><h4>Branch Office</h4><p><?= e($ct['branch'][0]) ?><br><?= e($ct['branch'][1]) ?></p></div>
        </div>
        <div class="ct-card">
          <span class="ct-ico"><svg viewBox="0 0 24 24"><path d="M5 4h4l2 5-2.5 1.5a11 11 0 005 5L15 13l5 2v4a2 2 0 01-2 2A16 16 0 013 6a2 2 0 012-2z"/></svg></span>
          <div><h4>Call</h4><p><?php foreach ($ct['phones'] as $p): ?><a href="tel:<?= e(str_replace(' ', '', $p)) ?>"><?= e($p) ?></a><br><?php endforeach; ?></p></div>
        </div>
        <div class="ct-card">
          <span class="ct-ico"><svg viewBox="0 0 24 24"><rect x="3" y="5" width="18" height="14" rx="2"/><path d="M3 7l9 6 9-6"/></svg></span>
          <div><h4>Email</h4><p><?php foreach ($ct['emails'] as $m): ?><a href="mailto:<?= e($m) ?>"><?= e($m) ?></a><br><?php endforeach; ?></p></div>
        </div>
      </aside>

      <div class="ct-form">
        <?php if ($sent): ?>
          <div class="ct-ok">
            <i>&#10003;</i>
            <h3>Thank you!</h3>
            <p>Aapka message mil gaya hai. Hum jaldi hi aapse sampark karenge.</p>
          </div>
        <?php else: ?>
          <h3>Send us a message</h3>
          <?php if ($error): ?><div class="ct-alert"><?= e($error) ?></div><?php endif; ?>
          <form method="post" action="contact.php#contact-form" id="contact-form" novalidate>
            <input type="hidden" name="token" value="<?= e($_SESSION['ct_token']) ?>">
            <input class="ct-hp" type="text" name="website" tabindex="-1" autocomplete="off" aria-hidden="true">
            <div class="ct-row">
              <div class="fld"><input type="text" name="first" id="f1" placeholder=" " value="<?= e($f['first']) ?>" required><label for="f1">First Name *</label></div>
              <div class="fld"><input type="text" name="last" id="f2" placeholder=" " value="<?= e($f['last']) ?>"><label for="f2">Last Name</label></div>
            </div>
            <div class="ct-row">
              <div class="fld"><input type="email" name="email" id="f3" placeholder=" " value="<?= e($f['email']) ?>" required><label for="f3">Email *</label></div>
              <div class="fld"><input type="tel" name="phone" id="f4" placeholder=" " value="<?= e($f['phone']) ?>"><label for="f4">Phone</label></div>
            </div>
            <div class="fld"><textarea name="message" id="f5" rows="4" placeholder=" " required><?= e($f['message']) ?></textarea><label for="f5">Your Message *</label></div>
            <button type="submit" class="btn">Send Message</button>
          </form>
        <?php endif; ?>
      </div>

    </div>

    <div class="ct-map">
      <div class="ct-map__bar reveal">
        <h2 class="title title--sm" style="text-align:left;margin:0">Find us</h2>
        <div class="ct-pills">
          <button type="button" class="on" data-q="Tulsi Apartment, Telephone Exchange Square, C.A. Road, Nagpur">Head Office</button>
          <button type="button" data-q="Amrapali Nagar, Hudkeshwar Road, Nagpur 440034">Branch Office</button>
        </div>
      </div>
      <div class="ct-map__frame reveal">
        <iframe id="map" loading="lazy" referrerpolicy="no-referrer-when-downgrade" title="Office location"
          src="https://www.google.com/maps?q=Tulsi+Apartment,+Telephone+Exchange+Square,+C.A.+Road,+Nagpur&output=embed"></iframe>
      </div>
    </div>
  </div>
</section>
</main>

<script>
(function () {
  var map = document.getElementById('map');
  document.querySelectorAll('.ct-pills button').forEach(function (b) {
    b.addEventListener('click', function () {
      document.querySelectorAll('.ct-pills button').forEach(function (o) { o.classList.toggle('on', o === b); });
      map.src = 'https://www.google.com/maps?q=' + encodeURIComponent(b.getAttribute('data-q')) + '&output=embed';
    });
  });
  var form = document.getElementById('contact-form');
  if (form) form.addEventListener('submit', function () {
    var btn = form.querySelector('button[type=submit]');
    btn.disabled = true; btn.textContent = 'Sending...';
  });
})();
</script>
<?php include __DIR__ . '/includes/footer.php'; ?>