<!-- to check user's role-->
<?php
session_start();

function isAdmin() {
    return isset($_SESSION['role']) && $_SESSION['role'] === 'admin';
}

function isUser() {
    return isset($_SESSION['role']) && $_SESSION['role'] === 'user';
}

function requireAdmin() {
    if (!isAdmin()) {
        header("Location: login.php");
        exit();
    }
}

function requireUser() {
    if (!isUser()) {
        header("Location: login.php");
        exit();
    }
}
?>