<?php
require_once '../db_config.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $input = trim($_POST['username_or_email'] ?? ''); 
    $password = $_POST['password'] ?? '';

    if (empty($input) || empty($password)) {
        die("Please enter both username/email and password.");
    }

    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ? OR email = ?");
    $stmt->execute([$input, $input]);
    $user = $stmt->fetch();

    if (!$user) {
        die("Invalid username or password.");
    }

    if ($user['is_blocked']) {
        die("Your account is blocked.");
    }

    if (!$user['is_active']) {
        die("Please activate your account first.");
    }

    // Verify password
    if (password_verify($password, $user['password_hash'])) {
        // Login success, save session
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['role'] = $user['role'];
        $_SESSION['email'] = $user['email'];
        $_SESSION['first_name'] = $user['first_name'];
        $_SESSION['last_name'] = $user['last_name'];
        $_SESSION['phone'] = $user['phone'];
        
        

        header("Location: ../index.php");
        exit;
    } else {
        die("Invalid username or password.");
    }
} else {
    // If not POST, maybe redirect to login form
    header("Location: ../pages/login.php");
    exit;
}
