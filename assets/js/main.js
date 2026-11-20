(function () {
  var $ = function (s) { return document.querySelector(s); };

  // preloader
  window.addEventListener('load', function () {
    setTimeout(function () { $('#preloader').classList.add('done'); }, 600);
  });
  setTimeout(function () { var p = $('#preloader'); if (p) p.classList.add('done'); }, 3500);

  // hero title: split into words for staggered reveal
  document.querySelectorAll('[data-split]').forEach(function (el) {
    var words = el.textContent.trim().split(/\s+/);
    el.innerHTML = words.map(function (w, i) {
      return '<span class="w"><span style="--i:' + i + '">' + w + '</span></span>';
    }).join(' ');
  });

  // navbar, progress bar, back to top
  var nav = $('#nav'), bar = $('#progress'), top = $('#totop');
  function onScroll() {
    var y = window.scrollY, h = document.documentElement.scrollHeight - innerHeight;
    nav.classList.toggle('scrolled', y > 40);
    bar.style.width = (h > 0 ? (y / h) * 100 : 0) + '%';
    top.classList.toggle('show', y > 500);
  }
  addEventListener('scroll', onScroll, { passive: true }); onScroll();

  // mobile menu
  var tg = $('#toggle'), menu = $('#menu');
  tg.addEventListener('click', function () {
    tg.classList.toggle('open'); menu.classList.toggle('open');
  });
  menu.querySelectorAll('a').forEach(function (a) {
    a.addEventListener('click', function (e) {
      var li = a.parentElement;
      if (innerWidth <= 980 && li.classList.contains('has-sub') && a.nextElementSibling === li.querySelector('.sub') && a.parentElement.querySelector(':scope > a') === a) {
        e.preventDefault(); li.classList.toggle('open'); return;
      }
      tg.classList.remove('open'); menu.classList.remove('open');
    });
  });

  // scroll reveal
  var io = new IntersectionObserver(function (entries) {
    entries.forEach(function (en) {
      if (en.isIntersecting) { en.target.classList.add('in'); io.unobserve(en.target); }
    });
  }, { threshold: 0.15 });
  document.querySelectorAll('.reveal').forEach(function (el) { io.observe(el); });

  // hero parallax (mouse + scroll)
  var logo = $('.hero__logo'), orbs = document.querySelectorAll('.orb');
  addEventListener('mousemove', function (e) {
    var x = (e.clientX / innerWidth - .5), y = (e.clientY / innerHeight - .5);
    orbs.forEach(function (o, i) { o.style.translate = (x * 60 * (i + 1)) + 'px ' + (y * 60 * (i + 1)) + 'px'; });
    if (logo) logo.style.translate = (x * -30) + 'px ' + (y * -30) + 'px';
  });

  // short description: expanding strips
  var strips = document.querySelectorAll('.strip');
  strips.forEach(function (s) {
    function act() { strips.forEach(function (o) { o.classList.toggle('active', o === s); }); }
    s.addEventListener('mouseenter', function () { if (matchMedia('(min-width:981px)').matches) act(); });
    s.addEventListener('click', act);
  });

  // clients list: floating logo preview that follows the cursor
  var peek = $('#peek');
  if (peek && matchMedia('(hover:hover) and (min-width:981px)').matches) {
    var pimg = peek.querySelector('img');
    pimg.onerror = function () { peek.classList.remove('on'); };
    document.querySelectorAll('.row').forEach(function (r) {
      r.addEventListener('mouseenter', function () { pimg.src = r.getAttribute('data-img'); peek.classList.add('on'); });
      r.addEventListener('mouseleave', function () { peek.classList.remove('on'); });
      r.addEventListener('mousemove', function (e) {
        peek.style.setProperty('--x', (e.clientX + 40) + 'px');
        peek.style.setProperty('--y', (e.clientY - 140) + 'px');
      });
    });
  }

  // inner pages: scroll-spy for side index
  var tocLinks = document.querySelectorAll('.toc a');
  if (tocLinks.length) {
    var spy = new IntersectionObserver(function (en) {
      en.forEach(function (x) {
        if (x.isIntersecting) {
          tocLinks.forEach(function (a) { a.classList.toggle('on', a.getAttribute('href') === '#' + x.target.id); });
        }
      });
    }, { rootMargin: '-30% 0px -60% 0px' });
    tocLinks.forEach(function (a) {
      var s = document.querySelector(a.getAttribute('href'));
      if (s) spy.observe(s);
    });
  }

  // count-up numbers
  document.querySelectorAll('[data-count]').forEach(function (el) {
    var end = +el.getAttribute('data-count');
    var co = new IntersectionObserver(function (en) {
      if (!en[0].isIntersecting) return;
      co.disconnect();
      var t0 = performance.now();
      (function step(t) {
        var p = Math.min((t - t0) / 1600, 1);
        el.textContent = Math.round(end * (1 - Math.pow(1 - p, 3)));
        if (p < 1) requestAnimationFrame(step);
      })(t0);
    });
    co.observe(el);
  });

  // tabs (clientele)
  document.querySelectorAll('.tabwrap').forEach(function (wrap) {
    var btns = wrap.querySelectorAll('.tabs button'), panes = wrap.querySelectorAll('.tabpane');
    btns.forEach(function (b) {
      b.addEventListener('click', function () {
        btns.forEach(function (o) { o.classList.toggle('on', o === b); });
        panes.forEach(function (p) { p.classList.toggle('on', p.id === b.getAttribute('data-tab')); });
      });
    });
  });

  // video: load YouTube only on click
  var v = $('#video');
  if (v) {
    v.querySelector('.video__play').addEventListener('click', function () {
      var id = v.getAttribute('data-yt');
      if (!id) { alert('config.php me youtube_id daalein.'); return; }
      v.innerHTML = '<iframe src="https://www.youtube.com/embed/' + encodeURIComponent(id) +
        '?autoplay=1&rel=0" allow="autoplay; encrypted-media; fullscreen" allowfullscreen></iframe>';
    });
  }
})();
