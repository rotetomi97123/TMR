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
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $first_name = trim($_POST['first_name']);
    $last_name = trim($_POST['last_name']);
    $phone = trim($_POST['phone']);
    $role = 'user';

    if (empty($username) || empty($email) || empty($password)) {
        die("Please fill in all required fields.");
    }

    // ❗ FIX: Check by 'user_id' instead of non-existent 'id'
    $stmt = $pdo->prepare("SELECT user_id FROM users WHERE username = ? OR email = ?");
    $stmt->execute([$username, $email]);
    if ($stmt->fetch()) {
        die("Username or email already taken.");
    }

    $password_hash = password_hash($password, PASSWORD_BCRYPT);
    $activation_token = bin2hex(random_bytes(16));

    $stmt = $pdo->prepare("INSERT INTO users 
        (username, email, password_hash, first_name, last_name, phone, role, is_active, activation_token)
        VALUES (?, ?, ?, ?, ?, ?, ?, 0, ?)");
    $stmt->execute([$username, $email, $password_hash, $first_name, $last_name, $phone, $role, $activation_token]);

    $activation_link = "http://" . $_SERVER['HTTP_HOST'] . '/' . $base_url . "pages/activate.php?token=" . $activation_token;

    $mail = new PHPMailer(true);

    try {
        // SMTP settings from .env
        $mail->isSMTP();
        $mail->Host       = $_ENV['MAIL_HOST'];
        $mail->SMTPAuth   = true;
        $mail->Username   = $_ENV['MAIL_USER'];
        $mail->Password   = $_ENV['MAIL_PASS'];
        $mail->SMTPSecure = 'tls';
        $mail->Port       = $_ENV['MAIL_PORT'];

        // Email content
        $mail->setFrom('tot.tamas04@gmail.com', 'StanoviSrbija');
        $mail->addAddress($email, $username);

        $mail->isHTML(true);
        $mail->Subject = 'Activate your account';
        $mail->Body = '
            <div style="font-family: Arial, sans-serif; max-width: 600px; margin: auto; padding: 20px; background: #f9f9f9; border: 1px solid #ddd; border-radius: 8px;">
                <div style="text-align: center; margin-bottom: 20px;">
                    <img src="https://i.ibb.co/tTTkb0xY/Stanovi-Srbije-Logo.png" alt="StanoviSrbija Logo" style="max-width: 150px;">
                </div>
                <h2 style="color: #00796b; text-align: center;">Welcome to StanoviSrbija, ' . htmlspecialchars($username) . '!</h2>
                <p style="font-size: 16px; color: #333; text-align: center;">
                    Thanks for registering. To complete your registration, please activate your account by clicking the button below:
                </p>
                <p style="text-align: center; margin: 30px 0;">
                    <a href="' . $activation_link . '" style="
                        background-color: #00796b;
                        color: #ffffff;
                        padding: 14px 28px;
                        text-decoration: none;
                        font-size: 16px;
                        font-weight: bold;
                        border-radius: 6px;
                        display: inline-block;">
                        Activate Account
                    </a>
                </p>
                <p style="font-size: 14px; color: #555; text-align: center;">
                    If you did not register, you can safely ignore this email.
                </p>
                <p style="font-size: 12px; color: #999; margin-top: 40px; text-align: center;">
                    &copy; ' . date('Y') . ' StanoviSrbija. All rights reserved.
                </p>
            </div>
        ';

        $mail->send();
        echo "Registration successful! Please check your email to activate your account.";
        header("refresh:3;url=../pages/login.php");
    } catch (Exception $e) {
        echo "Registration successful, but failed to send activation email. Mailer Error: {$mail->ErrorInfo}";
    }
}
