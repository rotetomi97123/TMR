<?php
require_once '../includes/session.php';
require_once '../db_config.php';
require_once '../includes/config.php';

if (session_status() === PHP_SESSION_NONE) {
  session_start();
}


if (!isset($_SESSION['user_id'])) {
    header('Location:' . $base_url .  'pages/login.php');
    exit;
}

$errors = [];
$success = false;

// Handle form submission
// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Collect and sanitize inputs
    $title = trim($_POST['title'] ?? '');
    $description = trim($_POST['description'] ?? '');
    $city = trim($_POST['city'] ?? '');
    $property_type_name = $_POST['property_type'] ?? '';
    $transaction = trim($_POST['listing_type'] ?? '');
    $price = $_POST['rental_price'] ?? '';
    $address = trim($_POST['address'] ?? '');
    $beds = $_POST['beds'] ?? null;
    $bathroom = $_POST['bathroom'] ?? null;
    $square_meters = $_POST['square_meters'] ?? null;

    // Validation
    if ($title === '') $errors[] = 'Title is required.';
    if (!in_array($property_type_name, ['house', 'apartment', 'studio'])) $errors[] = 'Invalid property type.';
    if (!in_array($transaction, ['sale', 'rent'])) $errors[] = 'Invalid transaction type.';
    if (!is_numeric($price) || $price <= 0) $errors[] = 'Price must be a positive number.';

    // Upload image if available
   $imagePath = null;

