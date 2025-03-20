<?php
require 'auth.php';

requireUser(); // Only normal users can access this page

echo "Welcome User, " . $_SESSION['username'];

echo "<br><a href='view_devices.php'>View Assigned Devices</a>";
echo "<br><a href='logout.php'>Logout</a>";
echo "<br><a href='return_device.php'>Return Device</a>";
?>