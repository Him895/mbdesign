<?php
session_start();
require_once '../includes/db.php';

// Agar already logged in hai toh seedha dashboard par bhej do
if (isset($_SESSION['admin'])) {
    header('Location: projects.php');
    exit;
}

$err = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $u = trim($_POST['username'] ?? '');
    $p = $_POST['password'] ?? '';
    
    $stmt = $pdo->prepare("SELECT * FROM admins WHERE username = ?");
    $stmt->execute([$u]);
    $admin = $stmt->fetch();

    if ($admin && password_verify($p, $admin['password'])) {
        $_SESSION['admin'] = $admin['username'];
        header('Location: projects.php');
        exit;
    } else {
        $err = "Galat Username ya Password!";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Login - MB Design</title>
    <style>
        body { font-family: 'Montserrat', sans-serif; background: #16140f; color: #fff; display: grid; place-items: center; height: 100vh; margin: 0; }
        form { background: #241f14; padding: 40px; border-radius: 12px; width: 320px; border: 1px solid #b99b50; box-shadow: 0 20px 50px rgba(0,0,0,.5); }
        h2 { color: #e3cd96; text-align: center; margin-bottom: 25px; font-family: 'Cormorant Garamond', serif; font-size: 2rem; }
        input { width: 100%; padding: 14px; margin: 10px 0; border-radius: 6px; border: 1px solid #444; background: #16140f; color: #fff; box-sizing: border-box; font-size: 1rem; }
        input:focus { outline: none; border-color: #b99b50; }
        button { width: 100%; padding: 14px; background: #b99b50; color: #fff; border: 0; border-radius: 6px; font-weight: bold; cursor: pointer; margin-top: 15px; font-size: 1rem; transition: .3s; }
        button:hover { background: #e3cd96; color: #16140f; }
        .err { color: #ff6b6b; text-align: center; font-size: .9rem; margin-bottom: 10px; }
    </style>
</head>
<body>
    <form method="post">
        <h2>Admin Login</h2>
        <?php if ($err) echo "<p class='err'>$err</p>"; ?>
        <input name="username" placeholder="Username" required autofocus>
        <input name="password" type="password" placeholder="Password" required>
        <button type="submit">Login</button>
        <p style="text-align:center; font-size:.8rem; color:#666; margin-top:20px;">Default: admin / admin123</p>
    </form>
</body>
</html>