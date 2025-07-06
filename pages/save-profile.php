<?php
require_once '../includes/session.php';
require_once '../includes/config.php';
require_once '../db_config.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location:' . $base_url . 'pages/profil.php');
    exit;
}

if (!isset($_SESSION['user_id'])) {
    header('Location:' . $base_url . 'pages/login.php');
    exit;
}

$userId = $_SESSION['user_id'];
$username = trim($_POST['username'] ?? '');
$firstName = trim($_POST['first_name'] ?? '');
$lastName = trim($_POST['last_name'] ?? '');
$phone = trim($_POST['phone'] ?? '');

$errors = [];

// Username validation
if ($username !== $_SESSION['username']) {
    if (empty($username)) {
        $errors[] = "Username is required.";
    } elseif (strlen($username) < 8) {
        $errors[] = "Username must be at least 8 characters long.";
    } else {
        // Check uniqueness
        $checkStmt = $pdo->prepare("SELECT COUNT(*) FROM users WHERE username = ? AND user_id != ?");
        $checkStmt->execute([$username, $userId]);
        if ($checkStmt->fetchColumn() > 0) {
            $errors[] = "Username is already taken.";
        }
    }
}

// First name validation
if (!empty($firstName) && !preg_match("/^[a-zA-Z-' ]{2,50}$/", $firstName)) {
    $errors[] = "First name must be 2-50 letters, spaces, apostrophes or hyphens only.";
}

// Last name validation
if (!empty($lastName) && !preg_match("/^[a-zA-Z-' ]{2,50}$/", $lastName)) {
    $errors[] = "Last name must be 2-50 letters, spaces, apostrophes or hyphens only.";
}

// Phone validation
if (!empty($phone) && !preg_match("/^[0-9 +\-]{5,20}$/", $phone)) {
    $errors[] = "Phone number must be 5-20 characters and contain only digits, spaces, + or -.";
}

// If any validation errors
if (!empty($errors)) {
    foreach ($errors as $error) {
        echo "<p style='color:red'>" . htmlspecialchars($error) . "</p>";
    }
    echo '<p><a href="' . $base_url . 'pages/profil.php">Go back to profile</a></p>';
    exit;
}

// Update in DB
try {
    $stmt = $pdo->prepare("
        UPDATE users 
        SET username = ?, first_name = ?, last_name = ?, phone = ?, updated_at = NOW() 
        WHERE user_id = ?
    ");
    $stmt->execute([$username, $firstName, $lastName, $phone, $userId]);

    // Update session
    $_SESSION['username'] = $username;
    $_SESSION['first_name'] = $firstName;
    $_SESSION['last_name'] = $lastName;
    $_SESSION['phone'] = $phone;

    header('Location:' . $base_url . 'pages/profil.php?success=1');
    exit;
} catch (PDOException $e) {
    echo "<p style='color:red'>Database error: " . htmlspecialchars($e->getMessage()) . "</p>";
    echo '<p><a href="' . $base_url . 'pages/profil.php">Go back to profile</a></p>';
    exit;
}
