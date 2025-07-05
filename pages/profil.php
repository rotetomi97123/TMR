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

  <div class="profile-card">
    <h2 class="profile-title">User Profile</h2>
    <form action="save-profile.php" method="POST">
      <table class="profile-table">
        <thead>
          <tr>
            <th>ID</th>
            <th>Username</th>
            <th>Email</th>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Phone</th>
            <th>Role</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td><input type="text" name="user_id" value="<?= htmlspecialchars($userId) ?>" readonly></td>
            <td><input type="text" name="username" value="<?= htmlspecialchars($user['username']) ?>" readonly></td>
            <td><input type="email" name="email" value="<?= htmlspecialchars($user['email']) ?>" required></td>
            <td><input type="text" name="first_name" value="<?= htmlspecialchars($user['first_name']) ?>"></td>
            <td><input type="text" name="last_name" value="<?= htmlspecialchars($user['last_name']) ?>"></td>
            <td><input type="text" name="phone" value="<?= htmlspecialchars($user['phone']) ?>"></td>
            <td>
              <select name="role" disabled>
                <option value="guest" <?= $user['role'] === 'guest' ? 'selected' : '' ?>>Guest</option>
                <option value="user" <?= $user['role'] === 'user' ? 'selected' : '' ?>>User</option>
                <option value="admin" <?= $user['role'] === 'admin' ? 'selected' : '' ?>>Admin</option>
              </select>
            </td>
          </tr>
        </tbody>
      </table>
      <br />
      <button type="submit" class="save-button">Save Changes</button>
    </form>
  </div>

  <div class="profile-card">
    <h3>Your Listings</h3>
    <a href="../pages/create-listing.php" class="btn-create-listing">+ Create New Listing</a>

    <?php if (empty($listings)): ?>
      <p>You have no active listings yet.</p>
    <?php else: ?>
      <table class="profile-table">
        <thead>
          <tr>
            <th>ID</th>
            <th>Title</th>
            <th>City</th>
            <th>Type</th>
            <th>Transaction</th>
            <th>Price</th>
            <th>Available From</th>
            <th>Created At</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($listings as $listing): ?>
            <tr>
              <td><?= htmlspecialchars($listing['property_id']) ?></td>
              <td><?= htmlspecialchars($listing['title']) ?></td>
              <td><?= htmlspecialchars($listing['city']) ?></td>
              <td><?= ucfirst(htmlspecialchars($listing['property_type'])) ?></td>
              <td><?= htmlspecialchars($listing['transaction']) ?></td>
              <td>
                <?php
                  if ($listing['transaction'] === 'sale') {
                    // Eladási ár logika (példa)
                    $priceEUR = floor(floatval($listing['price']) / 117000) * 1000;
                    echo number_format($priceEUR, 0, ',', '.') . " €";
                  } else {
                    // Bérleti ár logika (példa)
                    $price = ceil(floatval($listing['price']) / (117 * 50)) * 50;
                    echo "€" . number_format($price, 0, ',', '.') . "/month";
                  }
                ?>
              </td>
              <td><?= htmlspecialchars($listing['available_from'] ?? '-') ?></td>
              <td><?= date('Y-m-d', strtotime($listing['created_at'])) ?></td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    <?php endif; ?>
  </div>

</body>
</html>
