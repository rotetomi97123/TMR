<?php
require_once '../includes/config.php';

$error = '';
if (isset($_GET['error'])) {
    $error = htmlspecialchars($_GET['error']);
}
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>StanoviSrbije</title>
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
      rel="stylesheet"
      integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH"
      crossorigin="anonymous"
    />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

    <link rel="stylesheet" href="../css/styles.css" />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,200..800;1,200..800&family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap"
      rel="stylesheet"
    />
 
    <link rel="icon" href="../assets/favicon.ico" type="image/x-icon" />
  </head>
<body>

<?php include '../includes/header.php'; ?>

<?php if ($error): ?>
    <p style="color:red;"><?= $error ?></p>
<?php endif; ?>

   <div class="form-wrapper" id="register-form">
  <form action="<?= $base_url ?>auth/register.php" method="POST" class="form-auth">
    <h2 class="form-auth-title">Register</h2>
    <div class="form-auth-accent"></div>

    <div class="form-auth-group">
      <label for="username" class="form-auth-label">Username: <span class="required">*</span></label>
      <input type="text" id="username" name="username"  class="form-auth-input" placeholder="Enter your username" />
      <div id="error_username"></div>
    </div>

    <div class="form-auth-group">
      <label for="email" class="form-auth-label">Email: <span class="required">*</span></label>
      <input type="email" id="email" name="email"  class="form-auth-input" placeholder="Enter your email" />
      <div id="error_email"></div>
    </div>

    <div class="form-auth-group">
      <label for="password" class="form-auth-label">Password: <span class="required">*</span></label>
      <input type="password" id="password" name="password"  class="form-auth-input" placeholder="Enter your password" />
      <div id="error_password"></div>
    </div>

    <div class="form-auth-row">
      <div class="form-auth-group">
        <label for="first_name" class="form-auth-label">First Name: <span class="required">*</span></label>
        <input type="text" id="first_name" name="first_name"  class="form-auth-input" placeholder="First name" />
        <div id="error_first_name"></div>
      </div>

      <div class="form-auth-group">
        <label for="last_name" class="form-auth-label">Last Name: <span class="required">*</span></label>
        <input type="text" id="last_name" name="last_name" maxlength="50" class="form-auth-input" placeholder="Last name" />
        <div id="error_last_name"></div>
      </div>
    </div>

    <div class="form-auth-group">
      <label for="phone" class="form-auth-label">Phone: <span class="required">*</span></label>
      <input type="tel" id="phone" name="phone" maxlength="20" class="form-auth-input" placeholder="Enter your phone number" />
      <div id="error_phone"></div>
    </div>

    <button type="submit" class="form-auth-button">Register</button>
  </form>
</div>


<script src="../js/navbar.js"></script>
<script src="../js/auth.js"></script>
</body>
</html>
