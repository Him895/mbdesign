<?php require_once __DIR__ . '/config.php'; $current = basename($_SERVER['PHP_SELF']); ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?= e($pageTitle ?? $site['name']) ?> | Architecture, Planning &amp; Interior Design, Nagpur</title>
  <meta name="description" content="MB Design &amp; Build - full-service Architecture, Planning and Interior Designing firm in Nagpur.">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@500;600;700&family=Montserrat:wght@400;500;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>

<div class="preloader" id="preloader">
  <div class="preloader__inner">
    <!-- Direct path de diya, koi PHP error nahi aayega -->
    <img src="assets/img/mblogooo_text_white_final.png" alt="MB Design Logo" class="preloader__logo" onerror="this.style.display='none'">
    <span><?= e($site['name']) ?></span>
    <i class="preloader__bar"></i>
  </div>
</div>

<div class="progress" id="progress"></div>

<header class="nav" id="nav">
  <a class="nav__brand" href="index.php">
    <!-- Original Logo (Scroll ke baad dikhega) -->
<img class="logo-dark" src="assets/img/mblogooo.png" alt="<?= e($site['name']) ?>" onerror="this.replaceWith(Object.assign(document.createElement('b'),{textContent:'MB'}))">    
    <!-- White Logo (Top par dikhega) -->
    <!-- Yahan apne white logo ka exact naam dalein (e.g., logo-white.png) -->
    <img class="logo-light" src="assets/img/mblogooo.png" alt="<?= e($site['name']) ?>" onerror="this.style.display='none'">
    
    <span><?= e($site['name']) ?></span>
  </a>

  <nav class="nav__menu" id="menu" aria-label="Main">
    <ul>
      <?php foreach ($site['menu'] as $item): ?>
        <li class="<?= !empty($item['children']) ? 'has-sub' : '' ?>">
          <a href="<?= e($item['url']) ?>" class="<?= menu_active($item, $current) ? 'active' : '' ?>">
            <?= e($item['label']) ?><?= !empty($item['children']) ? ' <small>&#9662;</small>' : '' ?>
          </a>
          <?php if (!empty($item['children'])): ?>
            <ul class="sub">
              <?php foreach ($item['children'] as $c): ?>
                <li><a href="<?= e($c['url']) ?>"><?= e($c['label']) ?></a></li>
              <?php endforeach; ?>
            </ul>
          <?php endif; ?>
        </li>
      <?php endforeach; ?>
    </ul>
  </nav>

  <button class="nav__toggle" id="toggle" aria-label="Menu"><span></span><span></span></button>
</header>