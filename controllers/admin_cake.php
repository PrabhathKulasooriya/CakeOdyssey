<?php
// Controller: Admin Cake Catalog Management (Add, Edit, Delete)
session_start();
require_once __DIR__ . '/../db.php';

// Enforce admin role authorization check
if (($_SESSION['user_role'] ?? '') !== 'admin') {
    header("Location: ../pages/login.php?error=" . urlencode("Unauthorized access! Admin login required."));
    exit();
}

/**
 * Handles uploaded cake images by validating extension and renaming to a unique timestamp file.
 */
function processCakeImageUpload() {
    if (!empty($_FILES['cake_image']['name']) && $_FILES['cake_image']['error'] === UPLOAD_ERR_OK) {
        $ext = strtolower(pathinfo($_FILES['cake_image']['name'], PATHINFO_EXTENSION));
        if (in_array($ext, ['jpg', 'jpeg', 'png', 'gif', 'webp'])) {
            $filename = time() . '_' . rand(100, 999) . '.' . $ext;
            $dir = __DIR__ . '/../assests/cake/';
            if (!is_dir($dir)) mkdir($dir, 0777, true);
            if (move_uploaded_file($_FILES['cake_image']['tmp_name'], $dir . $filename)) {
                return $filename;
            }
        }
    }
    return null;
}

$action = $_REQUEST['action'] ?? '';

if ($action === 'add') {
    $name = trim($_POST['name'] ?? '');
    $cake_type = $_POST['cake_type'] ?? 'kilo';
    $size = $_POST['size'] ?? '1 KG';
    $flavor = trim($_POST['flavor'] ?? '');
    $description = trim($_POST['description'] ?? '');
    $base_price = (float)($_POST['base_price'] ?? 0);

    // Prefer uploaded image file over default FontAwesome icon string
    $image = processCakeImageUpload() ?: trim($_POST['image'] ?? 'fa-cake-candles');

    if ($name && $base_price > 0) {
        $sql = "INSERT INTO cakes (name, cake_type, size, image, description, base_price) 
                VALUES ('$name', '$cake_type', '$size', '$image', '$description', $base_price)";
        if (mysqli_query($conn, $sql)) {
            header("Location: ../pages/dashboard.php?success=" . urlencode("Cake '$name' added successfully!"));
            exit();
        }
    }
    header("Location: ../pages/dashboard.php?error=" . urlencode("Failed to add cake. Please fill in all required fields correctly."));
    exit();
} 
elseif ($action === 'edit') {
    $id = (int)($_POST['id'] ?? 0);
    $name = trim($_POST['name'] ?? '');
    $cake_type = $_POST['cake_type'] ?? 'kilo';
    $size = $_POST['size'] ?? '1 KG';
    $description = trim($_POST['description'] ?? '');
    $base_price = (float)($_POST['base_price'] ?? 0);

    $uploadedImage = processCakeImageUpload();

    if ($id > 0 && $name && $base_price > 0) {
        // Only update image column if a new image was uploaded
        $imageUpdateSql = $uploadedImage ? ", image = '$uploadedImage'" : "";
        $sql = "UPDATE cakes SET name = '$name', cake_type = '$cake_type', size = '$size', description = '$description', base_price = $base_price $imageUpdateSql WHERE id = $id";
        if (mysqli_query($conn, $sql)) {
            header("Location: ../pages/dashboard.php?success=" . urlencode("Cake '$name' updated successfully!"));
            exit();
        }
    }
    header("Location: ../pages/dashboard.php?error=" . urlencode("Failed to update cake."));
    exit();
} 
elseif ($action === 'delete') {
    $id = (int)($_REQUEST['id'] ?? 0);
    if ($id > 0) {
        mysqli_query($conn, "DELETE FROM cakes WHERE id = $id");
        header("Location: ../pages/dashboard.php?success=" . urlencode("Cake removed successfully!"));
        exit();
    }
    header("Location: ../pages/dashboard.php?error=" . urlencode("Invalid cake ID."));
    exit();
}

header("Location: ../pages/dashboard.php");
exit();
?>
