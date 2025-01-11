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
$edit_aidat = null;

// Kullanıcı ekleme formu gönderildiğinde çalışacak kod
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_user'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $daire_no = $_POST['daire_no'];
    $role = $_POST['role'];

    // Şifreyi doğrudan veritabanına ekle
    $stmt = $pdo->prepare("INSERT INTO users2 (username, password, daire_no, role) VALUES (:username, :password, :daire_no, :role)");
    $stmt->bindParam(':username', $username);
    $stmt->bindParam(':password', $password);
    $stmt->bindParam(':daire_no', $daire_no);
    $stmt->bindParam(':role', $role);

    if ($stmt->execute()) {
        $success_message = "Kullanıcı başarıyla eklendi.";
        header("Location: admin_panel2.php?success=user_added"); // Form gönderiminden sonra sayfayı yeniden yönlendir
        exit();
    } else {
        $error_message = "Kullanıcı eklenirken bir hata oluştu.";
    }
}

// Kullanıcı silme işlemi
if (isset($_GET['delete_user_id'])) {
    $delete_user_id = $_GET['delete_user_id'];

    // İlgili aidat kayıtlarını sil
    $stmt = $pdo->prepare("DELETE FROM aidatlar2 WHERE user_id = :user_id");
    $stmt->bindParam(':user_id', $delete_user_id);
    $stmt->execute();

    // Kullanıcıyı sil
    $stmt = $pdo->prepare("DELETE FROM users2 WHERE id = :id");
    $stmt->bindParam(':id', $delete_user_id);

    if ($stmt->execute()) {
        $success_message = "Kullanıcı başarıyla silindi.";
        header("Location: admin_panel2.php?success=user_deleted"); // Silme işleminden sonra sayfayı yeniden yönlendir
        exit();
    } else {
        $error_message = "Kullanıcı silinirken bir hata oluştu.";
    }
}

// Aidat ekleme formu gönderildiğinde çalışacak kod
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_aidat'])) {
    $user_id = $_POST['user_id'];
    $amount = $_POST['amount'];
    $due_date = $_POST['due_date'];
    $status = $_POST['status'];

    // 12 aylık aidat ekleme işlemi
    try {
        $pdo->beginTransaction();
        for ($i = 0; $i < 12; $i++) {
            $due_date_month = date("Y-m-d", strtotime("+$i month", strtotime($due_date)));
            $stmt = $pdo->prepare("INSERT INTO aidatlar2 (user_id, amount, due_date, status) VALUES (:user_id, :amount, :due_date, :status)");
            $stmt->bindParam(':user_id', $user_id);
            $stmt->bindParam(':amount', $amount);
            $stmt->bindParam(':due_date', $due_date_month);
            $stmt->bindParam(':status', $status);
            $stmt->execute();
        }
        $pdo->commit();
        $aidat_success_message = "12 aylık aidat başarıyla eklendi.";
        header("Location: admin_panel2.php?success=aidat_added"); // Form gönderiminden sonra sayfayı yeniden yönlendir
        exit();
    } catch (Exception $e) {
        $pdo->rollBack();
        $aidat_error_message = "Aidat eklenirken bir hata oluştu: " . $e->getMessage();
    }
}

// Aidat düzenleme formu gönderildiğinde çalışacak kod
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['edit_aidat'])) {
    $aidat_id = $_POST['aidat_id'];
    $user_id = $_POST['user_id'];
    $amount = $_POST['amount'];
    $due_date = $_POST['due_date'];
    $status = $_POST['status'];

    $stmt = $pdo->prepare("UPDATE aidatlar2 SET user_id = :user_id, amount = :amount, due_date = :due_date, status = :status WHERE id = :id");
    $stmt->bindParam(':user_id', $user_id);
    $stmt->bindParam(':amount', $amount);
    $stmt->bindParam(':due_date', $due_date);
    $stmt->bindParam(':status', $status);
    $stmt->bindParam(':id', $aidat_id);

    if ($stmt->execute()) {
        $aidat_success_message = "Aidat başarıyla güncellendi.";
        header("Location: admin_panel2.php?success=aidat_updated"); // Form gönderiminden sonra sayfayı yeniden yönlendir
        exit();
    } else {
        $aidat_error_message = "Aidat güncellenirken bir hata oluştu.";
    }
}

// Aidat düzenle butonuna tıklandığında mevcut bilgileri formda gösterme
if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['edit_aidat_id'])) {
    $edit_aidat_id = $_GET['edit_aidat_id'];
    $stmt = $pdo->prepare("SELECT * FROM aidatlar2 WHERE id = :id");
    $stmt->bindParam(':id', $edit_aidat_id);
    $stmt->execute();
    $edit_aidat = $stmt->fetch(PDO::FETCH_ASSOC);
}

// Aidat silme işlemi
if (isset($_GET['delete_aidat_id'])) {
    $delete_aidat_id = $_GET['delete_aidat_id'];

    // Aidat kaydını sil
    $stmt = $pdo->prepare("DELETE FROM aidatlar2 WHERE id = :id");
    $stmt->bindParam(':id', $delete_aidat_id);

    if ($stmt->execute()) {
        $aidat_success_message = "Aidat başarıyla silindi.";
        header("Location: admin_panel2.php?success=aidat_deleted"); // Silme işleminden sonra sayfayı yeniden yönlendir
        exit();
    } else {
        $aidat_error_message = "Aidat silinirken bir hata oluştu.";
    }
}

