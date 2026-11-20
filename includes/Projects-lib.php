
<?php
/**
 * Projects common library.
 * Public pages and admin use this file.
 *
 * Dynamic statuses/categories are supported.
 * Defaults + database entries are automatically merged.
 */

require_once __DIR__ . '/config.php';
require_once __DIR__ . '/db.php';

const PJ_DIR = 'assets/img/projects/';

/* ============================================================
   DEFAULT STATUSES
============================================================ */

const PJ_STATUS_DEFAULTS = [
    'completed' => [
        'title' => 'Completed Projects',
        'label' => 'Completed',
        'intro' => 'Projects we have designed and delivered.',
        'alias' => ['complete', 'done'],
    ],

    'ongoing' => [
        'title' => 'Ongoing Projects',
        'label' => 'Ongoing',
        'intro' => 'Projects currently under design or construction.',
        'alias' => ['inprogress', 'current'],
    ],

    'upcoming' => [
        'title' => 'Upcoming Projects',
        'label' => 'Upcoming',
        'intro' => 'Projects planned for the coming months.',
        'alias' => ['upcomming', 'future', 'planned'],
    ],
];

/* ============================================================
   DEFAULT CATEGORIES
============================================================ */

const PJ_CAT_DEFAULTS = [
    'civil' => [
        'title' => 'Civil Projects',
        'label' => 'Civil',
        'alias' => ['civilprojects', 'civilproject'],
    ],

    'interior' => [
        'title' => 'Interior Projects',
        'label' => 'Interior',
        'alias' => ['interiorprojects', 'interiorproject', 'interiors'],
    ],

    'landscape' => [
        'title' => 'Landscape Projects',
        'label' => 'Landscape',
        'alias' => ['landscapeprojects', 'landscapeproject', 'landscaping'],
    ],
];

/* ============================================================
   NAME / SLUG HELPERS
============================================================ */

function pj_slugkey($raw)
{
    return strtolower(
        preg_replace('/[^a-z0-9]/i', '', (string) $raw)
    );
}

function pj_pretty($raw)
{
    $t = trim(
        preg_replace('/\s+/', ' ', (string) $raw)
    );

    return mb_convert_case($t, MB_CASE_TITLE, 'UTF-8');
}

function pj_resolve($raw, $defaults)
{
    $k = pj_slugkey($raw);

    if ($k === '') {
        return '';
    }

    foreach ($defaults as $key => $d) {

        if (
            $k === $key ||
            in_array($k, $d['alias'], true)
        ) {
            return $key;
        }
    }

    return $k;
}

function pj_status_key($raw)
{
    return pj_resolve($raw, PJ_STATUS_DEFAULTS);
}

function pj_cat_key($raw)
{
    return pj_resolve($raw, PJ_CAT_DEFAULTS);
}

/* ============================================================
   FETCH ALL PROJECTS
============================================================ */

function pj_all()
{
    static $rows = null;

    if ($rows !== null) {
        return $rows;
    }

    global $pdo;

    $rows = [];

    try {

        $st = $pdo
            ? $pdo->query("SELECT * FROM projects ORDER BY id DESC")
            : false;

        if ($st) {
            $rows = $st->fetchAll(PDO::FETCH_ASSOC);
        }

    } catch (Throwable $e) {

        $rows = [];
    }

    foreach ($rows as &$r) {

        $r['status_key'] = pj_status_key(
            isset($r['status']) ? $r['status'] : ''
        );

        $r['cat_key'] = pj_cat_key(
            isset($r['category']) ? $r['category'] : ''
        );
    }

    unset($r);

    return $rows;
}

/* ============================================================
   BUILD DYNAMIC STATUS / CATEGORY LISTS
============================================================ */

