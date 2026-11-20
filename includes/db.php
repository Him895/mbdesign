<?php
// Database Credentials (Apne XAMPP/Server ke hisaab se change kar)
$host = 'localhost';
$db   = 'mbdesign_db';
$user = 'root';
$pass = ''; 

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Database Connection Failed: " . $e->getMessage());
}

// Helper function: HTML ko safe banane ke liye
// (config.php me bhi yahi function hai, isliye guard lagaya hai taaki "Cannot redeclare e()" na aaye)
if (!function_exists('e')) {
    function e($str) {
        return htmlspecialchars($str ?? '', ENT_QUOTES, 'UTF-8');
    }
}
?>