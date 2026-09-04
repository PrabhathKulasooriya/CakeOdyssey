<?php
// Controller: Add Item to Cart (Stay on Cakes page)
session_start();
require_once __DIR__ . '/../db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../pages/login.php?error=" . urlencode("Please log in to add items to your cart."));
    exit();
}

$user_id = (int)$_SESSION['user_id'];
$cake_id = (int)($_POST['cake_id'] ?? $_GET['cake_id'] ?? 0);
$reqQty  = (int)($_POST['quantity'] ?? 1);

if ($cake_id > 0) {
    // Fetch cake details
    $cakeQuery = mysqli_query($conn, "SELECT id, name, cake_type FROM cakes WHERE id = $cake_id");

    if ($cakeQuery && mysqli_num_rows($cakeQuery) > 0) {
        $cake = mysqli_fetch_assoc($cakeQuery);
        $type = $cake['cake_type'];
        $maxLimit = ($type === 'kilo') ? 10 : 5;

        // Ensure requested quantity is within 1 to maxLimit
        $reqQty = max(1, min($reqQty, $maxLimit));

        // Check if item is already in user's cart
        $check = mysqli_query($conn, "SELECT id, quantity FROM cart_items WHERE user_id = $user_id AND cake_id = $cake_id");

        if ($check && mysqli_num_rows($check) > 0) {
            $item = mysqli_fetch_assoc($check);
            $newQty = min($item['quantity'] + $reqQty, $maxLimit);
            $sql = "UPDATE cart_items SET quantity = $newQty WHERE id = " . $item['id'];
            mysqli_query($conn, $sql);
        } else {
            mysqli_query($conn, "INSERT INTO cart_items (user_id, cake_id, quantity, weight_kg) VALUES ($user_id, $cake_id, $reqQty, 1.00)");
        }

        $unitLabel = ($type === 'kilo') ? "KG" : "item(s)";
        header("Location: ../pages/cakes.php?success=" . urlencode("{$cake['name']} ($reqQty $unitLabel) added to cart!"));
        exit();
    }
}

header("Location: ../pages/cakes.php");
exit();
?>
