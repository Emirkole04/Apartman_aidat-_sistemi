<?php
// Veritabanı bağlantısı için gerekli değişkenler
$host = 'localhost';
$dbname = 'apartman_aidat_sistemi2';
$username = 'root'; // Veritabanı kullanıcı adınızı buraya yazın
$password = ''; // Veritabanı şifrenizi buraya yazın

try {
    // PDO ile veritabanına bağlanma
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    // PDO hata modunu istisna (exception) olarak ayarlama
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    // Bağlantı hatası durumunda hata mesajını gösterme
    die("Bağlantı hatası: " . $e->getMessage());
}
?>