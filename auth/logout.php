<?php
    require_once '../includes/config.php';
    session_start();

    // Clear all session data
    $_SESSION = [];

    // Destroy the session
    session_destroy();

    // Redirect to login or homepage after logout
    header("Location: " . $base_url . "pages/login.php");

    exit;
?>
