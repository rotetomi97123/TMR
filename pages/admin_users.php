<?php
require_once '../db_config.php';
include "../includes/config.php";
session_start();

// Check if admin is logged in
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    die("Access denied.");
}

// Fetch users
$stmt_inactive = $pdo->prepare("SELECT user_id, username, email, created_at FROM users WHERE is_active = 0 ORDER BY created_at DESC");
$stmt_inactive->execute();
$inactive_users = $stmt_inactive->fetchAll(PDO::FETCH_ASSOC);

$stmt_active = $pdo->prepare("SELECT user_id, username, email, created_at FROM users WHERE is_active = 1 ORDER BY created_at DESC");
$stmt_active->execute();
$active_users = $stmt_active->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Users Management - Admin</title>

  <!-- Bootstrap + Fonts -->
  <link
    href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
    rel="stylesheet"
    crossorigin="anonymous"
  />
  <link
    href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css"
    rel="stylesheet"
  />
  <link rel="stylesheet" href="../css/styles.css" />
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link
    href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,200..800;1,200..800&family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap"
    rel="stylesheet"
  />
  <link rel="icon" href="./assets/favicon.ico" type="image/x-icon" />
</head>

<body>
  <div class="container my-4">
    <?php include "../includes/header.php" ?>
    <div class="container my-4 admin_wrapper">
      <div class="admin_text">
        <h1 class="mb-4">Users Management</h1>
        <button id="toggle-users-btn" class="admin-show-prop">
            Show Active Users
        </button>
        <button class="admin-manage-btn" onclick="location.href='admin.php'">Manage Properties</button>
      </div>

      <?php if (empty($inactive_users)): ?>
        <p class="no-properties-msg">No inactive users found.</p>
      <?php else: ?>
        <div class="admin-flex">
          <!-- Inactive Users -->
          <div class="properties-grid" id="inactive-users">
            <h4 class="mb-3">Inactive Users</h4>
            <?php foreach ($inactive_users as $user): ?>
              <div class="property-card">
                <div class="property-content">
                  <h5 class="property-title"><?= htmlspecialchars($user['username']) ?></h5>
                  <p class="property-type"><strong>Email:</strong> <?= htmlspecialchars($user['email']) ?></p>
                  <p class="property-price"><strong>Registered:</strong> <?= htmlspecialchars($user['created_at']) ?></p>

                  <div class="d-flex gap-2 mt-3 admin_users_btn">
                    <button class="btn btn-success btn-user-action"
                            data-id="<?= (int)$user['user_id'] ?>"
                            data-action="activate">
                      Activate
                    </button>
                    
                    
                  </div>
                </div>
              </div>
            <?php endforeach; ?>
          </div>

          <!-- Active Users -->
          <div class="properties-grid" id="active-users">
            <h4 class="mb-3">Active Users</h4>
            <?php foreach ($active_users as $user): ?>
              <div class="property-card">
                <div class="property-content">
                  <h5 class="property-title"><?= htmlspecialchars($user['username']) ?></h5>
                  <p class="property-type"><strong>Email:</strong> <?= htmlspecialchars($user['email']) ?></p>
                  <p class="property-price"><strong>Registered:</strong> <?= htmlspecialchars($user['created_at']) ?></p>

                    <button class="btn btn-danger btn-user-action"
                            data-id="<?= (int)$user['user_id'] ?>"
                            data-action="deactivate">
                      Deactivate
                    </button>
                
                </div>
              </div>
            <?php endforeach; ?>
          </div>
        </div>
      <?php endif; ?>
    </div>

    <script src="../js/navbar.js"></script>
    <script src="../js/admin_users.js"></script>
  </div>
</body>
</html>
