<?php
require_once '../includes/session.php';
require_once '../includes/config.php';
require_once '../db_config.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['user_id'])) {
    header("Location: ../pages/login.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userId = $_SESSION['user_id'];
    $propertyId = $_POST['property_id'] ?? null;

    if ($propertyId) {
        // Ellenőrzés, hogy a property ehhez a userhez tartozik
        $stmt = $pdo->prepare("SELECT * FROM properties WHERE property_id = ? AND user_id = ?");
        $stmt->execute([$propertyId, $userId]);
        $listing = $stmt->fetch();

        if ($listing) {
            // Törlés a property_details táblából
            $deleteDetails = $pdo->prepare("DELETE FROM property_details WHERE property_id = ?");
            $deleteDetails->execute([$propertyId]);

            // Törlés a property_images táblából is kell, mert idegen kulcs van és hivatkozik rá
            $deleteImages = $pdo->prepare("DELETE FROM property_images WHERE property_id = ?");
            $deleteImages->execute([$propertyId]);

            // Törlés a properties táblából
            $deleteStmt = $pdo->prepare("DELETE FROM properties WHERE property_id = ?");
            $deleteStmt->execute([$propertyId]);

            header("Location: profil.php?delete_success=1");
            exit;
        }
    }
}

// Hiba esetén visszairányítás
header("Location: profil.php?delete_error=1");
exit;
