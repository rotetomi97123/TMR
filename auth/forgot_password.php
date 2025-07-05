<?php
require_once '../db_config.php';
require_once __DIR__ . '/../vendor/autoload.php';
require_once "../includes/config.php";

use Dotenv\Dotenv;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Load environment variables
$dotenv = Dotenv::createImmutable(__DIR__ . '/..');
$dotenv->load();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        exit("Invalid email format.");
    }

    // Find active user with this email
    $stmt = $pdo->prepare("SELECT user_id, username FROM users WHERE email = ? AND is_active = 1");
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    if (!$user) {
        exit("No active account found with that email.");
    }

    $token = bin2hex(random_bytes(32));
    $expiry = date("Y-m-d H:i:s", strtotime('+1 hour'));

    // Save token and expiry
    $stmt = $pdo->prepare("UPDATE users SET reset_token = ?, token_expiry = ? WHERE user_id = ?");
    $stmt->execute([$token, $expiry, $user['user_id']]);

    $reset_link = "http://" . $_SERVER['HTTP_HOST'] . '/' . $base_url . "pages/reset_password.php?token=" . $token;

    // Send email
    $mail = new PHPMailer(true);

    try {
        $mail->isSMTP();
        $mail->Host       = $_ENV['MAIL_HOST'];
        $mail->SMTPAuth   = true;
        $mail->Username   = $_ENV['MAIL_USER'];
        $mail->Password   = $_ENV['MAIL_PASS'];
        $mail->SMTPSecure = 'tls';
        $mail->Port       = $_ENV['MAIL_PORT'];

        $mail->setFrom('tot.tamas04@gmail.com', 'StanoviSrbija');
        $mail->addAddress($email, $user['username']);
        $mail->isHTML(true);
        $mail->Subject = 'Reset your StanoviSrbija password';
        $mail->Body = '
            <div style="font-family: Arial, sans-serif; max-width: 600px; margin: auto; padding: 20px; background: #f9f9f9; border: 1px solid #ddd; border-radius: 8px;">
                <div style="text-align: center; margin-bottom: 20px;">
                    <img src="https://i.ibb.co/tTTkb0xY/Stanovi-Srbije-Logo.png" alt="StanoviSrbija Logo" style="max-width: 150px;">
                </div>
                <h2 style="color: #00796b; text-align: center;">Reset Your Password</h2>
                <p style="font-size: 16px; color: #333; text-align: center;">
                    We received a request to reset your password. Click the button below to choose a new one:
                </p>
                <p style="text-align: center; margin: 30px 0;">
                    <a href="' . $reset_link . '" style="
                        background-color: #00796b;
                        color: #ffffff;
                        padding: 14px 28px;
                        text-decoration: none;
                        font-size: 16px;
                        font-weight: bold;
                        border-radius: 6px;
                        display: inline-block;">
                        Reset Password
                    </a>
                </p>
                <p style="font-size: 14px; color: #555; text-align: center;">
                    If you didn\'t request this, you can safely ignore this email.
                </p>
                <p style="font-size: 12px; color: #999; margin-top: 40px; text-align: center;">
                    &copy; ' . date('Y') . ' StanoviSrbija. All rights reserved.
                </p>
            </div>
        ';

        $mail->send();
        echo "Reset link sent! Please check your email.";
        header("refresh:3;url=../pages/login.php");
    } catch (Exception $e) {
        echo "Something went wrong while sending the reset email. Mailer Error: {$mail->ErrorInfo}";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Forgot Password</title>
  <link rel="stylesheet" href="../css/styles.css" />
</head>
<body>
    <?php include "../includes/header.php" ?>
  <div class="form-wrapper">
    <form action="forgot_password.php" method="POST" class="form-auth" novalidate>
      <h2 class="form-auth-title">Forgot Password</h2>
      <div class="form-auth-group">
        <label for="email" class="form-auth-label">Your Email <span class="required">*</span></label>
        <input
          type="email"
          id="email"
          name="email"
          class="form-auth-input"
          required
          placeholder="Enter your email"
        />
      </div>
      <button type="submit" class="form-auth-button">Send Reset Link</button>
    </form>
  </div>
</body>
</html>
