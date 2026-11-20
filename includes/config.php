<?php
/**
 * MB Design & Build - site settings.
 * Content yahin se change hota hai, HTML ko haath lagane ki zaroorat nahi.
 */

$site = [
    'name'    => 'MB DESIGN & BUILD',
    'domain'  => 'www.mbdesign.in',
    'tagline' => 'Our Interiors Are An Insight Into Our Brains.....!',
'logo' => 'assets/img/mblogooo.png', // Yahan apne Original Logo ka exact path daalein

    // YouTube video ID (link me v= ke baad wala hissa). Khali chhodoge to placeholder dikhega.
    'youtube_id' => 'ERomFl0e59k',

    'menu' => [
        ['label' => 'Home',     'url' => 'index.php'],
        ['label' => 'About',    'url' => 'about.php', 'children' => [
            ['label' => 'About Us',            'url' => 'about.php'],
            ['label' => 'Firm Resources',      'url' => 'firm.php'],
            ['label' => 'Terms & Conditions',  'url' => 'terms.php'],
        ]],
        ['label' => 'Services', 'url' => 'services.php'],
        ['label' => 'Achivements',  'url' => 'Achivements.php'],
                ['label' => 'Gallery',  'url' => 'gallery.php'],

        ['label' => 'Projects', 'url' => 'projects.php?status=completed', 'children' => [
            ['label' => 'Completed', 'url' => 'projects.php?status=completed'],
            ['label' => 'On Going',  'url' => 'projects.php?status=ongoing'],
            ['label' => 'Upcoming',  'url' => 'projects.php?status=upcoming'],
        ]],
        ['label' => 'Contact',  'url' => 'contact.php'],
    ],

    'about' => [
        'eyebrow' => 'About',
        'title'   => 'Welcome to MB DESIGN & BUILD',
        'text'    => 'M. B. DESIGN & BUILD is a growing, full-service integrated Architecture, Planning and Interior Designing firm dedicated to the concept that any kind of design and architecture is a socially responsible and environmentally respectful pursuit. We believe that buildings are best when they express their purpose and interact sympathetically with their surroundings. M. B. DESIGN & BUILD promotes fair and affordable housing, community involvement, historic preservation, sustainability and resource management. In recent years we have completed numerous commercial, educational, residential, landscaping, and interior projects for a variety of public and private clients. We believe our success is attributable to our attention to detail, technical experience, creativity, and true professionalism that we bring to every project.',
    ],

    'about_quote'  => 'Buildings are best when they express their purpose and interact sympathetically with their surroundings.',
    'about_points' => ['Fair & Affordable Housing', 'Community Involvement', 'Historic Preservation', 'Sustainability', 'Resource Management', 'Commercial', 'Educational', 'Residential', 'Landscaping', 'Interior'],

    'short_title' => 'Short Description of MB Design & Build',
    'short' => [
        ['label' => 'Team Approach', 'img' => 'assets/img/pr38.jpg','text' => 'M. B. DESIGN & BUILD operates on the team approach, bringing together owners, users and professionals in a collaboration of knowledge, needs and efforts, realizing greater results and enhanced solutions.'],
        ['label' => 'Creative Thinking', 'img' => 'assets/img/pr100.jpg','text' => 'We constantly strive to explore creative opportunities within each project undertaken and look forward to achieving many more milestones, consolidating on our infrastructure continuously and perfecting ourselves every moment.'],
        ['label' => 'Open Mind', 'img' => 'assets/img/pr222.jpg','text' => 'We maintain an open-minded attitude and are always ready to question and challenge in order to find the best possible solution.'],
    ],

    'clients_title' => 'What Our Client Says...',
    'clients' => [
        ['logo' => 'assets/img/shiv.jpg',  'name' => 'Shiv Sena Bhavan, Nagpur'],
        ['logo' => 'assets/img/royal.jpg',     'name' => 'Royal Karandla Resort, Umred'],
        ['logo' => 'assets/img/anand.jpg','name' => 'Anand Rathi, Nagpur'],
        ['logo' => 'assets/img/air.jpg',  'name' => 'Air India MRO, Nagpur'],
    ],

    // About / Firm pages
    'story' => [
        'M. B. DESIGN & BUILD is a growing, full-service integrated Architecture, Planning and Interior Designing firm dedicated to the concept that any kind of design and architecture is a socially responsible and environmentally respectful pursuit. We believe that buildings are best when they express their purpose and interact sympathetically with their surroundings.',
        'M. B. DESIGN & BUILD promotes fair and affordable housing, community involvement, historic preservation, sustainability and resource management. In recent years we have completed numerous commercial, educational, residential, landscaping, and interior projects for a variety of public and private clients. We believe our success is attributable to our attention to detail, technical experience, creativity, and true professionalism that we bring to every project.',
        'M. B. DESIGN & BUILD operates on the team approach, bringing together owners, users and professionals in a collaboration of knowledge, needs and efforts, realizing greater results and enhanced solutions.',
        'We constantly strive to explore creative opportunities within each project undertaken and look forward to achieving many more milestones, consolidating on our infrastructure continuously and perfecting ourselves every moment.',
        'We maintain an open-minded attitude and are always ready to question and challenge in order to find the best possible solution.',
    ],
    'about_img' => 'assets/img/a1.jpg',
    'team' => [
        ['name' => 'Mr. MANISH V. BURADKAR',  'role' => 'Director/Architect & Interior Designer', 'qual' => 'B.C.S., B.Sc. (I.D.)', 'img' => 'assets/img/team3.jpg'],
        ['name' => 'Mr. SHRIKANT M. BANKAR',  'role' => 'Civil Engineer',                         'qual' => 'B.E. Civil',          'img' => 'assets/img/team1.jpg'],
        ['name' => 'Mr. VIJENDRA KALAMBE',    'role' => 'Structural Designer',                    'qual' => 'M.Tech. (Structures)','img' => 'assets/img/team4.jpg'],
        ['name' => 'Mr. DASHRATH BOKDE',      'role' => '3D Designer',                            'qual' => '',                    'img' => 'assets/img/team5.jpg'],
        ['name' => 'Mr. JAY ROKDE',           'role' => 'Civil Engineer & 3D Designer',           'qual' => '',                    'img' => 'assets/img/team2.jpg'],
    ],

    'skills' => ['MASTER PLANNING', 'PANCTUALITY', 'TRANSPERANCY', 'QUALITY WORK'],

    'contact' => [
        'head'   => ['Block No. 21, Tulsi Apartment,', 'Telephone Exchange Square, C.A. Road, Nagpur-08'],
        'branch' => ['41, Amrapali Nagar, Nr. Sai Nagar-2,', 'Bus Stop, Hudkeshwar Road, Nagpur-34.'],
        'emails' => ['info@mbdesign.in', 'mnish.int@gmail.com'],
        'phones' => ['+91 8600017489', '+91 8087290736'],
        'social' => ['facebook' => '#', 'instagram' => '#', 'youtube' => '#'],
    ],
];

