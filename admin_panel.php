<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start(); // Oturum başlatma
}

require 'db.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
    header("Location: index.php");
    exit();
}

// Kullanıcıları ve aidatları çekme
$users = $pdo->query('SELECT * FROM users')->fetchAll(PDO::FETCH_ASSOC);
$aidatlar = $pdo->query('SELECT a.*, u.username FROM aidatlar a JOIN users u ON a.user_id = u.id')->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Yönetici Paneli</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <h1>Yönetici Paneli</h1>
    <h2>Kullanıcılar</h2>
    <table>
        <tr>
            <th>ID</th>
            <th>Kullanıcı Adı</th>
            <th>Ad</th>
        </tr>
        <?php foreach ($users as $user): ?>
        <tr>
            <td><?php echo htmlspecialchars($user['id']); ?></td>
            <td><?php echo htmlspecialchars($user['username']); ?></td>
            <td><?php echo htmlspecialchars($user['name']); ?></td>
        </tr>
        <?php endforeach; ?>
    </table>

    <h2>Aidatlar</h2>
    <table>
        <tr>
            <th>ID</th>
            <th>Kullanıcı Adı</th>
            <th>Tutar</th>
            <th>Son Ödeme Tarihi</th>
            <th>Durum</th>
        </tr>
        <?php foreach ($aidatlar as $aidat): ?>
        <tr>
            <td><?php echo htmlspecialchars($aidat['id']); ?></td>
            <td><?php echo htmlspecialchars($aidat['username']); ?></td>
            <td><?php echo htmlspecialchars($aidat['amount']); ?></td>
            <td><?php echo htmlspecialchars($aidat['due_date']); ?></td>
            <td><?php echo htmlspecialchars($aidat['status']); ?></td>
        </tr>
        <?php endforeach; ?>
    </table>

    <a href="logout.php">Çıkış Yap</a>
</body>
</html>