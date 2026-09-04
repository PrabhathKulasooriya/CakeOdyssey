<?php
// Controller: User Login & Session Authentication
session_start();
require_once __DIR__ . '/../db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $mobile = trim($_POST['mobile'] ?? '');
    $password = trim($_POST['password'] ?? '');

    if (empty($mobile) || empty($password)) {
        header("Location: ../pages/login.php?error=" . urlencode("Please enter your mobile number and password!") . "&mobile=" . urlencode($mobile));
        exit();
    }

    // Lookup user by unique mobile number
    $safeMobile = mysqli_real_escape_string($conn, $mobile);
    $result = mysqli_query($conn, "SELECT * FROM users WHERE mobile_number = '$safeMobile'");

    if ($user = mysqli_fetch_assoc($result)) {
        // Authenticate password against hashed hash stored in database
        if (password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['name'];
            $_SESSION['user_mobile'] = $user['mobile_number'];
            $_SESSION['user_role'] = $user['role'];

            header("Location: ../index.php");
            exit();
        }
    }

    header("Location: ../pages/login.php?error=" . urlencode("Invalid mobile number or password!") . "&mobile=" . urlencode($mobile));
    exit();
}

header("Location: ../pages/login.php");
exit();
?>
