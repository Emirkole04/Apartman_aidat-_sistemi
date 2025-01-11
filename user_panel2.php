<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start(); // Oturum başlatma
}

require 'db2.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'Kiracı') {
    header("Location: index2.php");
    exit();
}

// Kullanıcının aidatlarını çekme
$user_id = $_SESSION['user_id'];
$aidatlar = $pdo->prepare('SELECT * FROM aidatlar2 WHERE user_id = :user_id');
$aidatlar->execute([':user_id' => $user_id]);
$aidatlar = $aidatlar->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kullanıcı Paneli 2</title>
    <link rel="stylesheet" href="styles4.css">
    <style>
        .status-paid {
            color: green;
            font-size: 20px;
        }

        .status-unpaid {
            color: red;
            font-size: 20px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Kullanıcı Paneli</h1>
    </div>
    <div class="container">
        <div class="main">
            <h2>Aidatlar</h2>
            <div class="table-container">
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
                        <td><?php echo htmlspecialchars(date("d-m-Y", strtotime($aidat['due_date']))); ?></td>
                        <td>
                            <?php 
                            if ($aidat['status'] === 'ödendi') {
                                echo '<span class="status-paid">&#x2714;</span>'; // Yeşil tik
                            } else {
                                echo '<span class="status-unpaid">&#x2716;</span>'; // Kırmızı çarpı
                            }
                            ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </table>
            </div>

            <a href="logout2.php" class="logout-btn">Çıkış Yap</a>
        </div>
    </div>
    <div class="footer">
        <p>Telif Hakkı &copy; 2024 Apartman Aidat Sistemi</p>
    </div>
</body>
</html>