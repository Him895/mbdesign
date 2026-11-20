<?php /* Inner pages ka dark banner. $pageTitle aur optional $crumb pehle set karo. */ ?>
<section class="phead">
  <div class="hero__bg">
    <i class="orb orb--1"></i><i class="orb orb--2"></i>
    <svg class="hero__lines" viewBox="0 0 1200 800" preserveAspectRatio="xMidYMid slice" aria-hidden="true">
      <path d="M0 620 L300 620 L300 380 L620 380 L620 140 L1200 140"/>
      <path d="M0 720 L460 720 L460 500 L840 500 L840 260 L1200 260"/>
      <path d="M120 800 L120 560 L520 560 L520 300 L980 300 L980 0"/>
    </svg>
    <div class="hero__grid"></div>
  </div>
  <div class="wrap phead__in">
    <h1 class="hero__title phead__title" data-split><?= e($pageTitle) ?></h1>
    <ol class="crumb">
      <li><a href="index.php">Home</a></li>
      <li><?= e($crumb ?? $pageTitle) ?></li>
    </ol>
  </div>
</section>
