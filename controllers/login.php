<?php
// Controller: User Login
session_start();
require_once __DIR__ . '/../db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $mobile = trim($_POST['mobile'] ?? '');
    $password = trim($_POST['password'] ?? '');

    // 1. Validation
    if (empty($mobile) || empty($password)) {
        header("Location: ../pages/login.php?error=" . urlencode("Please enter your mobile number and password!") . "&mobile=" . urlencode($mobile));
        exit();
    }

    // 2. Query user record
    $sql = "SELECT * FROM users WHERE mobile_number = '$mobile' AND password = '$password'";
    $result = mysqli_query($conn, $sql);

    if ($result && mysqli_num_rows($result) > 0) {
        $user = mysqli_fetch_assoc($result);

        // 3. Save user info in session
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_name'] = $user['name'];
        $_SESSION['user_mobile'] = $user['mobile_number'];
        $_SESSION['user_role'] = $user['role'];

        header("Location: ../index.php");
        exit();
    } else {
        header("Location: ../pages/login.php?error=" . urlencode("Invalid mobile number or password!") . "&mobile=" . urlencode($mobile));
        exit();
    }
} else {
    header("Location: ../pages/login.php");
    exit();
}
?>
