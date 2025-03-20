<?php
require 'auth.php';
requireAdmin();

require 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $device_id = $_POST['device_id'];
    $user_id = $_POST['user_id'];

    try {
        // Update the device status and assign it to the user
        $stmt = $conn->prepare("UPDATE devices SET status = 'assigned', assigned_to = ? WHERE id = ?");
        $stmt->execute([$user_id, $device_id]);

        // Insert into allocation table
        $stmt = $conn->prepare("INSERT INTO allocations (user_id, device_id) VALUES (?, ?)");
        $stmt->execute([$user_id, $device_id]);

        echo "Device assigned successfully!";
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}

// Fetch available devices and users
$devices = $conn->query("SELECT id, device_name FROM devices WHERE status = 'available'")->fetchAll();
$users = $conn->query("SELECT id, username FROM users")->fetchAll();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Assign Device</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h2>Assign Device</h2>
    <form method="POST">
        <select name="device_id" required>
            <option value="">Select Device</option>
            <?php foreach ($devices as $device): ?>
                <option value="<?= $device['id'] ?>"><?= $device['device_name'] ?></option>
            <?php endforeach; ?>
        </select>
        <select name="user_id" required>
            <option value="">Select User</option>
            <?php foreach ($users as $user): ?>
                <option value="<?= $user['id'] ?>"><?= $user['username'] ?></option>
            <?php endforeach; ?>
        </select>
        <button type="submit">Assign</button>
    </form>
</body>
</html>