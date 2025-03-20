<?php
require 'auth.php';
requireAdmin();

require 'db.php';

// Fetch all devices and their assigned user (if any)
$stmt = $conn->query("
    SELECT devices.id, devices.device_name, devices.serial_number, devices.status, users.username 
    FROM devices
    LEFT JOIN users ON devices.assigned_to = users.id
");
$devices = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Device List</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>

<div class="container">
    <h2>Device List</h2>
    <table>
        <tr>
            <th>ID</th>
            <th>Device Name</th>
            <th>Serial Number</th>
            <th>Status</th>
            <th>Assigned To</th>
            <th>Actions</th>
        </tr>
        <?php foreach ($devices as $device): ?>
            <tr>
                <td><?= $device['id'] ?></td>
                <td><?= $device['device_name'] ?></td>
                <td><?= $device['serial_number'] ?></td>
                <td class="<?= $device['status'] === 'available' ? 'available' : 'assigned' ?>">
                    <?= ucfirst($device['status']) ?>
                </td>
                <td><?= $device['username'] ? $device['username'] : '-' ?></td>
                <td>
                    <?php if ($device['status'] === 'assigned'): ?>
                        <a href="admin_return_device.php?device_id=<?= $device['id'] ?>">Unassign</a>
                    <?php else: ?>
                        <a href="edit_device.php?id=<?= $device['id'] ?>">Edit</a>
                        <a href="delete_device.php?id=<?= $device['id'] ?>" onclick="return confirm('Are you sure?')">Delete</a>
                    <?php endif; ?>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
</div>

</body>
</html>