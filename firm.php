<?php
$pageTitle = 'Firm Resources';
include __DIR__ . '/includes/header.php';
include __DIR__ . '/includes/page-header.php';

$story = $site['story'];
$disciplines = ['Planner', 'Architectural Consultant', "Interior Designer's", "Landscape Designer's", 'Vastu Consultant', 'Design Development'];

$services = [
    'Architectural Consultants', 'Interior Designing', 'Buildings Construction', 'Landscape Designing',
    'Vastu Shastra Consultants', 'Pre-Design Services', 'Master Planning', '3D-Views Designing & Walkthrough',
    'Turn Key Projects ( Residential & Commercial )', 'Sanctioning from various Government / Non Government Authorities',
];

$methodology = [
    // TODO: Methodology ke shuruwati paragraph(s) yahan add karne hain (screenshot me nahi dikhe).
    'Designing for people is fundamental to this process.',
    'We design to meet current needs and anticipate future developments, so that we can build for the future as much as the present. An appreciation of place is also essential to our working process.',
    "We use both sketches and models and state-of-the-art digital tools to explore and refine our designs, and firmly believe that a hands-on approach is the best way to explore massing, materials, space and light. We translate these schemes into reality by drawing on an exceptional network of knowledge and experience that embraces every aspect of a building's design, construction and performance.",
    'Importance is also given to extensive office management procedures and Methodologies to speed the production of projects without sacrificing project quality. Senior personnel work within these procedures and provide flexibility where required.',
];

