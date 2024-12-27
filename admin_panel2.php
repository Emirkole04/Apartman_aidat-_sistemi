<?php
session_start();
require 'db2.php'; // Veritabanı bağlantısı

// Kullanıcı giriş yapmış mı kontrol et
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'Yönetici') {
    header("Location: index2.php");
    exit();
}

// Hata ve başarı mesajları değişkenleri
$error_message = "";
$success_message = "";
$aidat_error_message = "";
$aidat_success_message = "";

// Kullanıcı ekleme formu gönderildiğinde çalışacak kod
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_user'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $daire_no = $_POST['daire_no'];
    $role = $_POST['role'];

    // Şifreyi hash'lemek için password_hash() fonksiyonu kullanılır
    $password_hashed = password_hash($password, PASSWORD_DEFAULT);

    $stmt = $pdo->prepare("INSERT INTO users2 (username, password, daire_no, role) VALUES (:username, :password, :daire_no, :role)");
    $stmt->bindParam(':username', $username);
    $stmt->bindParam(':password', $password_hashed);
    $stmt->bindParam(':daire_no', $daire_no);
    $stmt->bindParam(':role', $role);

    if ($stmt->execute()) {
        $success_message = "Kullanıcı başarıyla eklendi.";
    } else {
        $error_message = "Kullanıcı eklenirken bir hata oluştu.";
    }
}

// Aidat ekleme formu gönderildiğinde çalışacak kod
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_aidat'])) {
    $user_id = $_POST['user_id'];
    $amount = $_POST['amount'];
    $due_date = $_POST['due_date'];
    $status = $_POST['status'];

    $stmt = $pdo->prepare("INSERT INTO aidatlar2 (user_id, amount, due_date, status) VALUES (:user_id, :amount, :due_date, :status)");
    $stmt->bindParam(':user_id', $user_id);
    $stmt->bindParam(':amount', $amount);
    $stmt->bindParam(':due_date', $due_date);
    $stmt->bindParam(':status', $status);

    if ($stmt->execute()) {
        $aidat_success_message = "Aidat başarıyla eklendi.";
    } else {
        $aidat_error_message = "Aidat eklenirken bir hata oluştu.";
    }
}
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <link rel="stylesheet" href="styles2.css">
</head>
<body>
    <div class="header">
        <h3>Admin Panel</h3>
    </div>
    <div class="container">
        <div class="main">
            <h2>Kullanıcı Listesi</h2>
            <?php
            $query = "SELECT * FROM users2";
            $stmt = $pdo->query($query);

            if ($stmt->rowCount() > 0) {
                echo '<table>';
                echo '<thead><tr><th>ID</th><th>Kullanıcı Adı</th><th>Daire No</th><th>Rol</th></tr></thead>';
                echo '<tbody>';
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    echo "<tr><td>{$row['id']}</td><td>{$row['username']}</td><td>{$row['daire_no']}</td><td>{$row['role']}</td></tr>";
                }
                echo '</tbody></table>';
            } else {
                echo '<p>Kayıt bulunamadı.</p>';
            }
            ?>
        </div>

        <div class="main">
            <h2>Aidat Listesi</h2>
            <?php
            $query = "SELECT aidatlar2.id, users2.username, aidatlar2.amount, aidatlar2.due_date, aidatlar2.status 
                      FROM aidatlar2
                      JOIN users2 ON aidatlar2.user_id = users2.id";
            $stmt = $pdo->query($query);

            if ($stmt->rowCount() > 0) {
                echo '<table>';
                echo '<thead><tr><th>ID</th><th>Kullanıcı Adı</th><th>Aidat Miktarı</th><th>Son Ödeme Tarihi</th><th>Durum</th></tr></thead>';
                echo '<tbody>';
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    echo "<tr><td>{$row['id']}</td><td>{$row['username']}</td><td>{$row['amount']}</td><td>{$row['due_date']}</td><td>{$row['status']}</td></tr>";
                }
                echo '</tbody></table>';

            } else {
                echo '<p>Aidat bulunamadı.</p>';
            }
            ?>
        </div>

        <div class="form-container">
            <div class="form-box">
                <h2>Kullanıcı Ekle</h2>
                <?php
                if (!empty($error_message)) {
                    echo '<div class="message error">' . $error_message . '</div>';
                } elseif (!empty($success_message)) {
                    echo '<div class="message success">' . $success_message . '</div>';
                }
                ?>
                <form action="admin_panel2.php" method="post">
                    <input type="hidden" name="add_user" value="1">
                    <div class="form-group">
                        <label for="username">Kullanıcı Adı:</label>
                        <input type="text" id="username" name="username" required>
                    </div>
                    <div class="form-group">
                        <label for="password">Şifre:</label>
                        <input type="password" id="password" name="password" required>
                    </div>
                    <div class="form-group">
                        <label for="daire_no">Daire No:</label>
                        <input type="text" id="daire_no" name="daire_no" required>
                    </div>
                    <div class="form-group">
                        <label for="role">Rol:</label>
                        <select id="role" name="role">
                            <option value="Kiracı">Kiracı</option>
                            <option value="Yönetici">Yönetici</option>
                        </select>
                    </div>
                    <button type="submit" class="btn">Kullanıcı Ekle</button>
                </form>
            </div>

            <div class="form-box">
                <h2>Aidat Ekle</h2>
                <?php
                if (!empty($aidat_error_message)) {
                    echo '<div class="message error">' . $aidat_error_message . '</div>';
                } elseif (!empty($aidat_success_message)) {
                    echo '<div class="message success">' . $aidat_success_message . '</div>';
                }
                ?>
                <form action="admin_panel2.php" method="post">
                    <input type="hidden" name="add_aidat" value="1">
                    <div class="form-group">
                        <label for="user_id">Kullanıcı Adı:</label>
                        <select id="user_id" name="user_id" required>
                            <?php
                            $users = $pdo->query("SELECT id, username FROM users2")->fetchAll(PDO::FETCH_ASSOC);
                            foreach ($users as $user) {
                                echo "<option value=\"{$user['id']}\">{$user['username']}</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="amount">Aidat Miktarı:</label>
                        <input type="number" step="0.01" id="amount" name="amount" required>
                    </div>
                    <div class="form-group">
                        <label for="due_date">Son Ödeme Tarihi:</label>
                        <input type="date" id="due_date" name="due_date" required>
                    </div>
                    <div class="form-group">
                        <label for="status">Durum:</label>
                        <select id="status" name="status" required>
                            <option value="Ödenmedi">Ödenmedi</option>
                            <option value="Ödendi">Ödendi</option>
                        </select>
                    </div>
                    <button type="submit" class="btn">Aidat Ekle</button>
                </form>
            </div>
        </div>

        <!-- Çıkış Yap Butonu -->
        <div class="logout-container">
            <form action="logout2.php" method="post">
                <button type="submit" class="btn-small-logout">Çıkış Yap</button>
            </form>
        </div>
    </div>
    <div class="footer">
        <p>Telif Hakkı &copy; 2024 Apartman Aidat Sistemi</p>
    </div>
</body>
</html>