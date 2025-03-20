<?php
require 'auth.php';
requireUser();

require 'db.php';

$user_id = $_SESSION['user_id'];

$stmt = $conn->prepare("
    SELECT devices.device_name, devices.serial_number, allocations.allocation_date
    FROM allocations
    INNER JOIN devices ON allocations.device_id = devices.id
    WHERE allocations.user_id = ?
");
$stmt->execute([$user_id]);
$devices = $stmt->fetchAll();

echo "<h2>Your Assigned Devices</h2>";
if ($devices) {
    foreach ($devices as $device) {
        echo "Device: " . $device['device_name'] . " | Serial: " . $device['serial_number'] . " | Allocated on: " . $device['allocation_date'] . "<br>";
    }
} else {
    echo "No devices assigned.";
}
?>