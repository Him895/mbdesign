<?php
if (session_status() === PHP_SESSION_NONE) session_start();
require_once __DIR__ . '/../includes/config.php';
require_once __DIR__ . '/../includes/db.php';
require_once __DIR__ . '/../includes/projects-lib.php';

if (!isset($_SESSION['admin'])) {
    header('Location: login.php');
    exit;
}
if (empty($_SESSION['csrf'])) $_SESSION['csrf'] = bin2hex(random_bytes(16));
$csrf = $_SESSION['csrf'];

$root      = dirname(__DIR__);
$uploadAbs = $root . '/' . PJ_DIR;

/* ---------- extra photos ki table (pehli baar khud ban jati hai) ---------- */
$driver = $pdo->getAttribute(PDO::ATTR_DRIVER_NAME);
if ($driver === 'sqlite') {
    $pdo->exec("CREATE TABLE IF NOT EXISTS project_images (id INTEGER PRIMARY KEY AUTOINCREMENT, project_id INTEGER NOT NULL, file VARCHAR(255) NOT NULL, sort_order INTEGER NOT NULL DEFAULT 0)");
} else {
    $pdo->exec("CREATE TABLE IF NOT EXISTS project_images (id INT AUTO_INCREMENT PRIMARY KEY, project_id INT NOT NULL, file VARCHAR(255) NOT NULL, sort_order INT NOT NULL DEFAULT 0, KEY idx_project (project_id)) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");
}

/* ---------- helpers ---------- */
function adm_slug($pdo, $title, $ignoreId = 0) {
    $base = trim(preg_replace('/[^a-z0-9]+/', '-', strtolower($title)), '-');
    $base = trim(substr($base, 0, 80), '-');            // slug column 100 chars ka hai
    if ($base === '') $base = 'project';
    $slug = $base; $n = 2;
    $st = $pdo->prepare("SELECT COUNT(*) FROM projects WHERE slug = ? AND id <> ?");
    while (true) {
        $st->execute([$slug, $ignoreId]);
        if (!(int)$st->fetchColumn()) return $slug;
        $slug = $base . '-' . $n++;
    }
}
/** Sirf asli image allow: type file ke andar se check hota hai, extension se nahi. */
function adm_store_image($tmp, $origName, $slug, $uploadAbs) {
    if (!is_uploaded_file($tmp)) throw new RuntimeException('Upload fail hua: ' . $origName);
    if (filesize($tmp) > 8 * 1024 * 1024) throw new RuntimeException('Image 8MB se choti honi chahiye: ' . $origName);
    $info = @getimagesize($tmp);
    $map = [IMAGETYPE_JPEG => 'jpg', IMAGETYPE_PNG => 'png', IMAGETYPE_WEBP => 'webp', IMAGETYPE_GIF => 'gif'];
    if (!$info || !isset($map[$info[2]])) throw new RuntimeException('Sirf JPG / PNG / WEBP / GIF image allowed hai: ' . $origName);
    if (!is_dir($uploadAbs)) mkdir($uploadAbs, 0755, true);
    $name = $slug . '-' . bin2hex(random_bytes(4)) . '.' . $map[$info[2]];
    if (!move_uploaded_file($tmp, $uploadAbs . $name)) throw new RuntimeException('Image save nahi ho saki: ' . $origName);
    return PJ_DIR . $name;
}
function adm_unlink($rel, $root) {
    $rel = (string)$rel;
    if ($rel === '' || strpos($rel, PJ_DIR) !== 0 || strpos($rel, '..') !== false) return;
    $p = $root . '/' . $rel;
    if (is_file($p)) @unlink($p);
}
function adm_files($key) {
    $out = [];
    if (empty($_FILES[$key])) return $out;
    $f = $_FILES[$key];
    if (is_array($f['name'])) {
        foreach ($f['name'] as $i => $n) {
            if ($f['error'][$i] === UPLOAD_ERR_NO_FILE) continue;
            $out[] = ['name' => $n, 'tmp' => $f['tmp_name'][$i], 'err' => $f['error'][$i]];
        }
    } elseif ($f['error'] !== UPLOAD_ERR_NO_FILE) {
        $out[] = ['name' => $f['name'], 'tmp' => $f['tmp_name'], 'err' => $f['error']];
    }
    foreach ($out as $o) {
        if ($o['err'] !== UPLOAD_ERR_OK) throw new RuntimeException('Upload error (' . $o['name'] . '). Image bahut badi ho sakti hai.');
    }
    return $out;
}
function adm_post($k, $max = 0) {
    $v = isset($_POST[$k]) && is_string($_POST[$k]) ? trim($_POST[$k]) : '';
    return $max ? mb_substr($v, 0, $max) : $v;
}
/** Dropdown ki choice (ya "__new__" + naya naam) ko (key, database me likhne ka text) me badalta hai. */
function adm_pick($what, $sel, $newText, $list, $resolver) {
    if ($sel === '__new__') {
        if ($newText === '') throw new RuntimeException('Naya ' . $what . ' ka naam likhiye.');
        $key = $resolver($newText);
        if ($key === '') throw new RuntimeException($what . ' ke naam me kam se kam ek English letter ya number hona chahiye.');
        $label = isset($list[$key]) ? $list[$key]['label'] : pj_pretty($newText);
        return [$key, $label];
    }
    if (!isset($list[$sel])) throw new RuntimeException(ucfirst($what) . ' chuniye.');
    return [$sel, $list[$sel]['label']];
}
function adm_flash($type, $msg) { $_SESSION['flash'] = [$type, $msg]; }
function adm_redirect($url) { header('Location: ' . $url); exit; }

