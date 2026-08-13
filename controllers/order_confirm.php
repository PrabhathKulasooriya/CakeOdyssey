<?php
// Controller: Confirm Cart & Place Order (with Due Date)
session_start();
require_once __DIR__ . '/../db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../pages/login.php?error=" . urlencode("Please log in to confirm your order."));
    exit();
}

$user_id  = (int)$_SESSION['user_id'];
$due_date = trim($_POST['due_date'] ?? '');

if (empty($due_date)) {
    $due_date = date('Y-m-d', strtotime('+1 day'));
}

// Fetch cart items for current user
$sql = "SELECT c.*, k.base_price 
        FROM cart_items c 
        JOIN cakes k ON c.cake_id = k.id 
        WHERE c.user_id = $user_id";
$result = mysqli_query($conn, $sql);

if (!$result || mysqli_num_rows($result) === 0) {
    header("Location: ../pages/cart.php?error=" . urlencode("Your cart is empty!"));
    exit();
}

// Calculate total amount
$total_amount = 0.00;
$items = [];
while ($row = mysqli_fetch_assoc($result)) {
    $itemTotal = $row['base_price'] * $row['quantity'] * $row['weight_kg'];
    $total_amount += $itemTotal;
    $items[] = $row;
}

// Create Order record in database with due_date
$insertOrderSql = "INSERT INTO orders (user_id, total_amount, due_date, status) VALUES ($user_id, $total_amount, '$due_date', 'pending')";

if (mysqli_query($conn, $insertOrderSql)) {
    $order_id = mysqli_insert_id($conn);

    // Insert each order item
    foreach ($items as $item) {
        $cake_id = (int)$item['cake_id'];
        $qty     = (int)$item['quantity'];
        $weight  = (float)$item['weight_kg'];
        $price   = (float)$item['base_price'];

        $insertItemSql = "INSERT INTO order_items (order_id, cake_id, quantity, weight_kg, price_locked) 
                          VALUES ($order_id, $cake_id, $qty, $weight, $price)";
        mysqli_query($conn, $insertItemSql);
    }

    // Clear cart items for this user
    mysqli_query($conn, "DELETE FROM cart_items WHERE user_id = $user_id");

    header("Location: ../pages/dashboard.php?success=" . urlencode("Order #$order_id placed successfully! Due Date: " . date('M d, Y', strtotime($due_date))));
    exit();
} else {
    header("Location: ../pages/cart.php?error=" . urlencode("Failed to place order: " . mysqli_error($conn)));
    exit();
}
?>
