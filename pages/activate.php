<?php 
require_once '../db_config.php';  

$message = ''; 
$redirectUrl = '../pages/login.php'; 
$redirectDelay = 3; // seconds  

if (!isset($_GET['token'])) {
    $message = "Invalid activation link.";
} else {
    $token = $_GET['token'];
    $stmt = $pdo->prepare("SELECT id, is_active FROM users WHERE activation_token = ?");
    $stmt->execute([$token]);
    $user = $stmt->fetch();

    if (!$user) {
        $message = "Invalid or expired activation token.";
    } elseif ($user['is_active']) {
        $message = "Your account is already activated.";
    } else {
        $update = $pdo->prepare("UPDATE users SET is_active = 1, activation_token = NULL WHERE id = ?");
        if ($update->execute([$user['id']])) {
            $message = "Your account has been activated! Redirecting to login page...";
        } else {
            $message = "Failed to activate account. Please try again later.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Account Activation</title>
  <meta http-equiv="refresh" content="<?= $redirectDelay ?>;url=<?= htmlspecialchars($redirectUrl) ?>" />
  <style>
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap');

    .message-box-wrapper {
      font-family: 'Inter', Arial, sans-serif;
      background: #f0f4f3;
      margin: 0;
      padding: 0;
      height: 100vh;
      display: flex;
      justify-content: center;
      align-items: center;
      color: #004d40;
    }

    .message-box {
      background: #ffffff;
      border-radius: 12px;
      padding: 40px 50px;
      box-shadow: 0 10px 30px rgba(0, 121, 107, 0.2);
      max-width: 480px;
      width: 90%;
      text-align: center;
      border: 2px solid #00796b;
      transition: box-shadow 0.3s ease;
    }
    .message-box:hover {
      box-shadow: 0 15px 45px rgba(0, 121, 107, 0.35);
    }

    .message-box p {
      font-size: 1.3rem;
      font-weight: 600;
      margin-bottom: 20px;
      letter-spacing: -0.02em;
    }

    a {
      display: inline-block;
      text-decoration: none;
      background: linear-gradient(135deg, #00796b 0%, #004d40 100%);
      color: white;
      padding: 12px 28px;
      border-radius: 8px;
      font-weight: 600;
      font-size: 1rem;
      transition: background 0.3s ease, transform 0.2s ease;
      letter-spacing: -0.01em;
    }
    a:hover {
      background: linear-gradient(135deg, #1d4ed8 0%, #1e40af 100%);
      transform: translateY(-2px);
      box-shadow: 0 8px 25px rgba(37, 99, 235, 0.3);
    }
    a:active {
      transform: translateY(0);
      box-shadow: 0 4px 15px rgba(37, 99, 235, 0.2);
    }
  </style>
</head>
<body>
    <div class="message-box-wrapper">
        <div class="message-box">
            <p><?= htmlspecialchars($message) ?></p>
            <a href="<?= htmlspecialchars($redirectUrl) ?>">Go to Login</a>
        </div>
    </div>
</body>
</html>