$error = '';
$form  = null;   // form dobara dikhana ho (error par) to yahan values aati hain

/* ---------- POST actions ---------- */
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!hash_equals($csrf, (string)(isset($_POST['csrf']) ? $_POST['csrf'] : ''))) {
        adm_flash('err', 'Session expire ho gaya. Dobara try karein.');
        adm_redirect('projects.php');
    }
    $act = isset($_POST['action']) ? $_POST['action'] : '';

    try {
        if ($act === 'save') {
            $id    = (int)adm_post('id');
            $title = adm_post('title', 250);
            $f = [
                'title' => $title,
                'status' => adm_post('status'), 'status_new' => adm_post('status_new', 100),
                'category' => adm_post('category'), 'category_new' => adm_post('category_new', 100),
                'year' => adm_post('year', 20),
                'location' => adm_post('location', 250),
                'area' => adm_post('area', 100),
                'client' => adm_post('client', 100),
                'description' => adm_post('description', 5000),
            ];
            $form = $f + ['id' => $id];

            if ($title === '') throw new RuntimeException('Project ka title likhna zaroori hai.');
            list($statusKey, $statusText) = adm_pick('status', $f['status'], $f['status_new'], pj_statuses(), 'pj_status_key');
            list($catKey, $catText)       = adm_pick('category', $f['category'], $f['category_new'], pj_categories(), 'pj_cat_key');

            $cover  = adm_files('thumb');
            $photos = adm_files('photos');

            if ($id > 0) {                                   // ---- EDIT
                $st = $pdo->prepare("SELECT * FROM projects WHERE id = ?");
                $st->execute([$id]);
                $old = $st->fetch(PDO::FETCH_ASSOC);
                if (!$old) throw new RuntimeException('Project nahi mila.');
                $thumb = (string)$old['thumb'];
                if ($cover) {
                    $thumb = adm_store_image($cover[0]['tmp'], $cover[0]['name'], $old['slug'], $uploadAbs);
                    adm_unlink($old['thumb'], $root);
                }
                $pdo->prepare("UPDATE projects SET title=?, category=?, status=?, year=?, location=?, area=?, client=?, description=?, thumb=? WHERE id=?")
                    ->execute([$title, $catText, $statusText, $f['year'], $f['location'], $f['area'], $f['client'], $f['description'], $thumb, $id]);
                $slug = $old['slug'];
            } else {                                         // ---- ADD
                if (!$cover) throw new RuntimeException('Cover (thumbnail) image zaroori hai.');
                $slug  = adm_slug($pdo, $title);
                $thumb = adm_store_image($cover[0]['tmp'], $cover[0]['name'], $slug, $uploadAbs);
                $pdo->prepare("INSERT INTO projects (slug,title,category,status,year,location,area,client,description,thumb) VALUES (?,?,?,?,?,?,?,?,?,?)")
                    ->execute([$slug, $title, $catText, $statusText, $f['year'], $f['location'], $f['area'], $f['client'], $f['description'], $thumb]);
                $id = (int)$pdo->lastInsertId();
            }

            if ($photos) {
                $mx = $pdo->prepare("SELECT COALESCE(MAX(sort_order),0) FROM project_images WHERE project_id = ?");
                $mx->execute([$id]);
                $n = (int)$mx->fetchColumn();
                $ins = $pdo->prepare("INSERT INTO project_images (project_id, file, sort_order) VALUES (?,?,?)");
                foreach ($photos as $ph) {
                    $ins->execute([$id, adm_store_image($ph['tmp'], $ph['name'], $slug, $uploadAbs), ++$n]);
                }
            }
            adm_flash('ok', 'Project save ho gaya.');
            adm_redirect('projects.php');
        }

        if ($act === 'delete') {
            $id = (int)adm_post('id');
            $st = $pdo->prepare("SELECT thumb FROM projects WHERE id = ?");
            $st->execute([$id]);
            $row = $st->fetch(PDO::FETCH_ASSOC);
            if ($row) {
                adm_unlink($row['thumb'], $root);
                $im = $pdo->prepare("SELECT file FROM project_images WHERE project_id = ?");
                $im->execute([$id]);
                foreach ($im->fetchAll(PDO::FETCH_COLUMN) as $file) adm_unlink($file, $root);
                $pdo->prepare("DELETE FROM project_images WHERE project_id = ?")->execute([$id]);
                $pdo->prepare("DELETE FROM projects WHERE id = ?")->execute([$id]);
                adm_flash('ok', 'Project delete ho gaya.');
            }
            adm_redirect('projects.php');
        }

        if ($act === 'delete_image') {
            $pid = (int)adm_post('project_id');
            $st = $pdo->prepare("SELECT file FROM project_images WHERE id = ? AND project_id = ?");
            $st->execute([(int)adm_post('image_id'), $pid]);
            $file = $st->fetchColumn();
            if ($file !== false) {
                adm_unlink($file, $root);
                $pdo->prepare("DELETE FROM project_images WHERE id = ?")->execute([(int)adm_post('image_id')]);
                adm_flash('ok', 'Photo hata di.');
            }
            adm_redirect('projects.php?edit=' . $pid);
        }
    } catch (RuntimeException $e) {
        $error = $e->getMessage();     // form wapas dikhega, bhari hui values ke saath
    }
}

