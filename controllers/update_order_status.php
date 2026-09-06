<?php
// Controller: Admin Order Status Update
session_start();
require_once __DIR__ . '/../db.php';

// Enforce admin role authorization check
if (empty($_SESSION['user_id']) || ($_SESSION['user_role'] ?? '') !== 'admin') {
    header("Location: ../pages/login.php?error=" . urlencode("Unauthorized access! Admin login required."));
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $order_id = isset($_POST['order_id']) ? (int)$_POST['order_id'] : 0;
    $status   = isset($_POST['status']) ? trim($_POST['status']) : '';

    if ($order_id > 0 && !empty($status)) {
        $status_escaped = mysqli_real_escape_string($conn, $status);
        $sql = "UPDATE orders SET status = '$status_escaped' WHERE id = $order_id";

        if (mysqli_query($conn, $sql)) {
            header("Location: ../pages/dashboard.php?success=" . urlencode("Order #$order_id status updated to '$status'."));
            exit();
        } else {
            header("Location: ../pages/dashboard.php?error=" . urlencode("Failed to update status: " . mysqli_error($conn)));
            exit();
        }
    } else {
        header("Location: ../pages/dashboard.php?error=" . urlencode("Invalid order ID or status specified."));
        exit();
    }
}

header("Location: ../pages/dashboard.php");
exit();
?>
