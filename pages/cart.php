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
    <div style="background: #fdfbfb; min-height: 100vh; display: flex; flex-direction: column;">

        <!-- Include Navbar -->
        <?php include __DIR__ . '/../navbar.php'; ?>

        <div class="cart-page-container">
            
            <div class="cart-header">
                <h1 class="cart-title">Your Shopping Cart</h1>
                <p class="cart-subtitle">Review your selected handcrafted cakes before placing your order</p>
            </div>

            <?php if (!empty($success_message)): ?>
                <div style="background: #e6fffa; border: 1px solid #b2f5ea; color: #234e52; padding: 14px; border-radius: 12px; margin-bottom: 24px; display: flex; align-items: center; gap: 10px;">
                    <i class="fa-solid fa-circle-check" style="color: #319795; font-size: 1.1rem;"></i>
                    <span><?php echo htmlspecialchars($success_message); ?></span>
                </div>
            <?php endif; ?>

            <?php if (!empty($error_message)): ?>
                <div style="background: #fde8e8; border: 1px solid #f8b4b4; color: #9b1c1c; padding: 14px; border-radius: 12px; margin-bottom: 24px; display: flex; align-items: center; gap: 10px;">
                    <i class="fa-solid fa-circle-exclamation" style="font-size: 1.1rem;"></i>
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
                                                <div class="cart-item-icon" style="overflow: hidden;">
                                                    <?php if ($isIcon): ?>
                                                        <i class="fa-solid <?php echo htmlspecialchars($row['image']); ?>"></i>
                                                    <?php else: ?>
                                                        <img src="../assests/cake/<?php echo htmlspecialchars($row['image']); ?>" alt="Cake" style="width: 100%; height: 100%; object-fit: cover;">
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
                                            <span style="font-weight: 700; color: #b85b6c; font-size: 1.05rem;">
                                                <?php echo $row['quantity']; ?> <?php echo $isKilo ? 'KG' : ''; ?>
                                            </span>
                                        </td>
                                        <td>
                                            <span class="item-price">Rs. <?php echo number_format($itemSubtotal, 2); ?></span>
                                        </td>
                                        <td style="white-space: nowrap;">
                                            <?php if ($isKilo): ?>
                                                <a href="../controllers/cart_remove.php?id=<?php echo $row['id']; ?>&action=increase" style="display: inline-flex; align-items: center; gap: 4px; padding: 6px 10px; background: #9a5f6a; color: white; border-radius: 14px; font-size: 0.78rem; text-decoration: none; font-weight: 600; margin-right: 4px;">
                                                    <i class="fa-solid fa-plus"></i>
                                                </a>
                                                <a href="../controllers/cart_remove.php?id=<?php echo $row['id']; ?>&action=decrease" style="display: inline-flex; align-items: center; gap: 4px; padding: 6px 10px; background: #718096; color: white; border-radius: 14px; font-size: 0.78rem; text-decoration: none; font-weight: 600; margin-right: 6px;">
                                                    <i class="fa-solid fa-minus"></i>
                                                </a>
                                            <?php else: ?>
                                                <a href="../controllers/cart_remove.php?id=<?php echo $row['id']; ?>&action=increase" style="display: inline-flex; align-items: center; gap: 4px; padding: 6px 10px; background: #9a5f6a; color: white; border-radius: 14px; font-size: 0.78rem; text-decoration: none; font-weight: 600; margin-right: 4px;">
                                                    <i class="fa-solid fa-plus"></i>
                                                </a>
                                                <a href="../controllers/cart_remove.php?id=<?php echo $row['id']; ?>&action=decrease" style="display: inline-flex; align-items: center; gap: 4px; padding: 6px 10px; background: #718096; color: white; border-radius: 14px; font-size: 0.78rem; text-decoration: none; font-weight: 600; margin-right: 6px;">
                                                    <i class="fa-solid fa-minus"></i>
                                                </a>
                                            <?php endif; ?>
                                            
                                            <a href="../controllers/cart_remove.php?id=<?php echo $row['id']; ?>&action=delete" class="btn-remove" title="Remove Item" style="vertical-align: middle;">
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
                        <span style="color: #276749; font-weight: 600;">FREE</span>
                    </div>

                    <div class="summary-total">
                        <span>Total Amount:</span>
                        <span style="color: #b85b6c;">Rs. <?php echo number_format($total_amount, 2); ?></span>
                    </div>

                    <!-- Confirm Cart & Order Button -->
                    <form action="../controllers/order_confirm.php" method="POST">
                        <button type="submit" class="btn-confirm-order">
                            <i class="fa-solid fa-check-circle"></i> Confirm Cart & Place Order
                        </button>
                    </form>
                </div>
            </div>

        <?php else: ?>

            <div class="empty-cart-box">
                <i class="fa-solid fa-basket-shopping empty-cart-icon"></i>
                <h2 style="font-family: 'Playfair Display', serif; color: #2d1e1c; margin-bottom: 8px;">Your cart is currently empty</h2>
                <p style="color: #6b5350;">Explore our delicious collection of custom cakes and add your favorites to the cart!</p>
                <a href="cakes.php" class="btn-browse">Explore Our Cakes</a>
            </div>

        <?php endif; ?>

    </div>
</div>

</body>
</html>
