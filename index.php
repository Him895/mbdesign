
<?php
$pageTitle = 'MB Design & Build';
include __DIR__ . '/includes/header.php';

$ytId = $site['youtube_id'] ?? '';
?>

<main id="top">

    <!-- HERO VIDEO -->
    <section class="hero hero--video" id="home">

        <div class="hero__video-wrap">

            <video
                class="hero__video"
                autoplay
                muted
                loop
                playsinline
                preload="auto"
            >
                <source src="assets/video/Final.mp4" type="video/mp4">
            </video>

        </div>

        <div class="hero__video-overlay"></div>

        

        <a href="#about" class="scroll-hint" aria-label="Scroll">
            <span></span>
        </a>

        <div class="progress" id="progress"></div>

    </section>


    <!-- MARQUEE -->
    <div class="marquee" aria-hidden="true">
        <div class="marquee__track">

            <?php for ($i = 0; $i < 4; $i++): foreach ($site['skills'] as $s): ?>
                <span><?= e($s) ?></span><em>◆</em>
            <?php endforeach; endfor; ?>

            <?php for ($i = 0; $i < 4; $i++): foreach ($site['skills'] as $s): ?>
                <span><?= e($s) ?></span><em>◆</em>
            <?php endforeach; endfor; ?>

        </div>
    </div>


    <!-- ABOUT -->
    <section class="section about2" id="about">

        <div class="about2__mark" aria-hidden="true">MB</div>

        <div class="wrap about2__grid">

            <div class="about2__left">

                <p class="eyebrow reveal">
                    <?= e($site['about']['eyebrow']) ?>
                </p>

                <h2 class="title reveal" style="--d:.08s">
                    <?= e($site['about']['title']) ?>
                </h2>

                <span class="rule rule--left reveal" style="--d:.14s"></span>

            </div>

            <div class="about2__right">

                <blockquote class="quote reveal">
                    <?= e($site['about_quote']) ?>
                </blockquote>

                <p class="lead reveal">
                    <?= e($site['about']['text']) ?>
                </p>

                <ul class="chips reveal">

                    <?php foreach ($site['about_points'] as $p): ?>
                        <li><?= e($p) ?></li>
                    <?php endforeach; ?>

                </ul>

                <a href="about.php" class="btn reveal">
                    Learn More
                </a>

            </div>

        </div>

    </section>


    <!-- SHORT DESCRIPTION : EXPANDING IMAGE STRIPS -->
    <section class="section studio">

        <div class="wrap">

            <div class="studio__head">

                <h2 class="title reveal">
                    <?= e($site['short_title']) ?>
                </h2>

                <p class="studio__hint reveal" style="--d:.1s">
                    Hover / tap a panel
                </p>

            </div>

            <div class="strips reveal" style="--d:.1s">

                <?php foreach ($site['short'] as $i => $s): ?>

                    <article class="strip<?= $i === 0 ? ' active' : '' ?>">

                        <img
                            src="<?= e($s['img']) ?>"
                            alt="<?= e($s['label']) ?>"
                            loading="lazy"
                            onerror="this.remove()"
                        >

                        <span class="strip__num">
                            0<?= $i + 1 ?>
                        </span>

                        <span class="strip__label">
                            <?= e($s['label']) ?>
                        </span>

                        <div class="strip__body">

                            <h3><?= e($s['label']) ?></h3>

                            <p><?= e($s['text']) ?></p>

                        </div>

                    </article>

                <?php endforeach; ?>

            </div>

        </div>

    </section>


    <!-- CLIENTS -->
    <section class="section work" id="projects">

        <div class="wrap">

            <p class="eyebrow reveal">
                Trusted By
            </p>

            <h2 class="title reveal" style="--d:.08s">
                <?= e($site['clients_title']) ?>
            </h2>

            <div class="work__list">

                <?php foreach ($site['clients'] as $i => $cl):

                    $parts = array_map(
                        'trim',
                        explode(',', $cl['name'], 2)
                    );
                ?>

                    <div
                        class="row reveal"
                        style="--d:<?= $i * 0.1 ?>s"
                        data-img="<?= e($cl['logo']) ?>"
                    >

                        <span class="row__n">
                            0<?= $i + 1 ?>
                        </span>

                        <h3>
                            <?= e($parts[0]) ?>
                        </h3>

                        <span class="row__city">
                            <?= e($parts[1] ?? '') ?>
                        </span>

                        <span class="row__thumb">

                            <img
                                src="<?= e($cl['logo']) ?>"
                                alt="<?= e($cl['name']) ?>"
                                loading="lazy"
                                onerror="this.remove()"
                            >

                        </span>

                    </div>

                <?php endforeach; ?>

            </div>

        </div>

    </section>

    <div class="peek" id="peek" aria-hidden="true">
        <div class="peek__in">
            <img alt="">
        </div>
    </div>


    <!-- SKILLS -->
    <section class="craft">

        <div class="wrap craft__head">

            <p class="eyebrow eyebrow--light reveal">
                What we stand for
            </p>

            <h2 class="title title--light reveal" style="--d:.08s">
                Our Skills
            </h2>

        </div>

        <div class="craft__grid">

            <?php foreach ($site['skills'] as $i => $s): ?>

                <div class="craft__item reveal" style="--d:<?= $i * 0.12 ?>s">

                    <span class="craft__n">
                        0<?= $i + 1 ?>
                    </span>

                    <h3><?= e($s) ?></h3>

                </div>

            <?php endforeach; ?>

        </div>

    </section>


    <!-- VIDEO -->
    <section class="section film">

        <div class="wrap">

            <p class="eyebrow reveal">
                Watch
            </p>

            <h2 class="title title--light reveal" style="--d:.08s">
                Video
            </h2>

            <div class="film__frame reveal" style="--d:.15s">

                <div class="video" id="video">

                    <?php if ($ytId !== ''): ?>

                        <iframe
                            width="100%"
                            height="100%"
                            src="https://www.youtube.com/embed/<?= e($ytId) ?>"
                            title="Royal Karhandla Resort by M B Design & Build"
                            frameborder="0"
                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                            allowfullscreen
                            style="position:absolute;top:0;left:0;width:100%;height:100%;border:none;"
                        ></iframe>

                    <?php else: ?>

                        <div class="video__empty">
                            Video currently unavailable.
                        </div>

                    <?php endif; ?>

                </div>

            </div>

        </div>

    </section>

</main>

<?php include __DIR__ . '/includes/footer.php'; ?>
