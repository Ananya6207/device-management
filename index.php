<?php
session_start();

// Redirect user based on authentication status and role
if (isset($_SESSION['user_id'])) {
    if ($_SESSION['role'] === 'admin') {
        header('Location: admin_dashboard.php');
        exit();
    } else {
        header('Location: user_dashboard.php');
        exit();
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Device Management System</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>

<div class="container">
    <h2>Welcome to Device Management System</h2>
    <p>Please login to continue:</p>
    <div class="action-buttons">
        <a href="login.php"><button>Login</button></a>
        <a href="register.php"><button>Register</button></a>
    </div>
</div>

</body>
</html>