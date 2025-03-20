<!-- creates a file to handle logging out-->
<?php
session_start();
session_unset();
session_destroy();
header("Location: login.php");
?>