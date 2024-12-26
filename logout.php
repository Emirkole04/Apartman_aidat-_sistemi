<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start(); // Oturum başlatma
}

session_unset();
session_destroy();
header("Location: index.php");
exit();
?>