// Priority 1: Uploaded file
    if (!empty($_FILES['image']['tmp_name'])) {
        $uploadsDir = '../uploads/';
        if (!is_dir($uploadsDir)) {
            mkdir($uploadsDir, 0777, true);
        }
        $imageName = basename($_FILES['image']['name']);
        $targetFile = $uploadsDir . time() . '_' . $imageName;

        if (move_uploaded_file($_FILES['image']['tmp_name'], $targetFile)) {
            $imagePath = $targetFile;
        } else {
            $errors[] = 'Image upload failed.';
        }
    }
    // Priority 2: Image URL provided (only if no file uploaded)
    elseif (!empty($_POST['image_url'])) {
        $url = trim($_POST['image_url']);

        // Basic validation for URL format
        if (filter_var($url, FILTER_VALIDATE_URL)) {
            // Optional: further validate URL points to an image (jpg, png, gif)
            $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
            $pathInfo = pathinfo(parse_url($url, PHP_URL_PATH));
            if (isset($pathInfo['extension']) && in_array(strtolower($pathInfo['extension']), $allowedExtensions)) {
                $imagePath = $url;
            } else {
                $errors[] = 'Image URL must point to a valid image file (jpg, png, gif, webp).';
            }
        } else {
            $errors[] = 'Invalid Image URL.';
        }
    }

    if (empty($errors)) {
        // 1. Get property_type_id from property_types table
        $stmt = $pdo->prepare("SELECT property_type_id FROM property_types WHERE name = ?");
        $stmt->execute([$property_type_name]);
        $propertyTypeRow = $stmt->fetch();

        if (!$propertyTypeRow) {
            $errors[] = 'Invalid property type selected.';
        } else {
            $property_type_id = $propertyTypeRow['property_type_id'];

            // 2. Insert into `properties`
            $stmt = $pdo->prepare('
                INSERT INTO properties
                (user_id, title, description, address, city, zip_code, transaction, price, available_from, created_at, property_type_id)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, NULL, NOW(), ?)
            ');
            $stmt->execute([
                $_SESSION['user_id'],
                $title,
                $description,
                $address,
                $city,
                '00000', // zip_code placeholder
                $transaction,
                $price,
                $property_type_id
            ]);

            $property_id = $pdo->lastInsertId();

            // 3. Insert into `property_details`
            $stmt = $pdo->prepare('
                INSERT INTO property_details (property_id, size, rooms, beds, bathroom, floor, furnished, heating_type, parking)
                VALUES (?, ?, ?, ?, ?, NULL, 0, NULL, NULL)
            ');
            $stmt->execute([
                $property_id,
                $square_meters ?: 0,
                ($beds ?? 1), // treat beds as rooms for now
                $beds ?: 0,
                $bathroom ?: 1
            ]);

            // 4. Insert into `property_images` if image was uploaded
            if ($imagePath) {
                $stmt = $pdo->prepare('
                    INSERT INTO property_images (property_id, image_url, is_main)
                    VALUES (?, ?, 1)
                ');
                $stmt->execute([$property_id, $imagePath]);
            }

            $success = true;
            header('Location:' . $base_url . 'pages/profil.php');
            exit;
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">
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
    <link rel="icon" href="../assets/favicon.ico" type="image/x-icon" />
  </head>
<body>
    <?php include_once "../includes/header.php" ?>
  <div class="listing-container">
    <div class="form-title">Create New Listing</div>

    <?php if (!empty($errors)): ?>
      <div class="alert alert-danger">
        <?php foreach ($errors as $error): ?>
          <div><?= htmlspecialchars($error) ?></div>
        <?php endforeach; ?>
      </div>
    <?php elseif ($success): ?>
      <div class="alert alert-success">Listing created successfully!</div>
    <?php endif; ?>

<form id="property-form" action="" method="POST" enctype="multipart/form-data">
  <img id="imagePreview" class="preview-img" />

  <div class="mb-3">
    <label class="form-label" for="image">Image</label>
    <input type="file" id="image" name="image" class="form-control" accept="image/*" onchange="previewImage(event)" />
    <div id="error_image" class="error-message"></div>
  </div>

  <div class="mb-3">
    <label class="form-label" for="image_url">Or Enter Image URL</label>
    <input type="url" id="image_url" name="image_url" class="form-control" placeholder="https://example.com/image.jpg" />
    <div id="error_image_url" class="error-message"></div>
  </div>

  <div class="mb-3">
    <label class="form-label" for="title">Title</label>
    <input type="text" id="title" name="title" class="form-control" />
    <div id="error_title" class="error-message"></div>
  </div>

  <div class="mb-3">
    <label class="form-label" for="description">Description</label>
    <textarea id="description" name="description" class="form-control" rows="4"></textarea>
    <div id="error_description" class="error-message"></div>
  </div>

  <div class="mb-3">
    <label class="form-label" for="city">City</label>
    <input type="text" id="city" name="city" class="form-control" />
    <div id="error_city" class="error-message"></div>
  </div>

  <div class="mb-3">
    <label class="form-label" for="property_type">Property Type</label>
    <select id="property_type" name="property_type" class="form-control">
      <option value="">-- Select --</option>
      <option value="apartment">Apartment</option>
      <option value="house">House</option>
      <option value="studio">Studio</option>

    </select>
    <div id="error_property_type" class="error-message"></div>
  </div>

  <div class="mb-3">
    <label class="form-label" for="listing_type">Listing Type</label>
    <select id="listing_type" name="listing_type" class="form-control">
      <option value="">-- Select --</option>
      <option value="rent">Rent</option>
      <option value="sale">Sale</option>
    </select>
    <div id="error_listing_type" class="error-message"></div>
  </div>

  <div class="mb-3">
    <label class="form-label" for="rental_price">Price</label>
    <input type="number" id="rental_price" name="rental_price" step="0.01" class="form-control" />
    <div id="error_rental_price" class="error-message"></div>
  </div>

  <div class="mb-3">
    <label class="form-label" for="address">Address</label>
    <input type="text" id="address" name="address" class="form-control" />
    <div id="error_address" class="error-message"></div>
  </div>

  <div class="mb-3">
    <label class="form-label" for="beds">Beds</label>
    <input type="number" id="beds" name="beds" class="form-control" />
    <div id="error_beds" class="error-message"></div>
  </div>

  <div class="mb-3">
    <label class="form-label" for="bathroom">Bathroom</label>
    <input type="number" id="bathroom" name="bathroom" class="form-control" />
    <div id="error_bathroom" class="error-message"></div>
  </div>

<!-- UJ -->
  <div class="mb-3">
    <label class="form-label" for="rooms">Rooms</label>
    <input type="number" id="rooms" name="rooms" class="form-control" />
    <div id="error_rooms" class="error-message"></div>
  </div>

  <div class="mb-3">
    <label class="form-label" for="floor">Floor</label>
    <input type="number" id="floor" name="floor" class="form-control" />
    <div id="error_floor" class="error-message"></div>
  </div>

  <div class="mb-3">
    <label class="form-label" for="furnished">Furnished</label>
    <select name="furnished" id="furnished">
      <option value="">Choose</option>
      <option value="0">Not furnished</option>
      <option value="1">Furnished</option>
    </select>
    <div id="error_furnished" class="error-message"></div>
  </div>

  <div class="mb-3">
    <label class="form-label" for="heating_type">Heating type</label>
    <select name="heating_type" id="heating_type">
      <option value="">Choose</option>
      <option value="central">Central</option>
      <option value="forced_air">Forced air</option>
      <option value="electric">Electric</option>
      <option value="radiator">Radiator</option>
    </select>
    <div id="error_heating_type" class="error-message"></div>
  </div>

  <div class="mb-3">
    <label class="form-label" for="parking">Parking</label>
    <select name="parking" id="parking">
      <option value="">Choose</option>
      <option value="0">Not have parking place</option>
      <option value="1">Parking place</option>
    </select>
    <div id="error_parking" class="error-message"></div>
  </div>
<!-- UJ -->
  <div class="mb-3">
    <label class="form-label" for="square_meters">Square Meters</label>
    <input type="number" id="square_meters" name="square_meters" class="form-control" />
    <div id="error_square_meters" class="error-message"></div>
  </div>

  <a href="<?= $base_url ?>pages/profil.php" class="submit-button">Cancel</a>
  <button type="submit" class="submit-button">Submit Listing</button>
</form>


<script src="../js/navbar.js"></script>

  <script>
    function previewImage(event) {
      const input = event.target;
      const preview = document.getElementById('imagePreview');
      if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = e => {
          preview.src = e.target.result;
          preview.style.display = 'block';
        };
        reader.readAsDataURL(input.files[0]);
      }
    }
  </script>
  <script src="../js/create-listing.js"></script>
</body>
</html>
