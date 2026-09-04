<?php
// Controller: Modify / Remove Item in Cart
session_start();
require_once __DIR__ . '/../db.php';

if (empty($_SESSION['user_id'])) {
    header("Location: ../pages/login.php");
    exit();
}

$user_id  = (int)$_SESSION['user_id'];
$cart_id  = (int)($_REQUEST['id'] ?? 0);
$action   = $_REQUEST['action'] ?? 'delete';
$redirect = $_REQUEST['redirect'] ?? '';

if ($cart_id > 0) {
    $result = mysqli_query($conn, "SELECT c.id, c.quantity, k.cake_type FROM cart_items c JOIN cakes k ON c.cake_id = k.id WHERE c.id = $cart_id AND c.user_id = $user_id");
    if ($row = mysqli_fetch_assoc($result)) {
        $currQty  = (int)$row['quantity'];
        $maxLimit = ($row['cake_type'] === 'kilo') ? 10 : 5;

        if ($action === 'increase') {
            if ($currQty < $maxLimit) {
                mysqli_query($conn, "UPDATE cart_items SET quantity = quantity + 1 WHERE id = $cart_id");
            }
        } elseif ($action === 'decrease') {
            if ($currQty > 1) {
                mysqli_query($conn, "UPDATE cart_items SET quantity = quantity - 1 WHERE id = $cart_id");
            } else {
                mysqli_query($conn, "DELETE FROM cart_items WHERE id = $cart_id");
            }
        } else {
            mysqli_query($conn, "DELETE FROM cart_items WHERE id = $cart_id");
        }
    }
}

$target = ($redirect === 'cakes' || strpos($_SERVER['HTTP_REFERER'] ?? '', 'cakes.php') !== false) ? '../pages/cakes.php' : '../pages/cart.php';
header("Location: $target");
exit();
?>
