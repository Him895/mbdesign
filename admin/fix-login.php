<?php
require_once '../includes/db.php';

// 'admin123' ka naya aur sahi password hash banayega
$new_pass = password_hash('admin123', PASSWORD_DEFAULT);

// Database mein password update karega
$stmt = $pdo->prepare("UPDATE admins SET password = ? WHERE username = 'admin'");
$stmt->execute([$new_pass]);

if ($stmt->rowCount() > 0) {
    echo "<h2 style='color:green; font-family:sans-serif; text-align:center; margin-top:50px;'>✅ Password Successfully Reset!</h2>";
    echo "<p style='text-align:center; font-family:sans-serif;'><a href='login.php' style='color:blue; font-size:1.2rem;'>Click here to Login</a></p>";
    echo "<p style='text-align:center; color:red; font-family:sans-serif; font-size:0.9rem;'>⚠️ Important: Ab is file (fix-login.php) ko delete kar dena security ke liye.</p>";
} else {
    echo "<h2 style='color:red; font-family:sans-serif; text-align:center; margin-top:50px;'>❌ Error: Admin user nahi mila. SQL query dobara run karo.</h2>";
}
?>