<?php
if (session_status() === PHP_SESSION_NONE) {
        session_start();
}

if (!isset($_SESSION['user_id'])) {
    // User is not logged in
    header("Location: /project/pages/login.php");
    exit;
}
