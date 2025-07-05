<?php
require_once '../includes/session.php';
require_once '../includes/config.php';
include_once "../db_config.php";


// Ha nincs bejelentkezve, átirányítás a login oldalra
if (!isset($_SESSION['user_id'])) {
    header("Location: ../pages/login.php");
    exit;
}

$userId = $_SESSION['user_id'];

// Lekérdezzük a felhasználó adatait az aktuális session alapján
$stmtUser = $pdo->prepare("SELECT username, email, first_name, last_name, phone, role FROM users WHERE user_id = ?");
$stmtUser->execute([$userId]);
$user = $stmtUser->fetch(PDO::FETCH_ASSOC);

if (!$user) {
    die("User not found.");
}

// Lekérdezzük az adott userhez tartozó látható ingatlanokat (listings)
$stmtListings = $pdo->prepare("
    SELECT 
        p.property_id, 
        p.title, 
        p.city, 
        pt.name AS property_type,
        p.transaction, 
        p.price, 
        p.available_from,
        p.created_at
    FROM properties p
    LEFT JOIN property_types pt ON p.property_type_id = pt.property_type_id
    WHERE p.user_id = ? 
    ORDER BY p.created_at DESC
");
$stmtListings->execute([$userId]);
$listings = $stmtListings->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>StanoviSrbije</title>
  <link
    href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
    rel="stylesheet"
    integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH"
    crossorigin="anonymous"
  />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet" />
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
    <?php include "../includes/header.php"; ?>
<div class="profile_wrapper">
  <div class="profile-card">
    <h2 class="profile-title">User Profile</h2>
    <form action="save-profile.php" method="POST" class="save_profile">
            <div class="save-profile-flex">
                <label for="username">Username: 
                    <input type="text" name="username" class="save_profile_username" value="<?= htmlspecialchars($user['username']) ?>" > 
                </label>
                <div id="error_msg_username"></div>
                <label for="email">Email: 
                    <input type="email" name="email" class="save_profile_email" disabled value="<?= htmlspecialchars($user['email']) ?> " > 
                </label>
                <div></div>
                <label for="first_name">First Name: 
                    <input type="text" name="first_name"  class="save_profile_first_name"value="<?= htmlspecialchars($user['first_name']) ?>"> 
                </label>
                <div id="error_msg_first_name"></div>
            </div>
             <div class="save-profile-flex">
                <label for="last_name">Last Name: 
                    <input type="text" name="last_name"  class="save_profile_last_name"value="<?= htmlspecialchars($user['last_name']) ?>">  
                </label>
                <div id="error_msg_last_name"></div>
                <label for="phone">Phone number: 
                    <input type="text" name="phone" class="save_profile_phone" value="<?= htmlspecialchars($user['phone']) ?>">  
                </label>
                <div id="error_msg_phone"></div>
                <button type="submit" class="save-button">Save Changes</button>
                <?php if (isset($_GET['success']) && $_GET['success'] == '1'): ?>
                    <div style="color: green; font-weight: bold; margin-bottom: 10px;">
                        Profile updated successfully!
                    </div>
                    <?php endif; ?>
                </div>

    </form>
  </div>

 <div class="profile-card">
  <h3>Your Listings</h3>
  <a href="../pages/create-listing.php" class="btn-create-listing">+ Create New Listing</a>

  <?php if (isset($_GET['delete_success'])): ?>
    <div style="color: green; font-weight: bold; margin-bottom: 10px;">
      Listing deleted successfully!
    </div>
  <?php elseif (isset($_GET['delete_error'])): ?>
    <div style="color: red; font-weight: bold; margin-bottom: 10px;">
      Failed to delete listing.
    </div>
  <?php endif; ?>

  <?php if (empty($listings)): ?>
    <p>You have no active listings yet.</p>
  <?php else: ?>
    <div class="listing-cards">
      <?php foreach ($listings as $listing): ?>
        <div class="listing-card">
          <div class="listing-image" style="background-image: url('<?= $listing['image_url'] ?? "../assets/placeholder.jpg" ?>');"></div>
          <div class="listing-content">
            <h4><?= htmlspecialchars($listing['title']) ?></h4>
            <p><strong>City:</strong> <?= htmlspecialchars($listing['city']) ?></p>
            <p><strong>Type:</strong> <?= ucfirst(htmlspecialchars($listing['property_type'])) ?></p>
            <p><strong>Transaction:</strong> <?= htmlspecialchars($listing['transaction']) ?></p>
            <p>
              <strong>Price:</strong> <?= htmlspecialchars($listing['price']) ?>
            </p>
            <form action="delete-listing.php" method="POST" onsubmit="return confirm('Are you sure you want to delete this listing?');">
              <input type="hidden" name="property_id" value="<?= $listing['property_id'] ?>">
              <button type="submit" class="btn btn-sm btn-danger">Delete</button>
            </form>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  <?php endif; ?>
</div>


</div>
<script src="../js/profile.js"></script>
<script>
  document.addEventListener("DOMContentLoaded", () => {
    const successBox = document.querySelector("div[style*='green']");
    if (successBox) {
      setTimeout(() => {
        successBox.style.display = "none";
      }, 3000);
    }
  });
</script>

</body>
</html>
