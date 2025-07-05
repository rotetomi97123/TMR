<?php
require_once '../includes/session.php';
require_once '../includes/config.php';
require_once '../db_config.php';

session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: ../pages/login.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userId = $_SESSION['user_id'];
    $propertyId = $_POST['property_id'] ?? null;

    if ($propertyId) {
        // Ellenőrizd, hogy a property tényleg ehhez a userhez tartozik
        $stmt = $pdo->prepare("SELECT * FROM properties WHERE property_id = ? AND user_id = ?");
        $stmt->execute([$propertyId, $userId]);
        $listing = $stmt->fetch();

        if ($listing) {
            // Először töröld a property_details-ből
            $deleteDetails = $pdo->prepare("DELETE FROM property_details WHERE property_id = ?");
            $deleteDetails->execute([$propertyId]);

            // Aztán töröld a properties-ből
            $deleteStmt = $pdo->prepare("DELETE FROM properties WHERE property_id = ?");
            $deleteStmt->execute([$propertyId]);


            header("Location: profil.php?delete_success=1");
            exit;
        }
    }
}

// Ha ide jut, akkor hiba volt
header("Location: profil.php?delete_error=1");
exit;
