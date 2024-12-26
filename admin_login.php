<?php
session_start(); // Oturum başlatma

// Veritabanı bağlantısını dahil etme
require 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Form verilerini kontrol etme ve alma
    if (isset($_POST['username']) && isset($_POST['password'])) {
        $username = $_POST['username'];
        $password = $_POST['password'];

        try {
            // SQL sorgusu
            $stmt = $pdo->prepare('SELECT * FROM admins WHERE username = :username AND password = :password');
            $stmt->execute([
                ':username' => $username,
                ':password' => $password
            ]);

            // Sonuçları fetch etme
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($user) {
                // Oturum değişkenlerine kullanıcı bilgilerini kaydetme
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                
                // Giriş başarılı, admin paneline yönlendirme
                header("Location: admin_panel.php");
                exit(); // Yönlendirmeden sonra scriptin devam etmesini önlemek için exit kullanılır
            } else {
                // Giriş başarısız, hata mesajı gösterme
                echo "Giriş başarısız! Kullanıcı adı veya şifre yanlış.";
            }
        } catch (PDOException $e) {
            echo 'Bağlantı hatası: ' . $e->getMessage();
        }
    } else {
        echo "Kullanıcı adı ve şifre gereklidir.";
    }
} else {
    echo "Geçersiz istek yöntemi.";
}
?>