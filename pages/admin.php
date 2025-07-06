<?php
require_once '../db_config.php';
include "../includes/config.php";
session_start();

// Check if admin is logged in (optional, but recommended)
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    die("Access denied.");
}

// Handle activate action
if (isset($_GET['activate_id'])) {
    $activate_id = (int)$_GET['activate_id'];

    $stmt = $pdo->prepare("UPDATE properties SET is_active_property = 1 WHERE property_id = ?");
    $stmt->execute([$activate_id]);

    // Redirect to avoid resubmission
    header("Location: admin.php");
    exit;
}

// Fetch inactive properties
$sql = "
    SELECT 
        p.property_id,
        p.title,
        p.description,
        p.address,
        p.city,
        pt.name AS property_type,
        p.transaction,
        p.price,
        p.created_at,
        pi.image_url,
        pd.size,
        pd.rooms,
        pd.floor,
        pd.furnished,
        pd.heating_type,
        pd.parking,
        pd.beds,
        pd.bathroom,
        u.email,
        u.phone
    FROM properties p
    JOIN property_types pt ON p.property_type_id = pt.property_type_id
    LEFT JOIN property_images pi ON p.property_id = pi.property_id AND pi.is_main = 1
    LEFT JOIN property_details pd ON p.property_id = pd.property_id
    JOIN users u ON p.user_id = u.user_id
    WHERE p.is_active_property = 0
    ORDER BY p.created_at DESC
";

$sql_deact = "
    SELECT 
        p.property_id,
        p.title,
        p.description,
        p.address,
        p.city,
        pt.name AS property_type,
        p.transaction,
        p.price,
        p.created_at,
        pi.image_url,
        pd.size,
        pd.rooms,
        pd.floor,
        pd.furnished,
        pd.heating_type,
        pd.parking,
        pd.beds,
        pd.bathroom,
        u.email,
        u.phone
    FROM properties p
    JOIN property_types pt ON p.property_type_id = pt.property_type_id
    LEFT JOIN property_images pi ON p.property_id = pi.property_id AND pi.is_main = 1
    LEFT JOIN property_details pd ON p.property_id = pd.property_id
    JOIN users u ON p.user_id = u.user_id
    WHERE p.is_active_property = 1
    ORDER BY p.created_at DESC
";

$stmt = $pdo->query($sql);
$stmt_deact = $pdo->query($sql_deact);

$properties = $stmt->fetchAll(PDO::FETCH_ASSOC);
$deact_properties = $stmt_deact->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>StanoviSrbije</title>
    <!-- Bootstrap CSS -->
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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css"/>

    <link rel="icon" href="./assets/favicon.ico" type="image/x-icon" />
  </head>
    <div class="container my-4">
        <?php include "../includes/header.php" ?>
    <div class="container my-4 admin_wrapper">
        <div class="admin_text ">
            <h1 class="mb-4">Property Management</h1>
            <div class="d-flex align-items-center gap-2">
                <button id="toggle-properties-btn" class="admin_show_prop">
                    Show Active Properties
                </button>
                <button class="admin-manage-btn" onclick="location.href='../pages/admin_users.php'">
                    Manage Users
                </button>
                </div>
        </div>

<?php if (empty($properties)): ?>
    <p class="no-properties-msg">No inactive properties found.</p>
