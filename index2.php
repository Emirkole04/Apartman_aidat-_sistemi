<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start(); // Oturum başlatma
}

require 'db2.php'; // Veritabanı bağlantısı

$error_message = ""; // Hata mesajı değişkeni

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Kullanıcı bilgilerini kontrol etme
    $stmt = $pdo->prepare('SELECT * FROM users2 WHERE username = :username');
    $stmt->execute([':username' => $username]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    // Kullanıcı bulunup bulunmadığını kontrol etme ve şifre doğrulaması yapma
    if ($user && $password === $user['password']) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['role'] = $user['role'];

        // Kullanıcının rolüne göre yönlendirme
        if ($user['role'] == 'Yönetici') {
            header("Location: admin_panel2.php");
        } else {
            header("Location: user_panel2.php");
        }
        exit();
    } else {
        $error_message = "Geçersiz kullanıcı adı veya şifre.";
    }
}
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Apartman Aidat Sistemi </title>
    <link rel="stylesheet" href="styles3.css">
</head>
<body>
    <h1>Apartman Aidat Sistemi </h1>
    <form action="index2.php" method="post">
        <label for="username">Kullanıcı Adı:</label>
        <input type="text" id="username" name="username" required>
        <br>
        <label for="password">Şifre:</label>
        <input type="password" id="password" name="password" required>
        <br>
        <button type="submit">Giriş Yap</button>
    </form>
    <?php
    if (!empty($error_message)) {
        echo '<p style="color:red;">' . $error_message . '</p>';
    }
    ?>
</body>
</html>