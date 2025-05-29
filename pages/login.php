<?php
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

 <div class="form-wrapper">
        <form action="/project/auth/login.php" method="POST" class="form-auth">
            <h2 class="form-auth-title">Login</h2>
            <div class="form-auth-accent"></div>
            <div class="form-auth-group">
                <label for="username_or_email" class="form-auth-label">Username or Email:</label>
                <input type="text" id="username_or_email" name="username_or_email" required maxlength="100" class="form-auth-input" placeholder="Enter your username or email" />
            </div>

            <div class="form-auth-group">
                <label for="password" class="form-auth-label">Password:</label>
                <input type="password" id="password" name="password" required class="form-auth-input" placeholder="Enter your password" />
            </div>

            <button type="submit" class="form-auth-button">Login</button>
        </form>
    </div>
</body>
</html>
