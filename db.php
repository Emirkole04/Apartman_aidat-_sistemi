<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start(); // Oturum başlatma
}

require 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Kullanıcı bilgilerini kontrol etme
    $stmt = $pdo->prepare('SELECT * FROM users WHERE username = :username');
    $stmt->execute([':username' => $username]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['role'] = $user['role'];

        if ($user['role'] == 'admin') {
            header("Location: admin_panel.php");
        } else {
            header("Location: user_panel.php");
        }
        exit();
    } else {
        echo "Geçersiz kullanıcı adı veya şifre.";
    }
}
?>