// Aidat listesi arama işlemi
$search_username = '';
if (isset($_GET['search_username'])) {
    $search_username = $_GET['search_username'];
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
            if (!empty($error_message)) {
                echo '<div class="message error">' . $error_message . '</div>';
            } elseif (!empty($success_message)) {
                echo '<div class="message success">' . $success_message . '</div>';
            }
            $query = "SELECT * FROM users2";
            $stmt = $pdo->query($query);

            if ($stmt->rowCount() > 0) {
                echo '<table>';
                echo '<thead><tr><th>Kullanıcı Adı</th><th>Daire No</th><th>Rol</th><th>İşlemler</th></tr></thead>';
                echo '<tbody>';
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    echo "<tr><td>{$row['username']}</td><td>{$row['daire_no']}</td><td>{$row['role']}</td><td><a href='admin_panel2.php?edit_user_id={$row['id']}' class='btn'>Düzenle</a> <a href='admin_panel2.php?delete_user_id={$row['id']}' class='btn btn-danger' onclick='return confirm(\"Kullanıcıyı silmek istediğinize emin misiniz?\")'>Sil</a></td></tr>";
                }
                echo '</tbody></table>';
            } else {
                echo '<p>Kayıt bulunamadı.</p>';
            }
            ?>
        </div>

        <div class="main">
            <h2>Aidat Listesi</h2>
            <form method="get" action="admin_panel2.php">
                <input type="text" name="search_username" placeholder="Kullanıcı adı ara" value="<?php echo htmlspecialchars($search_username); ?>">
                <button type="submit" class="btn">Ara</button>
            </form>
            <?php
            $query = "SELECT aidatlar2.id, users2.username, aidatlar2.amount, aidatlar2.due_date, aidatlar2.status 
                      FROM aidatlar2
                      JOIN users2 ON aidatlar2.user_id = users2.id";
            if ($search_username != '') {
                $query .= " WHERE users2.username LIKE :search_username";
            }
            $stmt = $pdo->prepare($query);
            if ($search_username != '') {
                $stmt->bindValue(':search_username', '%' . $search_username . '%');
            }
            $stmt->execute();

            if ($stmt->rowCount() > 0) {
                echo '<table>';
                echo '<thead><tr><th>Kullanıcı Adı</th><th>Aidat Miktarı (TL)</th><th>Son Ödeme Tarihi</th><th>Durum</th><th>İşlemler</th></tr></thead>';
                echo '<tbody>';
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    $due_date = date("d-m-Y", strtotime($row['due_date'])); // Tarih formatını değiştir
                    $status_icon = ($row['status'] === 'ödendi') ? '<span class="status-paid">&#x2714;</span>' : '<span class="status-unpaid">&#x2716;</span>';
                    echo "<tr><td>{$row['username']}</td><td>{$row['amount']}</td><td>{$due_date}</td><td>{$status_icon}</td><td><a href='admin_panel2.php?edit_aidat_id={$row['id']}' class='btn'>Düzenle</a> <a href='admin_panel2.php?delete_aidat_id={$row['id']}' class='btn btn-danger' onclick='return confirm(\"Aidatı silmek istediğinize emin misiniz?\")'>Sil</a></td></tr>";
                }
                echo '</tbody></table>';
            } else {
                echo '<p>Aidat bulunamadı.</p>';
            }
            ?>
        </div>

        <div class="form-container">
            <?php if ($edit_aidat): ?>
            <div class="form-box">
                <h2>Aidat Düzenle</h2>
                <?php
                if (!empty($aidat_error_message)) {
                    echo '<div class="message error">' . $aidat_error_message . '</div>';
                } elseif (!empty($aidat_success_message)) {
                    echo '<div class="message success">' . $aidat_success_message . '</div>';
                }
                ?>
                <form action="admin_panel2.php" method="post">
                    <input type="hidden" name="edit_aidat" value="1">
                    <input type="hidden" name="aidat_id" value="<?php echo $edit_aidat['id']; ?>">
                    <div class="form-group">
                        <label for="user_id">Kullanıcı Adı:</label>
                        <select id="user_id" name="user_id" required>
                            <?php
                            $users = $pdo->query("SELECT id, username FROM users2")->fetchAll(PDO::FETCH_ASSOC);
                            foreach ($users as $user) {
                                echo "<option value=\"{$user['id']}\" " . ($user['id'] == $edit_aidat['user_id'] ? 'selected' : '') . ">{$user['username']}</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="amount">Aidat Miktarı:</label>
                        <input type="number" step="0.01" id="amount" name="amount" value="<?php echo htmlspecialchars($edit_aidat['amount']); ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="due_date">Son Ödeme Tarihi:</label>
                        <input type="date" id="due_date" name="due_date" value="<?php echo htmlspecialchars($edit_aidat['due_date']); ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="status">Durum:</label>
                        <select id="status" name="status" required>
                            <option value="ödenmedi" <?php echo $edit_aidat['status'] == 'ödenmedi' ? 'selected' : ''; ?>>Ödenmedi</option>
                            <option value="ödendi" <?php echo $edit_aidat['status'] == 'ödendi' ? 'selected' : ''; ?>>Ödendi</option>
                        </select>
                    </div>
                    <button type="submit" class="btn">Aidat Güncelle</button>
                </form>
            </div>
            <?php else: ?>
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
            <?php endif; ?>

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
                            <option value="ödenmedi">Ödenmedi</option>
                            <option value="ödendi">Ödendi</option>
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