function pj_build($defaults, $keyField, $rawField, $suffix)
{
    $out = [];

    /* Default entries */

    foreach ($defaults as $k => $d) {

        $out[$k] = [
            'title'   => $d['title'],
            'tab'     => $d['label'],
            'label'   => $d['label'],
            'intro'   => isset($d['intro']) ? $d['intro'] : '',
            'default' => true,
        ];
    }

    /* Dynamic entries from database */

    $extra = [];

    foreach (pj_all() as $p) {

        $k = isset($p[$keyField]) ? $p[$keyField] : '';

        if (
            $k === '' ||
            isset($out[$k]) ||
            isset($extra[$k])
        ) {
            continue;
        }

        $label = pj_pretty(
            isset($p[$rawField]) ? $p[$rawField] : $k
        );

        $extra[$k] = [
            'title'   => $label . $suffix,
            'tab'     => $label,
            'label'   => $label,
            'intro'   => '',
            'default' => false,
        ];
    }

    /* Alphabetically sort additional entries */

    uasort($extra, function ($a, $b) {
        return strcasecmp($a['label'], $b['label']);
    });

    return $out + $extra;
}

/* ============================================================
   STATUSES
============================================================ */

function pj_statuses()
{
    static $s = null;

    if ($s === null) {
        $s = pj_build(
            PJ_STATUS_DEFAULTS,
            'status_key',
            'status',
            ' Projects'
        );
    }

    return $s;
}

/* ============================================================
   CATEGORIES
============================================================ */

function pj_categories()
{
    static $c = null;

    if ($c === null) {
        $c = pj_build(
            PJ_CAT_DEFAULTS,
            'cat_key',
            'category',
            ' Projects'
        );
    }

    return $c;
}

/* ============================================================
   PROJECT LIST
============================================================ */

function pj_list($status = null, $cat = null)
{
    $out = [];

    foreach (pj_all() as $p) {

        if (
            $status !== null &&
            $p['status_key'] !== $status
        ) {
            continue;
        }

        if (
            $cat !== null &&
            $p['cat_key'] !== $cat
        ) {
            continue;
        }

        $out[] = $p;
    }

    return $out;
}

/* ============================================================
   FIND PROJECT
============================================================ */

function pj_find($slug)
{
    foreach (pj_all() as $p) {

        if (
            isset($p['slug']) &&
            $p['slug'] === $slug
        ) {
            return $p;
        }
    }

    return null;
}

/* ============================================================
   PROJECT COVER
============================================================ */

function pj_cover($p)
{
    return trim(
        (string) (
            isset($p['thumb']) ? $p['thumb'] : ''
        )
    );
}

/* ============================================================
   PROJECT EXTRA IMAGES
============================================================ */

function pj_images($id)
{
    global $pdo;

    try {

        $st = $pdo
            ? $pdo->prepare(
                "SELECT file
                 FROM project_images
                 WHERE project_id = ?
                 ORDER BY sort_order ASC, id ASC"
            )
            : false;

        if (!$st || !$st->execute([(int) $id])) {
            return [];
        }

        return $st->fetchAll(PDO::FETCH_COLUMN);

    } catch (Throwable $e) {

        return [];
    }
}

/* ============================================================
   PROJECT GALLERY
============================================================ */

function pj_gallery($p)
{
    $out = [];

    $c = pj_cover($p);

    if ($c !== '') {
        $out[] = $c;
    }

    foreach (pj_images((int) $p['id']) as $f) {

        if (!in_array($f, $out, true)) {
            $out[] = $f;
        }
    }

    return $out;
}

/* ============================================================
   CATEGORY COVER
============================================================ */

function pj_cat_cover($status, $cat)
{
    $lists = [
        pj_list($status, $cat),
        pj_list(null, $cat),
    ];

    foreach ($lists as $list) {

        foreach ($list as $p) {

            if (pj_cover($p) !== '') {
                return pj_cover($p);
            }
        }
    }

    return '';
}

/* ============================================================
   URL HELPERS
============================================================ */

function pj_url($p)
{
    return 'project.php?id=' . rawurlencode($p['slug']);
}

function pj_status_url($s)
{
    return 'projects.php?status=' . rawurlencode($s);
}

function pj_cat_url($s, $c)
{
    return 'project-category.php?status='
        . rawurlencode($s)
        . '&cat='
        . rawurlencode($c);
}

/* ============================================================
   BACKWARD COMPATIBILITY
   Older public pages use PJ_STATUSES and PJ_CATEGORIES.
============================================================ */

if (!defined('PJ_STATUSES')) {
    define('PJ_STATUSES', pj_statuses());
}

if (!defined('PJ_CATEGORIES')) {
    define('PJ_CATEGORIES', pj_categories());
}
