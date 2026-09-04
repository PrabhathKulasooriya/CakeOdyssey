<?php
// Controller: Checkout Cart Items & Place Customer Order
session_start();
require_once __DIR__ . '/../db.php';

if (empty($_SESSION['user_id'])) {
    header("Location: ../pages/login.php?error=" . urlencode("Please log in to confirm your order."));
    exit();
}

$user_id  = (int)$_SESSION['user_id'];
$due_date = trim($_POST['due_date'] ?? '');

// Require minimum 2 days notice for custom baking preparation
$min_due_date = date('Y-m-d', strtotime('+2 days'));
if (!$due_date || $due_date < $min_due_date) {
    header("Location: ../pages/cart.php?error=" . urlencode("Due date must be at least 2 days from today."));
    exit();
}

$result = mysqli_query($conn, "SELECT c.*, k.base_price FROM cart_items c JOIN cakes k ON c.cake_id = k.id WHERE c.user_id = $user_id");
if (!mysqli_num_rows($result)) {
    header("Location: ../pages/cart.php?error=" . urlencode("Your cart is empty!"));
    exit();
}

// Calculate grand total from cart item prices and quantities
$total_amount = 0.00;
$items = [];
while ($row = mysqli_fetch_assoc($result)) {
    $total_amount += $row['base_price'] * $row['quantity'] * $row['weight_kg'];
    $items[] = $row;
}

// Save order master record
if (mysqli_query($conn, "INSERT INTO orders (user_id, total_amount, due_date, status) VALUES ($user_id, $total_amount, '$due_date', 'pending')")) {
    $order_id = mysqli_insert_id($conn);

    // Save individual order items with price_locked snapshot
    foreach ($items as $item) {
        mysqli_query($conn, "INSERT INTO order_items (order_id, cake_id, quantity, weight_kg, price_locked) VALUES ($order_id, {$item['cake_id']}, {$item['quantity']}, {$item['weight_kg']}, {$item['base_price']})");
    }

    // Clear user's active cart after successful order creation
    mysqli_query($conn, "DELETE FROM cart_items WHERE user_id = $user_id");
    header("Location: ../pages/dashboard.php?success=" . urlencode("Order #$order_id placed successfully! Due Date: " . date('M d, Y', strtotime($due_date))));
    exit();
}

header("Location: ../pages/cart.php?error=" . urlencode("Failed to place order: " . mysqli_error($conn)));
exit();
?>
