<?php
session_start();

// Clear all session data
$_SESSION = [];

// Destroy the session
session_destroy();

// Redirect to login or homepage after logout
header("Location: /project/pages/login.php");
exit;
?>
