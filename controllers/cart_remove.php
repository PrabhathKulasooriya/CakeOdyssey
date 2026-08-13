<?php
// Controller: Modify / Remove Item in Cart
session_start();
require_once __DIR__ . '/../db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../pages/login.php");
    exit();
}

$user_id  = (int)$_SESSION['user_id'];
$cart_id  = (int)($_GET['id'] ?? $_POST['id'] ?? 0);
$action   = $_GET['action'] ?? $_POST['action'] ?? 'delete';
$redirect = $_GET['redirect'] ?? $_POST['redirect'] ?? '';

if ($cart_id > 0) {
    // Query cart item with cake type
    $query = "SELECT c.id, c.quantity, k.cake_type 
              FROM cart_items c 
              JOIN cakes k ON c.cake_id = k.id 
              WHERE c.id = $cart_id AND c.user_id = $user_id";
    $result = mysqli_query($conn, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $currQty  = (int)$row['quantity'];
        $cakeType = $row['cake_type'];
        $maxLimit = ($cakeType === 'kilo') ? 10 : 5;

        if ($action === 'increase') {
            if ($currQty < $maxLimit) {
                mysqli_query($conn, "UPDATE cart_items SET quantity = quantity + 1 WHERE id = $cart_id AND user_id = $user_id");
            }
        } elseif ($action === 'decrease') {
            if ($currQty > 1) {
                mysqli_query($conn, "UPDATE cart_items SET quantity = quantity - 1 WHERE id = $cart_id AND user_id = $user_id");
            } else {
                mysqli_query($conn, "DELETE FROM cart_items WHERE id = $cart_id AND user_id = $user_id");
            }
        } else {
            mysqli_query($conn, "DELETE FROM cart_items WHERE id = $cart_id AND user_id = $user_id");
        }
    }
}

if ($redirect === 'cakes' || strpos($_SERVER['HTTP_REFERER'] ?? '', 'cakes.php') !== false) {
    header("Location: ../pages/cakes.php");
} else {
    header("Location: ../pages/cart.php");
}
exit();
?>