/** Safe output helper */
if (!function_exists('e')) {
    function e($v) { return htmlspecialchars((string)$v, ENT_QUOTES, 'UTF-8'); }
}

/** Menu item (ya uska child) current page hai? Query string ignore hoti hai; detail pages parent ko active rakhte hain. */
function menu_active($item, $current) {
    $related = [
        'gallery.php'  => ['gallery-view.php'],
        'projects.php' => ['project-category.php', 'project.php'],
    ];
    $match = function ($url) use ($current, $related) {
        $file = basename((string)parse_url($url, PHP_URL_PATH));
        return $file === $current || in_array($current, isset($related[$file]) ? $related[$file] : [], true);
    };
    if ($match($item['url'])) return true;
    foreach (isset($item['children']) ? $item['children'] : [] as $c) {
        if ($match($c['url'])) return true;
    }
    return false;
}

/** "Mr. MANISH V. BURADKAR" -> "MB" (photo na ho to initials dikhte hain) */
function initials($name) {
    $name = trim(preg_replace('/^Mr\.?\s*/i', '', $name));
    $w = preg_split('/[\s.]+/', $name, -1, PREG_SPLIT_NO_EMPTY);
    $first = $w[0] ?? '';
    $last  = count($w) > 1 ? end($w) : '';
    return strtoupper(mb_substr($first, 0, 1) . mb_substr($last, 0, 1));
}