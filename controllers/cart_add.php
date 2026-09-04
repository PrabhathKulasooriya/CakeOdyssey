<?php
// Controller: Add Item to Cart
session_start();
require_once __DIR__ . '/../db.php';

// Require customer authentication
if (empty($_SESSION['user_id'])) {
    header("Location: ../pages/login.php?error=" . urlencode("Please log in to add items to your cart."));
    exit();
}

$user_id = (int)$_SESSION['user_id'];
$cake_id = (int)($_REQUEST['cake_id'] ?? 0);
$reqQty  = (int)($_REQUEST['quantity'] ?? 1);

if ($cake_id > 0) {
    $cakeQuery = mysqli_query($conn, "SELECT id, name, cake_type FROM cakes WHERE id = $cake_id");
    if ($cake = mysqli_fetch_assoc($cakeQuery)) {
        $type = $cake['cake_type'];
        
        // Apply maximum allowed quantity limits (10 KG for kilo cakes, 5 items for custom cakes)
        $maxLimit = ($type === 'kilo') ? 10 : 5;
        $reqQty = max(1, min($reqQty, $maxLimit));

        // Increment existing cart item quantity or insert new cart entry
        $check = mysqli_query($conn, "SELECT id, quantity FROM cart_items WHERE user_id = $user_id AND cake_id = $cake_id");
        if ($item = mysqli_fetch_assoc($check)) {
            $newQty = min($item['quantity'] + $reqQty, $maxLimit);
            mysqli_query($conn, "UPDATE cart_items SET quantity = $newQty WHERE id = " . $item['id']);
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
