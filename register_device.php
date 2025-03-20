<?php
require 'auth.php';
requireAdmin(); // Only admins can register devices

require 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $device_name = $_POST['device_name'];
    $serial_number = $_POST['serial_number'];

    try {
        $stmt = $conn->prepare("INSERT INTO devices (device_name, serial_number) VALUES (?, ?)");
        $stmt->execute([$device_name, $serial_number]);
        echo "Device registered successfully!";
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Register Device</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h2>Register New Device</h2>
    <form method="POST">
        <input type="text" name="device_name" placeholder="Device Name" required><br>
        <input type="text" name="serial_number" placeholder="Serial Number" required><br>
        <button type="submit">Register</button>
    </form>
</body>
</html>