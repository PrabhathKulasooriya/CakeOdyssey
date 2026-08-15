<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once __DIR__ . '/../db.php';

// User must be logged in to view cart
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php?error=" . urlencode("Please log in to view your cart."));
    exit();
}

$user_id = (int)$_SESSION['user_id'];
$success_message = $_GET['success'] ?? '';
$error_message = $_GET['error'] ?? '';

// Fetch user's cart items
$sql = "SELECT c.*, k.name, k.cake_type, k.size, k.image, k.description, k.base_price 
        FROM cart_items c 
        JOIN cakes k ON c.cake_id = k.id 
        WHERE c.user_id = $user_id 
        ORDER BY c.id DESC";
$cart_result = mysqli_query($conn, $sql);

$total_amount = 0.00;
$cart_count = 0;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopping Cart - Cake Odyssey</title>
    <!-- Local Fonts & Icons -->
    <link rel="stylesheet" href="../css/fonts.css">
    <link rel="stylesheet" href="../css/all.min.css">
    <link rel="stylesheet" href="../css/navbar.css">
    <link rel="stylesheet" href="../css/cart.css">
</head>
<body>

    <!-- Cart Page Wrapper -->
    <div class="cart-page-wrapper">

        <!-- Include Navbar -->
        <?php include __DIR__ . '/../navbar.php'; ?>

        <div class="cart-page-container">
            
            <div class="cart-header">
                <h1 class="cart-title">Your Shopping Cart</h1>
                <p class="cart-subtitle">Review your selected handcrafted cakes before placing your order</p>
            </div>

            <?php if (!empty($success_message)): ?>
                <div class="cart-alert alert-success">
                    <i class="fa-solid fa-circle-check"></i>
                    <span><?php echo htmlspecialchars($success_message); ?></span>
                </div>
            <?php endif; ?>

            <?php if (!empty($error_message)): ?>
                <div class="cart-alert alert-error">
                    <i class="fa-solid fa-circle-exclamation"></i>
                    <span><?php echo htmlspecialchars($error_message); ?></span>
                </div>
            <?php endif; ?>

            <?php if ($cart_result && mysqli_num_rows($cart_result) > 0): ?>
                
                <div class="cart-layout">
                    <!-- Cart Items Table -->
                    <div class="cart-items-card">
                        <table class="cart-table">
                            <thead>
                                <tr>
                                    <th>Cake Item</th>
                                    <th>Price</th>
                                    <th>Quantity</th>
                                    <th>Subtotal</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                while ($row = mysqli_fetch_assoc($cart_result)): 
                                    $itemSubtotal = $row['base_price'] * $row['quantity'] * $row['weight_kg'];
                                    $total_amount += $itemSubtotal;
                                    $cart_count += $row['quantity'];
                                    $isIcon = !empty($row['image']) && strpos($row['image'], 'fa-') === 0;
                                    $isKilo = ($row['cake_type'] === 'kilo');
                                ?>
                                    <tr>
                                        <td>
                                            <div class="cart-item-info">
                                                <div class="cart-item-icon">
                                                    <?php if ($isIcon): ?>
                                                        <i class="fa-solid <?php echo htmlspecialchars($row['image']); ?>"></i>
                                                    <?php else: ?>
                                                        <img src="../assests/cake/<?php echo htmlspecialchars($row['image']); ?>" alt="Cake">
                                                    <?php endif; ?>
                                                </div>
                                                <div>
                                                    <div class="cart-item-name"><?php echo htmlspecialchars($row['name']); ?></div>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            Rs. <?php echo number_format($row['base_price'], 2); ?>
                                        </td>
                                        <td>
                                            <span class="cart-item-qty">
                                                <?php echo $row['quantity']; ?> <?php echo $isKilo ? 'KG' : ''; ?>
                                            </span>
                                        </td>
                                        <td>
                                            <span class="item-price">Rs. <?php echo number_format($itemSubtotal, 2); ?></span>
                                        </td>
                                        <td class="cart-action-td">
                                            <?php if ($isKilo): ?>
                                                <a href="../controllers/cart_remove.php?id=<?php echo $row['id']; ?>&action=increase" class="btn-cart-action btn-cart-inc">
                                                    <i class="fa-solid fa-plus"></i>
                                                </a>
                                                <a href="../controllers/cart_remove.php?id=<?php echo $row['id']; ?>&action=decrease" class="btn-cart-action btn-cart-dec">
                                                    <i class="fa-solid fa-minus"></i>
                                                </a>
                                            <?php else: ?>
                                                <a href="../controllers/cart_remove.php?id=<?php echo $row['id']; ?>&action=increase" class="btn-cart-action btn-cart-inc">
                                                    <i class="fa-solid fa-plus"></i>
                                                </a>
                                                <a href="../controllers/cart_remove.php?id=<?php echo $row['id']; ?>&action=decrease" class="btn-cart-action btn-cart-dec">
                                                    <i class="fa-solid fa-minus"></i>
                                                </a>
                                            <?php endif; ?>
                                            
                                            <a href="../controllers/cart_remove.php?id=<?php echo $row['id']; ?>&action=delete" class="btn-remove" title="Remove Item">
                                                <i class="fa-solid fa-trash-can"></i>
                                            </a>
                                        </td>
                                    </tr>
                                <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>

                <!-- Order Summary Sidebar -->
                <div class="summary-card">
                    <h2 class="summary-title">Order Summary</h2>
                    
                    <div class="summary-row">
                        <span>Items Count:</span>
                        <span><strong><?php echo $cart_count; ?></strong></span>
                    </div>
                    
                    <div class="summary-row">
                        <span>Subtotal:</span>
                        <span>Rs. <?php echo number_format($total_amount, 2); ?></span>
                    </div>

                    <div class="summary-row">
                        <span>Islandwide Delivery:</span>
                        <span class="free-delivery-badge">FREE</span>
                    </div>

                    <div class="summary-total">
                        <span>Total Amount:</span>
                        <span class="summary-total-price">Rs. <?php echo number_format($total_amount, 2); ?></span>
                    </div>

                    <!-- Confirm Cart & Order Form with Required Due Date -->
                    <form action="../controllers/order_confirm.php" method="POST" class="order-form">
                        <div class="due-date-group">
                            <label class="due-date-label">
                                <i class="fa-solid fa-calendar-day"></i> Select Required Due Date * (Min. 2 days ahead)
                            </label>
                            <input type="date" name="due_date" min="<?php echo date('Y-m-d', strtotime('+2 days')); ?>" value="<?php echo date('Y-m-d', strtotime('+2 days')); ?>" required class="due-date-input">
                        </div>

                        <button type="submit" class="btn-confirm-order">
                            <i class="fa-solid fa-check-circle"></i> Confirm Cart & Place Order
                        </button>
                    </form>
                </div>
            </div>

        <?php else: ?>

            <div class="empty-cart-box">
                <i class="fa-solid fa-basket-shopping empty-cart-icon"></i>
                <h2 class="empty-cart-title">Your cart is currently empty</h2>
                <p class="empty-cart-text">Explore our delicious collection of custom cakes and add your favorites to the cart!</p>
                <a href="cakes.php" class="btn-browse">Explore Our Cakes</a>
            </div>

        <?php endif; ?>

    </div>
</div>

</body>
</html>