// TODO: "Interior Projects" aur "Industrial" ke beech koi aur category ho to yahan add karo.
$clients = [
    'Industrial' => [
        'TATA Service Center ( Jagdamba Motors Ltd. ), Singori, Nagpur.',
        'Aman Bricks, Pulgao, Wardha.',
    ],
    'Developers / Builders / Promoters' => [
        'Harsh Apartment-1, (M.S. Builders & Developers), Nagpur.',
        'Harsh Apartment-2, (M.S. Builders & Developers), Nagpur.',
        'Ratnaprabha Apartment, (Welcome Land Developers & Builders), Nagpur.',
        'Bhagwan Apartment, (Welcome Land Developers & Builders), Nagpur.',
        'Saluja Apartment, (Saluja Developers & Builders), Wadsa, Gadchiroli.',
    ],
    'Commercial / Showrooms' => [
        'AIR INDIA ( M.R.O.), Nagpur.', 'ANAND RATHI share office, K.P. ground, Nagpur.', 'Janvad Software Office, Great Nag Road, Nagpur.',
        'Siti Cable Network, Narang Tower, Nagpur.', 'Suresh Saoji Restaurant & Bar, Golibar sq., Nagpur.', 'Madhushala B.A.R. Pulgao, Wardha.',
        'Hotel Rahul, Buldi, Nagpur.', 'Pahunchar Restaurent, Nagpur.', 'POP Club, Pandhurna, Chindwara. ( M.P.)',
        'Shivsena Bhawan, Golibar sq., Nagpur.', 'Mascot Honda, Wadi, Nagpur.', 'Power Honda, Kamthi Road, Nagpur.',
        'Facit Printer, Nagpur.', 'Ayurvedic Mahavidyalay, Nagpur.', 'Care & Cure Clinic, Nagpur.',
        'Geet Child Clinic, Nagpur.', 'Orange Dental Clinic, Nagpur.', 'Sai Clinic, Pardi, Nagpur.',
        'Kalsi Motors, kalamna, Nagpur.', 'Evergreen Collection, Gandhibag, Nagpur.', 'Hind Sarees, Gandhibag, Nagpur.',
        'Khushboo Boutique, Gandhibag, Nagpur.', 'Riddhi Siddhi Fashion, Gandhibag, Nagpur.', 'Shade Boutique, Wardha Road, Nagpur.',
        'Malu Plywood, C.A. Road, Nagpur.', 'Universal Gym, Mahal, Nagpur.', 'Terminator Gym, Mahal, Nagpur.',
        'Tulsi Collection, Gandhibag, Nagpur.', 'Pakija Collection, Pulgao, Wardha.', 'Mahesh Vastra Bhandar, Warora, Chandrapur.',
        'Swami Vivekanand Path Sanstha Mar. Bank , Pulgao, Wardha.', 'Lambat Jwellers, Pauni, Bhandara.', 'Pethe Jwellers, Kamthi, Nagpur.',
        'Umesh Maske Jwellers, Kamthi, Nagpur.', 'Tirupati Jwellers, Kamthi, Nagpur.', 'Rokde Jwellers, Itwari, Nagpur.',
        'Mona Jwellers, Nagpur.', "Sonchafa Vaishyanpayan & Son's, Pune.", 'Sai Enterprises, Ramtek, Nagpur.',
        'Tabs & Shower (Jaquar) , Nagpur.', 'Sati Anusaya Mata Mandir, Administration Office, Paradshinga, Nagpur.',
        'Wapcos Water Power Infrastructural Office., Gokulpeth, Nagpur.',
    ],
    'Educational / Institutions' => [
        'Tejaswini Vidya Mandir, Jagnade Square, Nagpur.', 'Sindhi Hindi Highschool, Panchpaoli, Nagpur.',
        'Balpande Ayurvedic Collage Of Pharma, Besa, Nagpur.', 'Chubby Cheeks Internation Preschool ( Kindergarden ) Nagpur.',
        'Parmatma School, Pardi, Nagpur.',
    ],
    'Landscaping / Lawn' => [
        'Royal Karhandala Resort, Umred, Nagpur.', 'Bhatiya Farm & Banquet, Kamthi Road, Nagpur.',
        'Rajouri Garden & Lawn, Kamthi Road, Nagpur.', 'Harrison Lawn, Wathoda, Nagpur.',
        'M.S. Celebration & Lawn, Hudkeshwar Road, Nagpur.', 'Tiwari Farm, Ramtek, Nagpur.',
    ],
];
?>
<main>
<section class="section">
  <div class="wrap doc">

    <nav class="toc" aria-label="On this page">
      <h4>On this page</h4>
      <a href="#profile" class="on">Firm Profile</a>
      <a href="#services">Services</a>
      <a href="#resources">Firm Resources</a>
      <a href="#methodology">Methodology</a>
      <a href="#clientele">Clientele</a>
    </nav>

    <div class="doc__body">

      <!-- PROFILE -->
      <section class="blk" id="profile">
        <p class="eyebrow reveal">01</p>
        <h2 class="reveal" style="--d:.06s">Firm Profile</h2>
        <h3 class="sub reveal">Introduction</h3>
        <div class="est reveal">
          <span class="est__yr">2009</span>
          <p>M. B. DESIGN & BUILD is a Proprietary concern, headed by Manish V. Buradkar and having its establishment from 2009.</p>
        </div>
        <ul class="chips reveal">
          <?php foreach ($disciplines as $d): ?><li><?= e($d) ?></li><?php endforeach; ?>
        </ul>
        <p class="callrow reveal">Cell &ndash;
          <a href="tel:8600017489">8600017489</a>, <a href="tel:8087290736">8087290736</a>
        </p>
        <?php foreach ($story as $i => $p): ?>
          <p class="body reveal"><?= e($p) ?></p>
        <?php endforeach; ?>
      </section>

      <!-- SERVICES -->
      <section class="blk" id="services">
        <p class="eyebrow reveal">02</p>
        <h2 class="reveal" style="--d:.06s">Services</h2>
        <p class="body reveal">We offer a full range of professional services, which include:</p>
        <ul class="svc">
          <?php foreach ($services as $i => $s): ?>
            <li class="reveal" style="--d:<?= ($i % 2) * 0.1 ?>s"><b><?= str_pad($i + 1, 2, '0', STR_PAD_LEFT) ?></b><span><?= e($s) ?></span></li>
          <?php endforeach; ?>
        </ul>
      </section>

      <!-- RESOURCES -->
      <section class="blk" id="resources">
        <p class="eyebrow reveal">03</p>
        <h2 class="reveal" style="--d:.06s">Firm Resources</h2>
        <h3 class="sub reveal">Personnel</h3>
        <p class="body reveal">Our design teams have an exceptional range of talent and experience and have acquired considerable professional experience designing advanced, complex and iconic buildings.</p>
        <p class="body reveal">We combine this skill and technical maturity with a fresh questioning attitude and a 'hands on' approach, and are constantly looking to related disciplines and new technologies which will help us develop our design solutions to the optimum standard.</p>
        <h3 class="sub reveal">Technical Associates Group</h3>
        <ul class="assoc">
          <?php foreach ($site['team'] as $i => $m): ?>
            <li class="reveal" style="--d:<?= $i * 0.07 ?>s">
              <b><?= e($m['name']) ?></b>
              <span><?= $i === 0 ? 'M. B. DESIGN & BUILD' : e($m['role']) ?></span>
              <em><?= e($m['qual']) ?></em>
            </li>
          <?php endforeach; ?>
        </ul>
      </section>

      <!-- METHODOLOGY -->
      <section class="blk" id="methodology">
        <p class="eyebrow reveal">04</p>
        <h2 class="reveal" style="--d:.06s">Methodology</h2>
        <?php foreach ($methodology as $p): ?>
          <p class="body reveal"><?= e($p) ?></p>
        <?php endforeach; ?>
      </section>

      <!-- CLIENTELE -->
      <section class="blk" id="clientele">
        <p class="eyebrow reveal">05</p>
        <h2 class="reveal" style="--d:.06s">Clientele</h2>
        <p class="body reveal">In our experience good clients are the single most important factor in creating good architecture. Working closely with them to understand their needs and aspirations, we raise expectations and tease out the best possible solutions. Client satisfaction is evident from the large number of our repeat clients.</p>
        <p class="body reveal">Some of our respected Clients include :</p>

        <div class="counters">
          <div class="counter reveal">
            <span class="counter__n"><b data-count="200">0</b>&ndash;250</span>
            <h4>Residential Bungalows</h4>
            <p>There are more than 200- 250 Bungalows we have designed yet.</p>
          </div>
          <div class="counter reveal" style="--d:.12s">
            <span class="counter__n"><b data-count="175">0</b>&ndash;200</span>
            <h4>Interior Projects</h4>
            <p>There are more than 175- 200 Bungalows we have designed yet.</p>
          </div>
        </div>

        <div class="tabwrap reveal">
          <div class="tabs" role="tablist">
            <?php $k = 0; foreach ($clients as $cat => $list): ?>
              <button type="button" role="tab" data-tab="t<?= $k ?>" class="<?= $k === 0 ? 'on' : '' ?>"><?= e($cat) ?> <small><?= count($list) ?></small></button>
            <?php $k++; endforeach; ?>
          </div>
          <?php $k = 0; foreach ($clients as $cat => $list): ?>
            <ul class="tabpane<?= $k === 0 ? ' on' : '' ?>" id="t<?= $k ?>">
              <?php foreach ($list as $c): ?><li><?= e($c) ?></li><?php endforeach; ?>
            </ul>
          <?php $k++; endforeach; ?>
        </div>
      </section>

    </div>
  </div>
</section>
</main>
<?php include __DIR__ . '/includes/footer.php'; ?>
