<?php
// Controller: Update User Account Details (with Password Confirmation)
session_start();
require_once __DIR__ . '/../db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../pages/login.php");
    exit();
}

$user_id          = (int)$_SESSION['user_id'];
$name             = trim($_POST['name'] ?? '');
$mobile_number    = trim($_POST['mobile_number'] ?? '');
$address          = trim($_POST['address'] ?? '');
$new_password     = trim($_POST['new_password'] ?? '');
$confirm_password = trim($_POST['confirm_password'] ?? '');

if (empty($name) || empty($mobile_number) || empty($address)) {
    header("Location: ../pages/dashboard.php?error=" . urlencode("Name, mobile number, and address are required."));
    exit();
}

// Check password match if changing password
if (!empty($new_password)) {
    if ($new_password !== $confirm_password) {
        header("Location: ../pages/dashboard.php?error=" . urlencode("New password and confirm password do not match."));
        exit();
    }
}

$safe_name          = mysqli_real_escape_string($conn, $name);
$safe_mobile_number = mysqli_real_escape_string($conn, $mobile_number);
$safe_address       = mysqli_real_escape_string($conn, $address);

// Check if mobile number belongs to another user
$checkMobile = mysqli_query($conn, "SELECT id FROM users WHERE mobile_number = '$safe_mobile_number' AND id != $user_id");
if ($checkMobile && mysqli_num_rows($checkMobile) > 0) {
    header("Location: ../pages/dashboard.php?error=" . urlencode("Mobile number is already in use by another account."));
    exit();
}

// Build update query
if (!empty($new_password)) {
    $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
    $safe_password   = mysqli_real_escape_string($conn, $hashed_password);
    $sql = "UPDATE users SET name = '$safe_name', mobile_number = '$safe_mobile_number', address = '$safe_address', password = '$safe_password' WHERE id = $user_id";
} else {
    $sql = "UPDATE users SET name = '$safe_name', mobile_number = '$safe_mobile_number', address = '$safe_address' WHERE id = $user_id";
}

if (mysqli_query($conn, $sql)) {
    // Update session variables
    $_SESSION['user_name']    = $name;
    $_SESSION['user_mobile']  = $mobile_number;
    $_SESSION['user_address'] = $address;

    header("Location: ../pages/dashboard.php?success=" . urlencode("Account details updated successfully!"));
    exit();
} else {
    header("Location: ../pages/dashboard.php?error=" . urlencode("Database error updating account details."));
    exit();
}
?>
