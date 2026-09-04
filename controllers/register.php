<?php
// Controller: Register New User Account
session_start();
require_once __DIR__ . '/../db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $address = trim($_POST['address'] ?? '');
    $mobile = trim($_POST['mobile'] ?? '');
    $password = trim($_POST['password'] ?? '');
    $confirm_password = trim($_POST['confirm_password'] ?? '');

    // Helper closure to preserve form inputs on redirect when validation fails
    $redirectWithError = function($msg) use ($name, $address, $mobile) {
        header("Location: ../pages/signup.php?error=" . urlencode($msg) . "&name=" . urlencode($name) . "&address=" . urlencode($address) . "&mobile=" . urlencode($mobile));
        exit();
    };

    if (empty($name) || empty($address) || empty($mobile) || empty($password)) {
        $redirectWithError("Please fill in all required fields!");
    }

    if ($password !== $confirm_password) {
        $redirectWithError("Passwords do not match!");
    }

    // Ensure mobile number is unique across all user accounts
    $safeMobile = mysqli_real_escape_string($conn, $mobile);
    $checkResult = mysqli_query($conn, "SELECT id FROM users WHERE mobile_number = '$safeMobile'");

    if (mysqli_num_rows($checkResult) > 0) {
        $redirectWithError("Mobile number is already registered!");
    }

    // Hash user password securely using PHP default password hashing (BCRYPT)
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    $safeName = mysqli_real_escape_string($conn, $name);
    $safeAddress = mysqli_real_escape_string($conn, $address);

    $insertSql = "INSERT INTO users (name, address, mobile_number, password, role) 
                  VALUES ('$safeName', '$safeAddress', '$safeMobile', '$hashedPassword', 'customer')";

    if (mysqli_query($conn, $insertSql)) {
        header("Location: ../pages/login.php?success=" . urlencode("Account created successfully! Please log in."));
        exit();
    }
    
    $redirectWithError("Database error: " . mysqli_error($conn));
}

header("Location: ../pages/signup.php");
exit();
?>
