
<?php

require_once __DIR__ . '/includes/showcase.php';
require_once __DIR__ . '/includes/projects-lib.php';

/*
|--------------------------------------------------------------------------
| Project Status
|--------------------------------------------------------------------------
*/

$statuses = defined('PJ_STATUSES') ? PJ_STATUSES : [];

$sKey = sc_get('status', 'completed');

$ok = isset($statuses[$sKey]);

if (!$ok) {
    http_response_code(404);
    $pageTitle = 'Not Found';
} else {
    $pageTitle = $statuses[$sKey]['title'];
}

include __DIR__ . '/includes/header.php';
include __DIR__ . '/includes/page-header.php';

sc_styles();

if (!$ok) {
    sc_missing('projects.php', 'Completed Projects');
    include __DIR__ . '/includes/footer.php';
    exit;
}

$st = $statuses[$sKey];
$total = count(pj_list($sKey));

?>

<main>
<section class="section">
    <div class="wrap">

        <!-- Section Heading -->
        <div class="sc-head">
            <div>
                <p class="eyebrow reveal">Our Work</p>

                <h2 class="title reveal" style="--d:.08s">
                    <?= e($st['title']) ?>
                </h2>

                <span class="rule rule--left reveal" style="--d:.14s"></span>

                <p class="reveal" style="--d:.18s;color:var(--mute)">
                    <?= e($st['intro']) ?>
                </p>
            </div>

            <!-- Status Navigation -->
            <nav class="sc-tabs reveal" style="--d:.12s" aria-label="Project status">

                <?php foreach ($statuses as $k => $s): ?>

                    <a href="<?= e(pj_status_url($k)) ?>"
                       class="<?= $k === $sKey ? 'on' : '' ?>">

                        <?= e($s['tab']) ?>

                        <small><?= count(pj_list($k)) ?></small>

                    </a>

                <?php endforeach; ?>

            </nav>
        </div>

        <!-- Project Categories -->
        <div class="sc-cats">

            <?php
            $i = 0;

            foreach (PJ_CATEGORIES as $ck => $c):

                $n = count(pj_list($sKey, $ck));
            ?>

                <div class="reveal" style="--d:<?= $i * 0.12 ?>s">

                    <a class="sc-cat"
                       href="<?= e(pj_cat_url($sKey, $ck)) ?>">

                        <div class="sc-media" style="position:absolute;inset:0">

                            <?php
                            sc_media(
                                pj_cat_cover($sKey, $ck),
                                $c['label']
                            );
                            ?>

                        </div>

                        <span class="sc-cat__n">
                            <?= sc_pad(++$i) ?>
                        </span>

                        <div class="sc-cat__cap">

                            <h3><?= e($c['title']) ?></h3>

                            <p>
                                <?= $n > 0
                                    ? $n . ($n === 1 ? ' Project' : ' Projects')
                                    : 'Coming soon'
                                ?>
                            </p>

                            <span class="sc-more">
                                Click Here <i>&rarr;</i>
                            </span>

                        </div>

                    </a>

                </div>

            <?php endforeach; ?>

        </div>

        <!-- Empty State -->
        <?php if ($total === 0): ?>

            <p class="reveal"
               style="text-align:center;margin-top:50px;color:var(--mute)">

                Is section ke projects jald hi add honge.

            </p>

        <?php endif; ?>

    </div>
</section>
</main>

<?php include __DIR__ . '/includes/footer.php'; ?>
