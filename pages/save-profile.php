<?php
require_once '../includes/session.php';
require_once '../includes/config.php';

require_once '../db_config.php';
session_start();


if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location:' . $base_url .  'pages/profil.php');

    exit;
}

if (!isset($_SESSION['user_id'])) {
    header('Location:' . $base_url .  'pages/login.php');

    exit;
}

$userId = $_SESSION['user_id'];

$email = trim($_POST['email'] ?? '');
$firstName = trim($_POST['first_name'] ?? '');
$lastName = trim($_POST['last_name'] ?? '');
$phone = trim($_POST['phone'] ?? '');

$errors = [];

if ($email !== $_SESSION['email']) {
    if (empty($email)) {
        $errors[] = "Email is required.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid email format.";
    }
}

if (!empty($firstName) && !preg_match("/^[a-zA-Z-' ]{2,50}$/", $firstName)) {
    $errors[] = "First name must be 2-50 letters, spaces, apostrophes or hyphens only.";
}

if (!empty($lastName) && !preg_match("/^[a-zA-Z-' ]{2,50}$/", $lastName)) {
    $errors[] = "Last name must be 2-50 letters, spaces, apostrophes or hyphens only.";
}

if (!empty($phone) && !preg_match("/^[0-9 +\-]{5,20}$/", $phone)) {
    $errors[] = "Phone number must be 5-20 characters and contain only digits, spaces, + or -.";
}

if (!empty($errors)) {
    foreach ($errors as $error) {
        echo "<p style='color:red'>" . htmlspecialchars($error) . "</p>";
    }
    echo '<p><a href="' . $base_url . 'pages/profil.php">Go back to profile</a></p>';

    exit;
}

try {
    $stmt = $pdo->prepare("UPDATE users SET email = ?, first_name = ?, last_name = ?, phone = ?, updated_at = NOW() WHERE id = ?");
    $stmt->execute([$email, $firstName, $lastName, $phone, $userId]);

    $_SESSION['email'] = $email;
    $_SESSION['first_name'] = $firstName;
    $_SESSION['last_name'] = $lastName;
    $_SESSION['phone'] = $phone;

    header('Location:' . $base_url .  'pages/profil.php');

    exit;
} catch (PDOException $e) {
    echo "<p style='color:red'>Database error: " . htmlspecialchars($e->getMessage()) . "</p>";
    echo '<p><a href="' . $base_url . 'pages/profil.php">Go back to profile</a></p>';
    exit;
}