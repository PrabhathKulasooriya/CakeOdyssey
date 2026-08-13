<?php
// Controller: Register New User
session_start();
require_once __DIR__ . '/../db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $address = trim($_POST['address'] ?? '');
    $mobile = trim($_POST['mobile'] ?? '');
    $password = trim($_POST['password'] ?? '');
    $confirm_password = trim($_POST['confirm_password'] ?? '');

    // Helper to build redirect URL with retained input values
    $redirectWithError = function($msg) use ($name, $address, $mobile) {
        $url = "../pages/signup.php?error=" . urlencode($msg)
             . "&name=" . urlencode($name)
             . "&address=" . urlencode($address)
             . "&mobile=" . urlencode($mobile);
        header("Location: " . $url);
        exit();
    };

    // 1. Validation
    if (empty($name) || empty($address) || empty($mobile) || empty($password)) {
        $redirectWithError("Please fill in all required fields!");
    }

    if ($password !== $confirm_password) {
        $redirectWithError("Passwords do not match!");
    }

    // 2. Check if mobile number is already registered
    $checkSql = "SELECT * FROM users WHERE mobile_number = '$mobile'";
    $checkResult = mysqli_query($conn, $checkSql);

    if ($checkResult && mysqli_num_rows($checkResult) > 0) {
        $redirectWithError("Mobile number is already registered!");
    }

    // 3. Insert user into database
    $insertSql = "INSERT INTO users (name, address, mobile_number, password, role) 
                  VALUES ('$name', '$address', '$mobile', '$password', 'customer')";

    if (mysqli_query($conn, $insertSql)) {
        header("Location: ../pages/login.php?success=" . urlencode("Account created successfully! Please log in."));
        exit();
    } else {
        $redirectWithError("Database error: " . mysqli_error($conn));
    }
} else {
    header("Location: ../pages/signup.php");
    exit();
}
?>
