<?php
require 'auth.php';
requireAdmin();

require 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $device_id = $_POST['device_id'];

    try {
        // Remove the allocation
        $stmt = $conn->prepare("DELETE FROM allocations WHERE device_id = ?");
        $stmt->execute([$device_id]);

        // Update the device status to 'available'
        $stmt = $conn->prepare("UPDATE devices SET status = 'available', assigned_to = NULL WHERE id = ?");
        $stmt->execute([$device_id]);

        echo "Device unassigned successfully!";
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}

// Fetch assigned devices for all users
$stmt = $conn->query("
    SELECT devices.id, devices.device_name, devices.serial_number, users.username
    FROM devices
    INNER JOIN allocations ON devices.id = allocations.device_id
    INNER JOIN users ON allocations.user_id = users.id
");
$devices = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Unassign Device</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h2>Unassign Device (Admin)</h2>
    <form method="POST">
        <select name="device_id" required>
            <option value="">Select Device</option>
            <?php foreach ($devices as $device): ?>
                <option value="<?= $device['id'] ?>">
                    <?= $device['device_name'] ?> (<?= $device['serial_number'] ?>) - Assigned to <?= $device['username'] ?>
                </option>
            <?php endforeach; ?>
        </select>
        <button type="submit">Unassign</button>
    </form>
</body>
</html>