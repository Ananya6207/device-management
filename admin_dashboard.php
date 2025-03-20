<?php
require 'auth.php';

requireAdmin(); // Only admins can access this page

echo "Welcome Admin, " . $_SESSION['username'];

echo "<br><a href='register_device.php'>Register New Device</a>";
echo "<br><a href='logout.php'>Logout</a>";
echo "<br><a href='assign_device.php'>Assign Device</a>";
echo "<br><a href='admin_return_device.php'>Unassign Device</a>";
echo "<br><a href='device_list.php'>View All Devices</a>";
?>