/* ---------- kya dikhana hai ---------- */
$statuses = pj_statuses();
$cats     = pj_categories();
$mode = 'list'; $editRow = null; $editImages = [];

if ($form !== null || isset($_GET['new']) || isset($_GET['edit'])) {
    $mode = 'form';
    $eid = $form !== null ? (int)$form['id'] : (int)(isset($_GET['edit']) ? $_GET['edit'] : 0);
    if ($eid > 0) {
        $st = $pdo->prepare("SELECT * FROM projects WHERE id = ?");
        $st->execute([$eid]);
        $editRow = $st->fetch(PDO::FETCH_ASSOC);
        if (!$editRow) { adm_flash('err', 'Project nahi mila.'); adm_redirect('projects.php'); }
        $im = $pdo->prepare("SELECT id, file FROM project_images WHERE project_id = ? ORDER BY sort_order, id");
        $im->execute([$eid]);
        $editImages = $im->fetchAll(PDO::FETCH_ASSOC);
    }
    if ($form === null) {
        if ($editRow) {
            $sk = pj_status_key($editRow['status']); $ck = pj_cat_key($editRow['category']);
            $form = [
                'id' => (int)$editRow['id'], 'title' => $editRow['title'],
                'status' => isset($statuses[$sk]) ? $sk : '', 'status_new' => '',
                'category' => isset($cats[$ck]) ? $ck : '', 'category_new' => '',
                'year' => (string)$editRow['year'], 'location' => (string)$editRow['location'], 'area' => (string)$editRow['area'],
                'client' => (string)$editRow['client'], 'description' => (string)$editRow['description'],
            ];
        } else {
            $form = ['id' => 0, 'title' => '', 'status' => 'completed', 'status_new' => '', 'category' => 'civil', 'category_new' => '',
                     'year' => '', 'location' => '', 'area' => '', 'client' => '', 'description' => ''];
        }
    }
    $editCover = $editRow ? trim((string)$editRow['thumb']) : '';
} else {
    $all = $pdo->query("SELECT p.*, (SELECT COUNT(*) FROM project_images i WHERE i.project_id = p.id) AS img_count FROM projects p ORDER BY p.id DESC")->fetchAll(PDO::FETCH_ASSOC);
    $stCount = []; foreach ($statuses as $k => $_) $stCount[$k] = 0;
    foreach ($all as &$r) {
        $r['sk'] = pj_status_key($r['status']); $r['ck'] = pj_cat_key($r['category']);
        if (isset($stCount[$r['sk']])) $stCount[$r['sk']]++;
    }
    unset($r);
    $fs = isset($_GET['status']) && is_string($_GET['status']) && isset($statuses[$_GET['status']]) ? $_GET['status'] : '';
    $fc = isset($_GET['cat'])    && is_string($_GET['cat'])    && isset($cats[$_GET['cat']])         ? $_GET['cat']    : '';
    $rows = array_values(array_filter($all, function ($r) use ($fs, $fc) {
        return ($fs === '' || $r['sk'] === $fs) && ($fc === '' || $r['ck'] === $fc);
    }));
    $qs = function ($s, $c) { $a = array_filter(['status' => $s, 'cat' => $c]); return 'projects.php' . ($a ? '?' . http_build_query($a) : ''); };
}
$flash = isset($_SESSION['flash']) ? $_SESSION['flash'] : null;
unset($_SESSION['flash']);
$logo = '../' . $site['logo'];
$exts = 'image/jpeg,image/png,image/webp,image/gif';
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?= $mode === 'form' ? ($form['id'] ? 'Edit Project' : 'Add Project') : 'Projects' ?> | Admin - <?= e($site['name']) ?></title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@600;700&family=Montserrat:wght@400;500;600;700&display=swap" rel="stylesheet">
<style>
:root{--gold:#b99b50;--gold-d:#8f7436;--gold-l:#e3cd96;--ink:#16140f;--ink2:#241f14;--mute:#6b655a;--soft:#f7f4ee;--line:#e8e0cc;--h:'Cormorant Garamond',Georgia,serif;--b:'Montserrat',system-ui,sans-serif;--ease:cubic-bezier(.2,.7,.2,1)}
*{box-sizing:border-box;margin:0;padding:0}
body{font-family:var(--b);background:var(--soft);color:var(--ink);line-height:1.6;min-height:100vh}
a{color:inherit;text-decoration:none}

/* top bar */
.bar{background:linear-gradient(120deg,var(--ink),var(--ink2));color:#fff;position:sticky;top:0;z-index:50;box-shadow:0 6px 24px rgba(0,0,0,.25)}
.bar__in{max-width:1240px;margin:0 auto;padding:12px 24px;display:flex;align-items:center;justify-content:space-between;gap:20px}
.brand{display:flex;align-items:center;gap:12px;font-weight:700;letter-spacing:.16em;font-size:.78rem}
.brand img{height:40px;width:auto}
.brand b{font-family:var(--h);font-size:1.9rem;color:var(--gold);letter-spacing:0}
.brand em{font-style:normal;color:var(--gold-l);border:1px solid rgba(227,205,150,.5);padding:2px 10px;border-radius:20px;font-size:.62rem;margin-left:6px}
.nav{display:flex;gap:4px}
.nav a{padding:9px 18px;border-radius:30px;font-size:.78rem;font-weight:600;letter-spacing:.05em;color:#e8e1cf;transition:.3s}
.nav a:hover{background:rgba(255,255,255,.1)}.nav a.on{background:var(--gold);color:#fff}

.wrap{max-width:1240px;margin:0 auto;padding:34px 24px 80px}
.head{display:flex;justify-content:space-between;align-items:flex-end;gap:20px;flex-wrap:wrap;margin-bottom:28px}
.eyebrow{color:var(--gold-d);font-weight:700;letter-spacing:.3em;text-transform:uppercase;font-size:.7rem}
h1{font-family:var(--h);font-size:clamp(2rem,4vw,2.9rem);line-height:1.1}
.rule{display:block;width:60px;height:3px;background:var(--gold);border-radius:3px;margin-top:12px}

.btn{display:inline-flex;align-items:center;gap:8px;background:var(--gold);color:#fff;padding:12px 26px;border-radius:40px;border:0;cursor:pointer;font:700 .8rem var(--b);letter-spacing:.07em;transition:transform .3s var(--ease),box-shadow .3s,background .3s;box-shadow:0 8px 22px rgba(185,155,80,.35)}
.btn:hover{transform:translateY(-2px);background:var(--gold-d)}
.btn.dark{background:var(--ink);box-shadow:none}.btn.dark:hover{background:#000}
.btn.line{background:transparent;color:var(--ink);border:1.5px solid var(--line);box-shadow:none}.btn.line:hover{border-color:var(--gold);color:var(--gold-d);background:transparent}
.btn.sm{padding:7px 16px;font-size:.7rem;box-shadow:none}
.btn.del{background:#fff;color:#c0392b;border:1.5px solid #f0c6c1;box-shadow:none}.btn.del:hover{background:#c0392b;color:#fff;border-color:#c0392b}
.btn.block{width:100%;justify-content:center}

.toast{display:flex;gap:10px;align-items:center;padding:14px 20px;border-radius:14px;margin-bottom:22px;font-weight:600;font-size:.88rem;animation:drop .6s var(--ease)}
.toast.ok{background:#e8f5e9;color:#2e7d32;border:1px solid #c5e3c8}.toast.err{background:#fdecea;color:#a12622;border:1px solid #f3c4bf}
@keyframes drop{from{opacity:0;transform:translateY(-14px)}to{opacity:1;transform:none}}

/* stats */
.stats{display:grid;grid-template-columns:repeat(auto-fit,minmax(170px,1fr));gap:16px;margin-bottom:30px}
.stat{position:relative;overflow:hidden;background:#fff;border:1px solid var(--line);border-radius:18px;padding:20px 22px;transition:.4s var(--ease)}
.stat:hover{transform:translateY(-4px);box-shadow:0 18px 40px rgba(60,45,10,.12);border-color:var(--gold)}
.stat small{display:block;font-size:.66rem;letter-spacing:.22em;text-transform:uppercase;color:var(--mute);font-weight:600}
.stat b{font-family:var(--h);font-size:2.8rem;line-height:1.1;color:var(--ink)}
.stat::after{content:"";position:absolute;right:-18px;top:-18px;width:70px;height:70px;border-radius:50%;background:rgba(185,155,80,.14)}
.stat.dark{background:var(--ink);border-color:var(--ink)}.stat.dark small{color:var(--gold-l)}.stat.dark b{color:var(--gold)}

/* panel + filters */
.panel{background:#fff;border:1px solid var(--line);border-radius:22px;box-shadow:0 14px 40px rgba(60,45,10,.07);overflow:hidden}
.tools{padding:20px 24px;border-bottom:1px solid var(--line);display:flex;flex-direction:column;gap:12px}
.chips{display:flex;flex-wrap:wrap;gap:8px;align-items:center}
.chips span{font-size:.66rem;letter-spacing:.2em;text-transform:uppercase;color:var(--mute);font-weight:700;min-width:70px}
.chips a{padding:7px 16px;border-radius:30px;border:1px solid var(--line);font-size:.76rem;font-weight:600;color:var(--mute);transition:.3s}
.chips a small{opacity:.6;margin-left:3px}
.chips a:hover{border-color:var(--gold);color:var(--gold-d)}
.chips a.on{background:var(--ink);border-color:var(--ink);color:#fff}
.search{position:relative}
.search input{width:100%;padding:12px 18px 12px 44px;border:1.5px solid var(--line);border-radius:40px;font:500 .9rem var(--b);background:var(--soft);transition:.3s}
.search input:focus{outline:0;border-color:var(--gold);background:#fff;box-shadow:0 0 0 4px rgba(185,155,80,.15)}
.search svg{position:absolute;left:16px;top:50%;margin-top:-9px;width:18px;height:18px;stroke:var(--gold-d);fill:none;stroke-width:2;stroke-linecap:round}
.scroll{overflow-x:auto}
table{width:100%;border-collapse:collapse;min-width:860px}
th{background:var(--ink);color:var(--gold-l);font-size:.66rem;letter-spacing:.2em;text-transform:uppercase;text-align:left;padding:14px 16px;font-weight:700}
td{padding:14px 16px;border-bottom:1px solid #f0ead9;vertical-align:middle;font-size:.88rem}
tbody tr{transition:background .25s}tbody tr:hover{background:#fbf8f1}
.cover{width:84px;height:58px;border-radius:10px;object-fit:cover;background:linear-gradient(135deg,var(--gold-l),var(--gold-d));display:block;box-shadow:0 4px 12px rgba(0,0,0,.12)}
.ttl{font-family:var(--h);font-size:1.2rem;font-weight:700;line-height:1.2}
.sub{font-size:.74rem;color:var(--mute)}
.pill{display:inline-block;padding:4px 13px;border-radius:30px;font-size:.7rem;font-weight:700;letter-spacing:.04em}
.p-cat{background:#f3eddc;color:#6a5622}.p-completed{background:#e6f4e8;color:#2e7d32}.p-ongoing{background:#fff3d1;color:#8a6a00}.p-upcoming{background:#e3ecfb;color:#1f4f9a}.p-other{background:#efe8f7;color:#59307f}.p-bad{background:#fdecea;color:#a12622}
.act{display:flex;gap:6px;flex-wrap:wrap}.act form{margin:0}
.empty{text-align:center;padding:60px 20px;color:var(--mute)}
.empty b{display:block;font-family:var(--h);font-size:1.8rem;color:var(--ink);margin-bottom:6px}

/* form */
.layout{display:grid;grid-template-columns:1fr 340px;gap:26px;align-items:start}
.card{background:#fff;border:1px solid var(--line);border-radius:20px;padding:26px;box-shadow:0 10px 30px rgba(60,45,10,.06);margin-bottom:22px}
.card h3{font-family:var(--h);font-size:1.5rem;margin-bottom:4px}
.card .note{font-size:.76rem;color:var(--mute);margin-bottom:14px}
.side{position:sticky;top:84px}
label.l{display:block;font-size:.68rem;letter-spacing:.16em;text-transform:uppercase;font-weight:700;color:var(--gold-d);margin:16px 0 6px}
label.l small{text-transform:none;letter-spacing:0;color:var(--mute);font-weight:500}
input[type=text],select,textarea{width:100%;padding:13px 16px;border:1.5px solid var(--line);border-radius:12px;font:500 .92rem var(--b);background:var(--soft);color:var(--ink);transition:.3s}
select{appearance:none;background-image:url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='8'%3E%3Cpath d='M1 1l5 5 5-5' fill='none' stroke='%238f7436' stroke-width='2' stroke-linecap='round'/%3E%3C/svg%3E");background-repeat:no-repeat;background-position:right 16px center;padding-right:40px;cursor:pointer}
input:focus,select:focus,textarea:focus{outline:0;border-color:var(--gold);background-color:#fff;box-shadow:0 0 0 4px rgba(185,155,80,.15)}
textarea{min-height:170px;resize:vertical}
.grid2{display:grid;grid-template-columns:1fr 1fr;gap:0 16px}
.newbox{margin-top:8px;padding:12px;border:1.5px dashed var(--gold);border-radius:12px;background:#fffaf0;animation:drop .4s var(--ease)}
.newbox[hidden]{display:none}
.newbox small{display:block;font-size:.7rem;color:var(--gold-d);margin-bottom:6px;font-weight:600}
.drop{position:relative;display:block;border:2px dashed #d8cba6;border-radius:16px;background:var(--soft);min-height:150px;overflow:hidden;cursor:pointer;transition:.3s}
.drop:hover,.drop.over{border-color:var(--gold);background:#fffaf0}
.drop input{position:absolute;inset:0;width:100%;height:100%;opacity:0;cursor:pointer}
.drop__ph{position:absolute;inset:0;display:flex;flex-direction:column;align-items:center;justify-content:center;gap:4px;text-align:center;padding:14px;color:var(--mute);font-size:.78rem;pointer-events:none}
.drop__ph svg{width:34px;height:34px;stroke:var(--gold-d);fill:none;stroke-width:1.6;stroke-linecap:round;stroke-linejoin:round}
.drop__ph b{color:var(--ink);font-size:.86rem}
.drop img.pv{position:absolute;inset:0;width:100%;height:100%;object-fit:cover;pointer-events:none}
.drop.has .drop__ph{display:none}
.drop.has::after{content:"Badalne ke liye click / drop karo";position:absolute;left:0;right:0;bottom:0;padding:8px;text-align:center;font-size:.7rem;font-weight:600;color:#fff;background:linear-gradient(transparent,rgba(0,0,0,.7));pointer-events:none}
.drop.multi{min-height:120px}
.thumbs{display:grid;grid-template-columns:repeat(auto-fill,minmax(92px,1fr));gap:10px;margin-top:12px}
.th{position:relative;border-radius:10px;overflow:hidden;background:var(--soft);aspect-ratio:1}
.th img{width:100%;height:100%;object-fit:cover;display:block}
.th form{position:absolute;right:5px;top:5px;margin:0}
.th button{width:24px;height:24px;border-radius:50%;border:0;background:#c0392b;color:#fff;cursor:pointer;font-size:.95rem;line-height:1;box-shadow:0 2px 8px rgba(0,0,0,.3)}
.th.new::after{content:"NEW";position:absolute;left:5px;bottom:5px;background:var(--gold);color:#fff;font-size:.56rem;font-weight:700;letter-spacing:.1em;padding:2px 7px;border-radius:20px}
.acts{display:flex;gap:10px;margin-top:20px;flex-wrap:wrap}
@media(max-width:980px){.layout{grid-template-columns:1fr}.side{position:static}.bar__in{padding:12px 16px}.wrap{padding:24px 16px 60px}.nav a:not(.on){display:none}}
@media(max-width:560px){.grid2{grid-template-columns:1fr}.brand span{display:none}}
</style>
</head>
<body>

<header class="bar"><div class="bar__in">
  <a class="brand" href="projects.php">
    <img src="<?= e($logo) ?>" alt="" onerror="this.replaceWith(Object.assign(document.createElement('b'),{textContent:'MB'}))">
    <span><?= e($site['name']) ?> <em>ADMIN</em></span>
  </a>
  <nav class="nav">
    <a class="on" href="projects.php">Projects</a>
    <a href="../index.php" target="_blank">View Site</a>
    <a href="logout.php">Logout</a>
  </nav>
</div></header>

<div class="wrap">

<?php if ($flash): ?><div class="toast <?= e($flash[0]) ?>" id="toast"><?= $flash[0] === 'ok' ? '&#10003;' : '&#9888;' ?> <?= e($flash[1]) ?></div><?php endif; ?>
<?php if ($error): ?><div class="toast err">&#9888; <?= e($error) ?></div><?php endif; ?>

<?php if ($mode === 'list'): ?>

  <div class="head">
    <div>
      <p class="eyebrow">Dashboard</p>
      <h1>Manage Projects</h1>
      <span class="rule"></span>
    </div>
    <a class="btn" href="projects.php?new=1">+ Add New Project</a>
  </div>

  <div class="stats">
    <div class="stat dark"><small>Total Projects</small><b><?= count($all) ?></b></div>
    <?php foreach ($statuses as $k => $s): ?>
      <a class="stat" href="<?= e($qs($k, '')) ?>"><small><?= e($s['tab']) ?></small><b><?= (int)$stCount[$k] ?></b></a>
    <?php endforeach; ?>
  </div>

  <div class="panel">
    <div class="tools">
      <div class="chips"><span>Status</span>
        <a href="<?= e($qs('', $fc)) ?>" class="<?= $fs === '' ? 'on' : '' ?>">All</a>
        <?php foreach ($statuses as $k => $s): ?>
          <a href="<?= e($qs($k, $fc)) ?>" class="<?= $fs === $k ? 'on' : '' ?>"><?= e($s['tab']) ?> <small><?= (int)$stCount[$k] ?></small></a>
        <?php endforeach; ?>
      </div>
      <div class="chips"><span>Category</span>
        <a href="<?= e($qs($fs, '')) ?>" class="<?= $fc === '' ? 'on' : '' ?>">All</a>
        <?php foreach ($cats as $k => $c): ?>
          <a href="<?= e($qs($fs, $k)) ?>" class="<?= $fc === $k ? 'on' : '' ?>"><?= e($c['label']) ?></a>
        <?php endforeach; ?>
      </div>
      <div class="search">
        <svg viewBox="0 0 24 24"><circle cx="11" cy="11" r="7"/><path d="M20 20l-4-4"/></svg>
        <input type="text" id="q" placeholder="Title ya location se dhundho..." autocomplete="off">
      </div>
    </div>

    <div class="scroll">
    <table>
      <thead><tr><th>Cover</th><th>Project</th><th>Category</th><th>Status</th><th>Year</th><th>Photos</th><th>Added</th><th>Action</th></tr></thead>
      <tbody id="rows">
      <?php if (!$rows): ?>
        <tr><td colspan="8"><div class="empty"><b>Koi project nahi mila</b>"+ Add New Project" dabao ya filter hatao.</div></td></tr>
      <?php else: foreach ($rows as $p):
          $thumb = trim((string)$p['thumb']);
          $added = !empty($p['created_at']) && strtotime($p['created_at']) ? date('d M Y', strtotime($p['created_at'])) : '-';
          $sp = $p['sk'] !== '' ? (isset(PJ_STATUS_DEFAULTS[$p['sk']]) ? 'p-' . $p['sk'] : 'p-other') : 'p-bad'; ?>
        <tr data-s="<?= e(strtolower($p['title'] . ' ' . $p['location'])) ?>">
          <td><?php if ($thumb !== ''): ?><img class="cover" src="../<?= e($thumb) ?>" alt="" onerror="this.style.visibility='hidden'"><?php else: ?><span class="cover"></span><?php endif; ?></td>
          <td><div class="ttl"><?= e($p['title']) ?></div><div class="sub"><?= e($p['location']) ?><?= trim((string)$p['location']) !== '' ? ' &middot; ' : '' ?><?= e($p['slug']) ?></div></td>
          <td><?php if ($p['ck'] !== ''): ?><span class="pill p-cat"><?= e($cats[$p['ck']]['label']) ?></span><?php else: ?><span class="pill p-bad" title="Edit karke category chuniye">Fix</span><?php endif; ?></td>
          <td><?php if ($p['sk'] !== ''): ?><span class="pill <?= $sp ?>"><?= e($statuses[$p['sk']]['tab']) ?></span><?php else: ?><span class="pill p-bad" title="Edit karke status chuniye">Fix</span><?php endif; ?></td>
          <td><?= e($p['year']) ?></td>
          <td><?= (int)$p['img_count'] + ($thumb !== '' ? 1 : 0) ?></td>
          <td class="sub"><?= e($added) ?></td>
          <td>
            <div class="act">
              <a class="btn sm dark" href="../project.php?id=<?= e(rawurlencode($p['slug'])) ?>" target="_blank">View</a>
              <a class="btn sm" href="projects.php?edit=<?= (int)$p['id'] ?>">Edit</a>
              <form method="post" onsubmit="return confirm('Pakka delete karna hai? Photos bhi hat jayengi.')">
                <input type="hidden" name="csrf" value="<?= e($csrf) ?>">
                <input type="hidden" name="action" value="delete">
                <input type="hidden" name="id" value="<?= (int)$p['id'] ?>">
                <button class="btn sm del">Delete</button>
              </form>
            </div>
          </td>
        </tr>
      <?php endforeach; endif; ?>
      </tbody>
    </table>
    </div>
  </div>

  <script>
  (function () {
    var q = document.getElementById('q'), rows = [].slice.call(document.querySelectorAll('#rows tr[data-s]'));
    q.addEventListener('input', function () {
      var v = this.value.toLowerCase().trim();
      rows.forEach(function (r) { r.hidden = v !== '' && r.getAttribute('data-s').indexOf(v) === -1; });
    });
  })();
  </script>

<?php else: ?>

  <div class="head">
    <div>
      <p class="eyebrow"><?= $form['id'] ? 'Editing' : 'New' ?></p>
      <h1><?= $form['id'] ? 'Edit Project' : 'Add New Project' ?></h1>
      <span class="rule"></span>
    </div>
    <a class="btn line" href="projects.php">&larr; Back to list</a>
  </div>

  <form method="post" enctype="multipart/form-data" id="pf">
    <input type="hidden" name="csrf" value="<?= e($csrf) ?>">
    <input type="hidden" name="action" value="save">
    <input type="hidden" name="id" value="<?= (int)$form['id'] ?>">

    <div class="layout">
      <div>
        <div class="card">
          <h3>Project Details</h3>
          <p class="note">Ye sab site par project page par dikhega.</p>

          <label class="l">Project Title *</label>
          <input type="text" name="title" value="<?= e($form['title']) ?>" maxlength="250" placeholder="e.g. Bhagwan Apt. at Mahalgi Nagar Sq. Nagpur" required>

          <div class="grid2">
            <div><label class="l">Location</label><input type="text" name="location" value="<?= e($form['location']) ?>" maxlength="250" placeholder="e.g. Hudkeshwar Road, Nagpur"></div>
            <div><label class="l">Year</label><input type="text" name="year" value="<?= e($form['year']) ?>" maxlength="20" placeholder="e.g. 2024"></div>
          </div>
          <div class="grid2">
            <div><label class="l">Area / Scale</label><input type="text" name="area" value="<?= e($form['area']) ?>" maxlength="100" placeholder="e.g. 4500 sq.ft."></div>
            <div><label class="l">Client</label><input type="text" name="client" value="<?= e($form['client']) ?>" maxlength="100"></div>
          </div>

          <label class="l">Description</label>
          <textarea name="description" placeholder="Project ke baare me chhoti details..."><?= e($form['description']) ?></textarea>
        </div>

        <?php if ($editImages): ?>
        <div class="card">
          <h3>Existing Photos</h3>
          <p class="note">Photo par &times; dabao to wo hat jayegi.</p>
          <div class="thumbs">
            <?php foreach ($editImages as $im): ?>
              <div class="th">
                <img src="../<?= e($im['file']) ?>" alt="" onerror="this.style.visibility='hidden'">
                <button type="submit" form="del<?= (int)$im['id'] ?>" title="Delete photo" onclick="return confirm('Ye photo hataye?')">&times;</button>
              </div>
            <?php endforeach; ?>
          </div>
        </div>
        <?php endif; ?>
      </div>

      <aside class="side">
        <div class="card">
          <h3>Publish</h3>
          <p class="note">Status aur category chuno. Naya chahiye to "Add new" chuno.</p>

          <label class="l">Status *</label>
          <select name="status" id="statusSel" data-box="statusNew" required>
            <?php if ($form['status'] === '') echo '<option value="" disabled selected>Select status...</option>'; ?>
            <?php foreach ($statuses as $k => $s): ?><option value="<?= e($k) ?>" <?= $form['status'] === $k ? 'selected' : '' ?>><?= e($s['tab']) ?></option><?php endforeach; ?>
            <option value="__new__" <?= $form['status'] === '__new__' ? 'selected' : '' ?>>&#65291; Add new status...</option>
          </select>
          <div class="newbox" id="statusNew" <?= $form['status'] === '__new__' ? '' : 'hidden' ?>>
            <small>Naye status ka naam (e.g. On Hold)</small>
            <input type="text" name="status_new" value="<?= e($form['status_new']) ?>" maxlength="100">
          </div>

          <label class="l">Category *</label>
          <select name="category" id="catSel" data-box="catNew" required>
            <?php if ($form['category'] === '') echo '<option value="" disabled selected>Select category...</option>'; ?>
            <?php foreach ($cats as $k => $c): ?><option value="<?= e($k) ?>" <?= $form['category'] === $k ? 'selected' : '' ?>><?= e($c['label']) ?></option><?php endforeach; ?>
            <option value="__new__" <?= $form['category'] === '__new__' ? 'selected' : '' ?>>&#65291; Add new category...</option>
          </select>
          <div class="newbox" id="catNew" <?= $form['category'] === '__new__' ? '' : 'hidden' ?>>
            <small>Nayi category ka naam (e.g. Industrial)</small>
            <input type="text" name="category_new" value="<?= e($form['category_new']) ?>" maxlength="100">
          </div>

          <div class="acts">
            <button class="btn" type="submit">Save Project</button>
            <a class="btn line" href="projects.php">Cancel</a>
          </div>
        </div>

        <div class="card">
          <h3>Cover Image <?= $form['id'] ? '' : '*' ?></h3>
          <p class="note">List aur category page par yehi photo dikhti hai.</p>
          <label class="drop<?= $editCover !== '' ? ' has' : '' ?>" id="coverDrop">
            <input type="file" name="thumb" id="coverIn" accept="<?= $exts ?>" <?= $form['id'] ? '' : 'required' ?>>
            <div class="drop__ph">
              <svg viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="16" rx="2"/><circle cx="9" cy="10" r="2"/><path d="M21 16l-5-5-8 8"/></svg>
              <b>Click karo ya photo yahan drop karo</b>JPG / PNG / WEBP, 8MB tak
            </div>
            <img class="pv" id="coverPv" alt="" <?= $editCover !== '' ? 'src="../' . e($editCover) . '"' : 'hidden' ?>>
          </label>
        </div>

        <div class="card">
          <h3>More Photos</h3>
          <p class="note">Ek saath kai photos chun sakte ho.</p>
          <label class="drop multi" id="morDrop">
            <input type="file" name="photos[]" id="morIn" accept="<?= $exts ?>" multiple>
            <div class="drop__ph">
              <svg viewBox="0 0 24 24"><path d="M12 5v14M5 12h14"/></svg>
              <b>Photos chuno ya drop karo</b>kai photos ek saath
            </div>
          </label>
          <div class="thumbs" id="morPv"></div>
        </div>
      </aside>
    </div>
  </form>

  <?php foreach ($editImages as $im): ?>
    <form method="post" id="del<?= (int)$im['id'] ?>">
      <input type="hidden" name="csrf" value="<?= e($csrf) ?>">
      <input type="hidden" name="action" value="delete_image">
      <input type="hidden" name="project_id" value="<?= (int)$form['id'] ?>">
      <input type="hidden" name="image_id" value="<?= (int)$im['id'] ?>">
    </form>
  <?php endforeach; ?>

  <script>
  (function () {
    // "Add new" dropdown option -> naya naam likhne ka box
    ['statusSel', 'catSel'].forEach(function (id) {
      var sel = document.getElementById(id), box = document.getElementById(sel.getAttribute('data-box'));
      var inp = box.querySelector('input');
      function sync() {
        var on = sel.value === '__new__';
        box.hidden = !on; inp.required = on;
        if (on) inp.focus();
      }
      sel.addEventListener('change', sync);
      inp.required = sel.value === '__new__';
    });

    // drag & drop + preview
    function zone(drop, input, onFiles) {
      ['dragenter', 'dragover'].forEach(function (ev) { drop.addEventListener(ev, function (e) { e.preventDefault(); drop.classList.add('over'); }); });
      ['dragleave', 'drop'].forEach(function (ev) { drop.addEventListener(ev, function (e) { e.preventDefault(); drop.classList.remove('over'); }); });
      drop.addEventListener('drop', function (e) {
        if (e.dataTransfer && e.dataTransfer.files.length) { input.files = e.dataTransfer.files; onFiles(input.files); }
      });
      input.addEventListener('change', function () { onFiles(input.files); });
    }
    var cd = document.getElementById('coverDrop'), ci = document.getElementById('coverIn'), cp = document.getElementById('coverPv');
    zone(cd, ci, function (fl) {
      if (!fl.length) return;
      cp.src = URL.createObjectURL(fl[0]); cp.hidden = false; cd.classList.add('has');
    });
    var md = document.getElementById('morDrop'), mi = document.getElementById('morIn'), mp = document.getElementById('morPv');
    zone(md, mi, function (fl) {
      mp.innerHTML = '';
      [].slice.call(fl).forEach(function (f) {
        var d = document.createElement('div'); d.className = 'th new';
        var i = document.createElement('img'); i.src = URL.createObjectURL(f);
        d.appendChild(i); mp.appendChild(d);
      });
    });
  })();
  </script>

<?php endif; ?>

</div>
<script>
(function () { var t = document.getElementById('toast'); if (t) setTimeout(function () { t.style.transition = 'opacity .6s'; t.style.opacity = '0'; setTimeout(function () { t.remove(); }, 700); }, 4500); })();
</script>
</body>
</html>