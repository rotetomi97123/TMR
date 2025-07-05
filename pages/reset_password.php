<?php
require_once '../db_config.php';
require_once __DIR__ . '/../vendor/autoload.php';
require_once "../includes/config.php";

use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__ . '/..');
$dotenv->load();

$token = $_GET['token'] ?? '';

if (!$token) {
    exit("Invalid or missing token.");
}

// Ellenőrizzük, hogy a token létezik-e és nem járt-e le
$stmt = $pdo->prepare("SELECT user_id FROM users WHERE reset_token = ? AND token_expiry > NOW()");
$stmt->execute([$token]);
$user = $stmt->fetch();

if (!$user) {
    exit("The password reset link is invalid or has expired.");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $new_password = $_POST['password'] ?? '';
    $confirm_password = $_POST['confirm_password'] ?? '';

    if (strlen($new_password) < 8) {
        $error = "Password must be at least 8 characters.";
    } elseif ($new_password !== $confirm_password) {
        $error = "Passwords do not match.";
    } else {
        $password_hash = password_hash($new_password, PASSWORD_BCRYPT);

        $stmt = $pdo->prepare("UPDATE users SET password_hash = ?, reset_token = NULL, token_expiry = NULL WHERE user_id = ?");
        $stmt->execute([$password_hash, $user['user_id']]);

        // Redirect automatically to login page after password reset
        header("Location: ../pages/login.php?reset=success");
        exit;
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Reset Password</title>
  <link rel="stylesheet" href="../css/styles.css" /> <!-- Your styles for classes -->
</head>
<body>
  <div class="form-wrapper">
    <form action="" method="POST" class="form-auth">
      <h2 class="form-auth-title">Reset Password</h2>

      <?php if (!empty($error)) : ?>
        <p style="color:red"><?= htmlspecialchars($error) ?></p>
      <?php endif; ?>

      <div class="form-auth-group">
        <label for="password" class="form-auth-label">New Password <span class="required">*</span></label>
        <input
          type="password"
          name="password"
          id="password"
          class="form-auth-input"
          required
          minlength="8"
          placeholder="Enter new password"
        />
      </div>

      <div class="form-auth-group">
        <label for="confirm_password" class="form-auth-label">Confirm Password <span class="required">*</span></label>
        <input
          type="password"
          name="confirm_password"
          id="confirm_password"
          class="form-auth-input"
          required
          minlength="8"
          placeholder="Repeat new password"
        />
      </div>

      <button type="submit" class="form-auth-button">Save New Password</button>
    </form>
  </div>
</body>
</html>
