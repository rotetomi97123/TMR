
<?php
    require_once '../session.php';

    include_once "../db_config.php";
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }    
    $userId = $_SESSION['user_id'] ?? null;
   
    $listings = [];
    if ($userId) {
        $stmt = $pdo->prepare("
        SELECT id, title, city_area, property_type, listing_type, rental_price, status, created_at
        FROM listings
        WHERE user_id = ? AND is_visible = 1
        ORDER BY created_at DESC
        ");
        $stmt->execute([$userId]);
        $listings = $stmt->fetchAll(PDO::FETCH_ASSOC);
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
        <div class="profile-container">
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
                    <td><input type="text" name="id" value="<?= htmlspecialchars($_SESSION['user_id']) ?>" class="input-field" readonly></td>
                    <td><input type="text" name="username" value="<?= htmlspecialchars($_SESSION['username']) ?>" class="input-field" readonly></td>
                    <td><input type="email" name="email" value="<?= htmlspecialchars($_SESSION['email']) ?>" class="input-field" required></td>
                    <td><input type="text" name="first_name" value="<?= htmlspecialchars($_SESSION['first_name']) ?>" class="input-field"></td>
                    <td><input type="text" name="last_name" value="<?= htmlspecialchars($_SESSION['last_name']) ?>" class="input-field"></td>
                    <td><input type="text" name="phone" value="<?= htmlspecialchars($_SESSION['phone']) ?>" class="input-field"></td>
                    <td>
                    <select name="role" class="input-field" disabled>
                        <option value="guest" <?= $_SESSION['role'] === 'guest' ? 'selected' : '' ?>>Guest</option>
                        <option value="user" <?= $_SESSION['role'] === 'user' ? 'selected' : '' ?>>User</option>
                        <option value="admin" <?= $_SESSION['role'] === 'admin' ? 'selected' : '' ?>>Admin</option>
                    </select>
                    </td>
                </tr>
                </tbody>
            </table>
            <div class="save-button-container">
                <button type="submit" class="save-button">Save Changes</button>
            </div>
            </form>
        </div>
        <div class="profile-card">
        <h3>Your Listings</h3>
          <div class="create-listing-button-wrapper">
            <a href="/project/pages/create-listing.php" class="btn-create-listing">+ Create New Listing</a>
          </div>
        <?php if (empty($listings)): ?>
            <p>You have no active listings yet.</p>
        <?php else: ?>
            <table class="profile-table">
            <thead>
                <tr>
                <th>ID</th>
                <th>Title</th>
                <th>Area</th>
                <th>Type</th>
                <th>Listing Type</th>
                <th>Rental Price</th>
                <th>Status</th>
                <th>Created At</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($listings as $listing): ?>
                <tr>
                    <td><?= htmlspecialchars($listing['id']) ?></td>
                    <td><?= htmlspecialchars($listing['title']) ?></td>
                    <td><?= htmlspecialchars($listing['city_area']) ?></td>
                    <td><?= ucfirst(htmlspecialchars($listing['property_type'])) ?></td>
                    <td><?= htmlspecialchars($listing['listing_type']) ?></td>
                    <td>
                        <?php
                        $priceDisplay = "";
                        if ($listing['listing_type'] === "sale") {
                            // Sale price logic: floor(rental_price / 117000) * 1000 and format with German locale commas
                            $priceEUR = floor(floatval($listing['rental_price']) / 117000) * 1000;
                            // Format with thousands separator (dot in German)
                            $priceDisplay = number_format($priceEUR, 0, ',', '.') . " €";
                        } else {
                            // Rental price logic: ceil(rental_price / (117*50)) * 50 and show as €price/month
                            $price = ceil(floatval($listing['rental_price']) / (117 * 50)) * 50;
                            $priceDisplay = "€" . number_format($price, 0, ',', '.') . "/month";
                        }
                        echo $priceDisplay;
                        ?>
                    </td>
                    <td><?= ucfirst(htmlspecialchars($listing['status'])) ?></td>
                    <td><?= date('Y-m-d', strtotime($listing['created_at'])) ?></td>
                </tr>
                <?php endforeach; ?>

            </tbody>
            </table>
        <?php endif; ?>
        </div>
        </div>
  </body>
  </html>
