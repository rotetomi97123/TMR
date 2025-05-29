<?php
require_once '../db_config.php';

// Include Composer's autoloader for PHPMailer
require_once __DIR__ . '/../vendor/autoload.php';


use Dotenv\Dotenv;

// Tell Dotenv to look for .env one folder up (root)
$dotenv = Dotenv::createImmutable(__DIR__ . '/..');
$dotenv->load();

    
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;



if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $first_name = trim($_POST['first_name']);
    $last_name = trim($_POST['last_name']);
    $phone = trim($_POST['phone']);
    $role = 'user';  // default role
    
    // Basic validation (you can expand this)
    if (empty($username) || empty($email) || empty($password)) {
        die("Please fill in all required fields.");
    }

    // Check if username or email exists
    $stmt = $pdo->prepare("SELECT id FROM users WHERE username = ? OR email = ?");
    $stmt->execute([$username, $email]);
    if ($stmt->fetch()) {
        die("Username or email already taken.");
    }

    // Hash password
    $password_hash = password_hash($password, PASSWORD_BCRYPT);

    // Generate activation token
    $activation_token = bin2hex(random_bytes(16));
    
    // Insert user with is_active = 0 (inactive)
    $stmt = $pdo->prepare("INSERT INTO users 
        (username, email, password_hash, first_name, last_name, phone, role, is_active, activation_token)
        VALUES (?, ?, ?, ?, ?, ?, ?, 0, ?)");
    $stmt->execute([$username, $email, $password_hash, $first_name, $last_name, $phone, $role, $activation_token]);

    // Prepare activation email
    $activation_link = "http://localhost:3000/project/pages/activate.php?token=" . $activation_token;

    // Send email with PHPMailer and Mailtrap
    $mail = new PHPMailer(true);

    try {
        // Server settings
        $mail->isSMTP();
        $mail->Host       = $_ENV['MAIL_HOST'];;
        $mail->SMTPAuth   = true;
        $mail->Username   = $_ENV['MAIL_USER'];; // replace with your Mailtrap username
        $mail->Password   = $_ENV['MAIL_PASS'];; // replace with your Mailtrap password
        $mail->SMTPSecure = 'tls';
        $mail->Port       = 2525;

        // Recipients
        $mail->setFrom('tot.tamas04@gmail.com', 'StanoviSrbija');
        $mail->addAddress($email, $username);

        // Content
        $mail->isHTML(true);
        $mail->Subject = 'Activate your account';
        $mail->Body    = '
            <p>Hi ' . htmlspecialchars($username) . ',</p>
            <p>Thanks for registering! Please activate your account by clicking the button below:</p>
            <p>
                <a href="' . $activation_link . '" style="
                   background-color: #28a745;
                   color: white;
                   padding: 12px 24px;
                   text-decoration: none;
                   font-weight: bold;
                   border-radius: 5px;
                   display: inline-block;">
                   Activate Account
                </a>
            </p>
            <p>If you did not register, please ignore this email.</p>
        ';

        $mail->send();
        echo "Registration successful! Please check your email to activate your account.";
    } catch (Exception $e) {
        echo "Registration successful, but failed to send activation email. Mailer Error: {$mail->ErrorInfo}";
    }
}
?>
