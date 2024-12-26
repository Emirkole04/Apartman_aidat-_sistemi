<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start(); // Oturum başlatma
}

require 'db.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'user') {
    header("Location: index.php");
    exit();
}

// Kullanıcının aidatlarını çekme
$user_id = $_SESSION['user_id'];
$aidatlar = $pdo->prepare('SELECT * FROM aidatlar WHERE user_id = :user_id');
$aidatlar->execute([':user_id' => $user_id]);
$aidatlar = $aidatlar->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kullanıcı Paneli</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <h1>Kullanıcı Paneli</h1>
    <h2>Aidatlar</h2>
    <table>
        <tr>
            <th>ID</th>
            <th>Tutar</th>
            <th>Son Ödeme Tarihi</th>
            <th>Durum</th>
        </tr>
        <?php foreach ($aidatlar as $aidat): ?>
        <tr>
            <td><?php echo htmlspecialchars($aidat['id']); ?></td>
            <td><?php echo htmlspecialchars($aidat['amount']); ?></td>
            <td><?php echo htmlspecialchars($aidat['due_date']); ?></td>
            <td><?php echo htmlspecialchars($aidat['status']); ?></td>
        </tr>
        <?php endforeach; ?>
    </table>

    <a href="logout.php">Çıkış Yap</a>
</body>
</html>