<?php else: ?>
    <div class="admin-flex">
       <div class="properties-grid " id="inactive-properties">
        <?php foreach ($properties as $p): ?>
            <div class="property-card" data-id="<?= (int)$p['property_id'] ?>">
                <img
                    src="<?= htmlspecialchars($p['image_url'] ?? 'https://via.placeholder.com/300x200?text=No+Image') ?>"
                    alt="Property Image"
                    class="property-image"
                />
                <div class="property-content">
                    <h5 class="property-title"><?= htmlspecialchars($p['title']) ?></h5>
                    <p class="property-type"><strong>Type:</strong> <?= htmlspecialchars($p['property_type']) ?></p>
                    <p class="property-price"><strong>Price:</strong> €<?= number_format($p['price'], 2) ?></p>

                    <div class="more-details hidden">
                        <p class="property-transaction"><strong>Transaction:</strong> <?= htmlspecialchars($p['transaction']) ?></p>
                        <p class="property-address"><strong>Address:</strong> <?= htmlspecialchars($p['address']) ?>, <?= htmlspecialchars($p['city']) ?> </p>
                        <p class="property-description"><strong>Description:</strong> <?= nl2br(htmlspecialchars($p['description'])) ?></p>

                        <hr />

                        <h6>Property Details:</h6>
                        <ul class="property-details-list">
                            <li>Size: <?= htmlspecialchars($p['size']) ?> m²</li>
                            <li>Rooms: <?= htmlspecialchars($p['rooms']) ?></li>
                            <li>Floor: <?= htmlspecialchars($p['floor']) ?></li>
                            <li>Furnished: <?= htmlspecialchars($p['furnished']) ?></li>
                            <li>Heating: <?= htmlspecialchars($p['heating_type']) ?></li>
                            <li>Parking: <?= htmlspecialchars($p['parking']) ?></li>
                            <li>Beds: <?= htmlspecialchars($p['beds']) ?></li>
                            <li>Bathrooms: <?= htmlspecialchars($p['bathroom']) ?></li>
                        </ul>

                        <hr />

                        <h6>Contact Info:</h6>
                        <p>Email: <a href="mailto:<?= htmlspecialchars($p['email']) ?>"><?= htmlspecialchars($p['email']) ?></a></p>
                        <p>Phone: <?= htmlspecialchars($p['phone']) ?></p>
                    </div>

                    <button class="btn-show-more" type="button">Show More</button>
                    <div class="d-flex gap-2">
                        <button
                                class="btn btn-success btn-action"
                                data-id="<?= (int)$p['property_id'] ?>"
                                data-action="activate"
                                >
                                Activate
                        </button>
                            <button
                            class="btn btn-outline-danger btn-delete"
                            data-id="<?= (int)$p['property_id'] ?>"
                        >
                            Delete
                        </button>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
        </div>
           <div class="properties-grid" id="active-properties">
        <?php foreach ($deact_properties as $p): ?>
            <div class="property-card">
                <img
                    src="<?= htmlspecialchars($p['image_url'] ?? 'https://via.placeholder.com/300x200?text=No+Image') ?>"
                    alt="Property Image"
                    class="property-image"
                />
                <div class="property-content">
                    <h5 class="property-title"><?= htmlspecialchars($p['title']) ?></h5>
                    <p class="property-type"><strong>Type:</strong> <?= htmlspecialchars($p['property_type']) ?></p>
                    <p class="property-price"><strong>Price:</strong> €<?= number_format($p['price'], 2) ?></p>

                    <div class="more-details hidden">
                        <p class="property-transaction"><strong>Transaction:</strong> <?= htmlspecialchars($p['transaction']) ?></p>
                        <p class="property-address"><strong>Address:</strong> <?= htmlspecialchars($p['address']) ?>, <?= htmlspecialchars($p['city']) ?> </p>
                        <p class="property-description"><strong>Description:</strong> <?= nl2br(htmlspecialchars($p['description'])) ?></p>

                        <hr />

                        <h6>Property Details:</h6>
                        <ul class="property-details-list">
                            <li>Size: <?= htmlspecialchars($p['size']) ?> m²</li>
                            <li>Rooms: <?= htmlspecialchars($p['rooms']) ?></li>
                            <li>Floor: <?= htmlspecialchars($p['floor']) ?></li>
                            <li>Furnished: <?= htmlspecialchars($p['furnished']) ?></li>
                            <li>Heating: <?= htmlspecialchars($p['heating_type']) ?></li>
                            <li>Parking: <?= htmlspecialchars($p['parking']) ?></li>
                            <li>Beds: <?= htmlspecialchars($p['beds']) ?></li>
                            <li>Bathrooms: <?= htmlspecialchars($p['bathroom']) ?></li>
                        </ul>

                        <hr />

                        <h6>Contact Info:</h6>
                        <p>Email: <a href="mailto:<?= htmlspecialchars($p['email']) ?>"><?= htmlspecialchars($p['email']) ?></a></p>
                        <p>Phone: <?= htmlspecialchars($p['phone']) ?></p>
                    </div>

                    <button class="btn-show-more" type="button">Show More</button>

                        <button
                            class="btn btn-danger btn-action"
                            data-id="<?= (int)$p['property_id'] ?>"
                            data-action="deactivate"
                        >
                            Deactivate
                        </button>
                </div>
            </div>
        <?php endforeach; ?>
        </div>
    </div>
<?php endif; ?>


  <script src="../js/navbar.js" ></script>
  <script src="../js/admin.js" ></script>
</body>

</html>
