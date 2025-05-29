<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    // User is not logged in
    header("Location: /pages/login_form.php");
    exit;
}
