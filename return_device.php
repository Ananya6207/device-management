<?php
require 'auth.php';
requireUser();

require 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $device_id = $_POST['device_id'];
    $user_id = $_SESSION['user_id'];

    try {
        // Remove the device from the allocations table
        $stmt = $conn->prepare("DELETE FROM allocations WHERE device_id = ? AND user_id = ?");
        $stmt->execute([$device_id, $user_id]);

        // Update device status to 'available' and clear assigned user
        $stmt = $conn->prepare("UPDATE devices SET status = 'available', assigned_to = NULL WHERE id = ?");
        $stmt->execute([$device_id]);

        echo "Device returned successfully!";
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}

// Fetch assigned devices for the logged-in user
$user_id = $_SESSION['user_id'];
$stmt = $conn->prepare("
    SELECT devices.id, devices.device_name, devices.serial_number
    FROM devices
    INNER JOIN allocations ON devices.id = allocations.device_id
    WHERE allocations.user_id = ?
");
$stmt->execute([$user_id]);
$devices = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Return Device</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h2>Return Assigned Device</h2>
    <form method="POST">
        <select name="device_id" required>
            <option value="">Select Device</option>
            <?php foreach ($devices as $device): ?>
                <option value="<?= $device['id'] ?>"><?= $device['device_name'] ?> (<?= $device['serial_number'] ?>)</option>
            <?php endforeach; ?>
        </select>
        <button type="submit">Return Device</button>
    </form>
</body>
</html>