<?php
// Controller: Admin Cake Management (Add, Edit, Delete with Image Upload)
session_start();
require_once __DIR__ . '/../db.php';

// Check if user is logged in as Admin
if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
    header("Location: ../pages/login.php?error=" . urlencode("Unauthorized access! Admin login required."));
    exit();
}

/**
 * Upload image helper: stores file into assests/cake folder, renames to timestamp string
 */
function processCakeImageUpload() {
    if (isset($_FILES['cake_image']) && $_FILES['cake_image']['error'] === UPLOAD_ERR_OK) {
        $fileTmpPath = $_FILES['cake_image']['tmp_name'];
        $fileName = $_FILES['cake_image']['name'];
        $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

        $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
        if (in_array($fileExtension, $allowedExtensions)) {
            // Rename the image to timestamp (e.g. 1723598400_123.jpg)
            $timestampFilename = time() . '_' . rand(100, 999) . '.' . $fileExtension;
            $uploadFileDir = __DIR__ . '/../assests/cake/';

            if (!is_dir($uploadFileDir)) {
                mkdir($uploadFileDir, 0777, true);
            }

            $dest_path = $uploadFileDir . $timestampFilename;
            if (move_uploaded_file($fileTmpPath, $dest_path)) {
                return $timestampFilename; // Returns timestamp string
            }
        }
    }
    return null;
}

$action = $_POST['action'] ?? $_GET['action'] ?? '';

if ($action === 'add') {
    $name = trim($_POST['name'] ?? '');
    $cake_type = trim($_POST['cake_type'] ?? 'kilo');
    $size = trim($_POST['size'] ?? '1 KG');
    $flavor = trim($_POST['flavor'] ?? '');
    $description = trim($_POST['description'] ?? '');
    $base_price = (float)($_POST['base_price'] ?? 0.00);

    // Process image file upload
    $uploadedImage = processCakeImageUpload();
    $image = $uploadedImage ? $uploadedImage : trim($_POST['image'] ?? 'fa-cake-candles');

    if (!empty($name) && $base_price > 0) {
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
    $cake_type = trim($_POST['cake_type'] ?? 'kilo');
    $size = trim($_POST['size'] ?? '1 KG');
    $description = trim($_POST['description'] ?? '');
    $base_price = (float)($_POST['base_price'] ?? 0.00);

    // Process image file upload if new file was selected
    $uploadedImage = processCakeImageUpload();

    if ($id > 0 && !empty($name) && $base_price > 0) {
        $imageUpdateSql = $uploadedImage ? ", image = '$uploadedImage'" : "";

        $sql = "UPDATE cakes SET 
                name = '$name', 
                cake_type = '$cake_type', 
                size = '$size', 
                description = '$description', 
                base_price = $base_price 
                $imageUpdateSql 
                WHERE id = $id";
                
        if (mysqli_query($conn, $sql)) {
            header("Location: ../pages/dashboard.php?success=" . urlencode("Cake '$name' updated successfully!"));
            exit();
        }
    }
    header("Location: ../pages/dashboard.php?error=" . urlencode("Failed to update cake."));
    exit();
} 

elseif ($action === 'delete') {
    $id = (int)($_GET['id'] ?? $_POST['id'] ?? 0);
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
