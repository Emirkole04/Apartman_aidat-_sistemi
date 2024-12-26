<?php
session_start();
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $query = $pdo->prepare("SELECT * FROM users WHERE username = ?");
    $query->execute([$username]);
    $user = $query->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        header('Location: user_panel.php');
        exit();
    } else {
        $error = "Geçersiz kullanıcı adı veya şifre.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Kullanıcı Girişi</title>
</head>
<body>
    <h1>Kullanıcı Girişi</h1>
    <?php if (isset($error)): ?>
    <p><?php echo $error; ?></p>
    <?php endif; ?>
    <form method="POST" action="login.php">
        <label for="username">Kullanıcı Adı:</label>
        <input type="text" id="username" name="username" required>
        <br>
        <label for="password">Şifre:</label>
        <input type="password" id="password" name="password" required>
        <br>
        <button type="submit">Giriş Yap</button>
    </form>
</body>
</html>