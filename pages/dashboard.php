<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once __DIR__ . '/../db.php';

// Require login
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php?error=" . urlencode("Please log in to access your dashboard."));
    exit();
}

$user_id = (int)$_SESSION['user_id'];
$user_name = $_SESSION['user_name'] ?? 'User';
$user_role = $_SESSION['user_role'] ?? 'customer';

$success_message = $_GET['success'] ?? '';
$error_message = $_GET['error'] ?? '';

// Fetch user profile details
$userRes = mysqli_query($conn, "SELECT * FROM users WHERE id = $user_id");
$userProfile = mysqli_fetch_assoc($userRes);

// Edit Cake Modal Data if editing
$editCake = null;
if (isset($_GET['edit_id']) && $user_role === 'admin') {
    $edit_id = (int)$_GET['edit_id'];
    $editRes = mysqli_query($conn, "SELECT * FROM cakes WHERE id = $edit_id");
    if ($editRes && mysqli_num_rows($editRes) > 0) {
        $editCake = mysqli_fetch_assoc($editRes);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Cake Odyssey</title>

    <link rel="stylesheet" href="../css/fonts.css">
    <link rel="stylesheet" href="../css/all.min.css">
    <link rel="stylesheet" href="../css/navbar.css">
    <link rel="stylesheet" href="../css/dashboard.css">
</head>
<body>

    <!-- Dashboard Hero Page Wrapper -->
    <div style="background: #fdfbfb; min-height: 100vh; display: flex; flex-direction: column;">

        <!-- Include Navbar -->
        <?php include __DIR__ . '/../navbar.php'; ?>

        <div class="dashboard-container">
            
            <div class="dashboard-header">
                <div>
                    <h1 class="dash-title">Welcome, <?php echo htmlspecialchars($user_name); ?>!</h1>
                    <p style="color: #6b5350;">Manage your account details and view your orders</p>
                </div>
                
            </div>

            <?php if (!empty($success_message)): ?>
                <div class="alert-box alert-success">
                    <i class="fa-solid fa-circle-check"></i>
                    <span><?php echo htmlspecialchars($success_message); ?></span>
                </div>
            <?php endif; ?>

            <?php if (!empty($error_message)): ?>
                <div class="alert-box alert-error">
                    <i class="fa-solid fa-circle-exclamation"></i>
                    <span><?php echo htmlspecialchars($error_message); ?></span>
                </div>
            <?php endif; ?>

            <!-- Profile Information -->
            <div class="dash-card">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 18px; padding-bottom: 10px; border-bottom: 1px solid rgba(184, 91, 108, 0.12); flex-wrap: wrap; gap: 12px;">
                    <h2 class="card-title" style="margin: 0; border: none; padding: 0;">
                        <i class="fa-solid fa-id-card" style="color: #b85b6c;"></i> Profile Information
                    </h2>
                    <a href="#editProfileModal" class="btn-dash-action" style="padding: 6px 16px; font-size: 0.82rem; text-decoration: none;">
                        <i class="fa-solid fa-user-pen"></i> Edit Account Details
                    </a>
                </div>
                <div class="profile-grid">
                    <div class="profile-item">
                        <div class="profile-label">Full Name</div>
                        <div class="profile-val"><?php echo htmlspecialchars($userProfile['name'] ?? $user_name); ?></div>
                    </div>
                    <div class="profile-item">
                        <div class="profile-label">Mobile Number</div>
                        <div class="profile-val"><?php echo htmlspecialchars($userProfile['mobile_number'] ?? ''); ?></div>
                    </div>
                    <div class="profile-item">
                        <div class="profile-label">Delivery Address</div>
                        <div class="profile-val"><?php echo htmlspecialchars($userProfile['address'] ?? ''); ?></div>
                    </div>
                    <div class="profile-item">
                        <div class="profile-label">Member Since</div>
                        <div class="profile-val"><?php echo date('M d, Y', strtotime($userProfile['created_at'] ?? 'now')); ?></div>
                    </div>
                </div>
            </div>


            <?php if ($user_role === 'admin'): ?>
                
                <!-- ================= ADMIN SECTION ================= -->
                
                <!-- Manage Cakes Table -->
                <div class="dash-card">
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 16px;">
                        <h2 class="card-title" style="margin: 0; border: none; padding: 0;"><i class="fa-solid fa-cake-candles" style="color: #b85b6c;"></i> Cake Catalog Management</h2>
                        <a href="#addCakeModal" class="btn-dash-action">
                            <i class="fa-solid fa-plus-circle"></i> Add New Cake
                        </a>
                    </div>
                    
                    <?php
                    $allCakes = mysqli_query($conn, "SELECT * FROM cakes ORDER BY id DESC");
                    if ($allCakes && mysqli_num_rows($allCakes) > 0):
                    ?>
                        <div style="overflow-x: auto;">
                            <table class="order-table">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Image</th>
                                        <th>Name</th>
                                        <th>Type</th>
                                        <th>Size</th>
                                        <th>Price</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php while ($c = mysqli_fetch_assoc($allCakes)): ?>
                                        <tr>
                                            <td>#<?php echo $c['id']; ?></td>
                                            <td>
                                                <?php if (!empty($c['image']) && strpos($c['image'], 'fa-') === 0): ?>
                                                    <i class="fa-solid <?php echo htmlspecialchars($c['image']); ?>" style="color: #b85b6c; font-size: 1.4rem;"></i>
                                                <?php else: ?>
                                                    <img src="../assests/cake/<?php echo htmlspecialchars($c['image']); ?>" alt="Cake" style="width: 44px; height: 44px; border-radius: 8px; object-fit: cover; border: 1px solid rgba(184, 91, 108, 0.2);">
                                                <?php endif; ?>
                                            </td>
                                            <td><strong><?php echo htmlspecialchars($c['name']); ?></strong></td>
                                            <td><?php echo ucfirst(htmlspecialchars($c['cake_type'])); ?></td>
                                            <td><?php echo htmlspecialchars($c['size']); ?></td>
                                            <td>Rs. <?php echo number_format($c['base_price'], 2); ?></td>
                                            <td>
                                                <a href="dashboard.php?edit_id=<?php echo $c['id']; ?>#editCakeModal" class="btn-dash-action btn-edit" style="padding: 6px 12px; font-size: 0.78rem; text-decoration: none;">
                                                    <i class="fa-solid fa-pen"></i> Edit
                                                </a>
                                                <a href="../controllers/admin_cake.php?action=delete&id=<?php echo $c['id']; ?>" onclick="return confirm('Are you sure you want to delete this cake?');" class="btn-dash-action btn-delete" style="padding: 6px 12px; font-size: 0.78rem; text-decoration: none;">
                                                    <i class="fa-solid fa-trash"></i> Delete
                                                </a>
                                            </td>
                                        </tr>
                                    <?php endwhile; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php else: ?>
                        <p style="color: #6b5350;">No cakes currently in database.</p>
                    <?php endif; ?>
                </div>

                <!-- Admin: View All Customer Orders -->
                <div class="dash-card">
                    <h2 class="card-title"><i class="fa-solid fa-boxes-packing" style="color: #b85b6c;"></i> All Customer Orders</h2>
                    
                    <?php
                    $adminOrdersSql = "SELECT o.*, u.name as customer_name, u.mobile_number 
                                       FROM orders o 
                                       JOIN users u ON o.user_id = u.id 
                                       ORDER BY o.id DESC";
                    $adminOrders = mysqli_query($conn, $adminOrdersSql);
                    
                    if ($adminOrders && mysqli_num_rows($adminOrders) > 0):
                    ?>
                        <div style="overflow-x: auto;">
                            <table class="order-table">
                                <thead>
                                    <tr>
                                        <th>Order #</th>
                                        <th>Customer</th>
                                        <th>Mobile</th>
                                        <th>Date</th>
                                        <th>Total</th>
                                        <th>Status</th>
                                        <th>Items Ordered</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php while ($ord = mysqli_fetch_assoc($adminOrders)): ?>
                                        <tr>
                                            <td><strong>#<?php echo $ord['id']; ?></strong></td>
                                            <td><?php echo htmlspecialchars($ord['customer_name']); ?></td>
                                            <td><?php echo htmlspecialchars($ord['mobile_number']); ?></td>
                                            <td><?php echo date('M d, Y H:i', strtotime($ord['created_at'])); ?></td>
                                            <td><strong style="color: #b85b6c;">Rs. <?php echo number_format($ord['total_amount'], 0); ?></strong></td>
                                            <td>
                                                <span class="status-badge status-<?php echo strtolower($ord['status']); ?>">
                                                    <?php echo ucfirst($ord['status']); ?>
                                                </span>
                                            </td>
                                            <td>
                                                <?php
                                                $oid = $ord['id'];
                                                $itemsRes = mysqli_query($conn, "SELECT oi.*, k.name FROM order_items oi LEFT JOIN cakes k ON oi.cake_id = k.id WHERE oi.order_id = $oid");
                                                while ($item = mysqli_fetch_assoc($itemsRes)) {
                                                    $cakeName = $item['name'] ?? 'Custom Cake';
                                                    echo "<span class='order-item-chip'>$cakeName x{$item['quantity']}</span>";
                                                }
                                                ?>
                                            </td>
                                        </tr>
                                    <?php endwhile; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php else: ?>
                        <p style="color: #6b5350;">No customer orders placed yet.</p>
                    <?php endif; ?>
                </div>

            <?php else: ?>

                <!-- ================= CUSTOMER SECTION ================= -->
                
                <div class="dash-card">
                    <h2 class="card-title"><i class="fa-solid fa-clock-rotate-left" style="color: #b85b6c;"></i> Your Order History</h2>
                    
                    <?php
                    $userOrdersSql = "SELECT * FROM orders WHERE user_id = $user_id ORDER BY id DESC";
                    $userOrders = mysqli_query($conn, $userOrdersSql);
                    
                    if ($userOrders && mysqli_num_rows($userOrders) > 0):
                    ?>
                        <div style="overflow-x: auto;">
                            <table class="order-table">
                                <thead>
                                    <tr>
                                        <th>Order #</th>
                                        <th>Date</th>
                                        <th>Total Amount</th>
                                        <th>Status</th>
                                        <th>Items Included</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php while ($ord = mysqli_fetch_assoc($userOrders)): ?>
                                        <tr>
                                            <td><strong>#<?php echo $ord['id']; ?></strong></td>
                                            <td><?php echo date('M d, Y - h:i A', strtotime($ord['created_at'])); ?></td>
                                            <td><strong style="color: #b85b6c;">Rs. <?php echo number_format($ord['total_amount'], 0); ?></strong></td>
                                            <td>
                                                <span class="status-badge status-<?php echo strtolower($ord['status']); ?>">
                                                    <?php echo ucfirst($ord['status']); ?>
                                                </span>
                                            </td>
                                            <td>
                                                <?php
                                                $oid = $ord['id'];
                                                $itemsRes = mysqli_query($conn, "SELECT oi.*, k.name FROM order_items oi LEFT JOIN cakes k ON oi.cake_id = k.id WHERE oi.order_id = $oid");
                                                while ($item = mysqli_fetch_assoc($itemsRes)) {
                                                    $cakeName = $item['name'] ?? 'Cake Item';
                                                    echo "<span class='order-item-chip'><i class='fa-solid fa-cake-candles'></i> $cakeName x{$item['quantity']}</span>";
                                                }
                                                ?>
                                            </td>
                                        </tr>
                                    <?php endwhile; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php else: ?>
                        <div style="text-align: center; padding: 40px 20px;">
                            <i class="fa-solid fa-receipt" style="font-size: 3rem; color: #b85b6c; opacity: 0.5; margin-bottom: 12px;"></i>
                            <p style="color: #6b5350; font-size: 1rem;">You haven't placed any orders yet!</p>
                            <a href="cakes.php" class="btn-dash-action" style="margin-top: 16px;">Browse Our Cakes & Order Now</a>
                        </div>
                    <?php endif; ?>
                </div>

            <?php endif; ?>

        </div>
    </div>

    <?php if ($user_role === 'admin'): ?>
        <!-- ADD CAKE MODAL (Pure CSS :target) -->
        <div id="addCakeModal" class="modal-overlay">
            <div class="modal-card">
                <div class="modal-header">
                    <h2 class="modal-title"><i class="fa-solid fa-plus-circle" style="color: #b85b6c;"></i> Add New Cake to Menu</h2>
                    <a href="dashboard.php" class="btn-close-modal" style="text-decoration: none;">&times;</a>
                </div>
                <form action="../controllers/admin_cake.php" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="action" value="add">
                    <div style="display: flex; flex-direction: column; gap: 14px;">
                        <div>
                            <label style="font-size: 0.82rem; font-weight: 600; color: #2d1e1c;">Cake Name *</label>
                            <input type="text" name="name" class="form-control-dash" placeholder="e.g. Red Velvet Dream" required>
                        </div>
                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 14px;">
                            <div>
                                <label style="font-size: 0.82rem; font-weight: 600; color: #2d1e1c;">Type *</label>
                                <select name="cake_type" class="form-control-dash">
                                    <option value="kilo">Kilo Cake</option>
                                    <option value="custom">Custom Design</option>
                                </select>
                            </div>
                            <div>
                                <label style="font-size: 0.82rem; font-weight: 600; color: #2d1e1c;">Size / Portion *</label>
                                <input type="text" name="size" class="form-control-dash" placeholder="e.g. 1 KG or Medium" value="1 KG" required>
                            </div>
                        </div>
                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 14px;">
                            <div>
                                <label style="font-size: 0.82rem; font-weight: 600; color: #2d1e1c;">Base Price (Rs.) *</label>
                                <input type="number" step="100" name="base_price" class="form-control-dash" placeholder="4500" required>
                            </div>
                            <div>
                                <label style="font-size: 0.82rem; font-weight: 600; color: #2d1e1c;">Upload Image (Saved to assests/cake)</label>
                                <input type="file" name="cake_image" accept="image/*" class="form-control-dash" style="padding: 6px 10px;">
                            </div>
                        </div>
                        <div>
                            <label style="font-size: 0.82rem; font-weight: 600; color: #2d1e1c;">Description</label>
                            <input type="text" name="description" class="form-control-dash" placeholder="Brief description of ingredients and flavors">
                        </div>
                        <div style="display: flex; justify-content: flex-end; gap: 12px; margin-top: 10px;">
                            <a href="dashboard.php" class="btn-dash-action" style="background: #718096; text-decoration: none;">Cancel</a>
                            <button type="submit" class="btn-dash-action"><i class="fa-solid fa-plus"></i> Add Cake</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- EDIT CAKE MODAL (Pure CSS :target + PHP Pre-fill) -->
        <div id="editCakeModal" class="modal-overlay <?php echo $editCake ? 'active' : ''; ?>">
            <div class="modal-card">
                <div class="modal-header">
                    <h2 class="modal-title"><i class="fa-solid fa-pen-to-square" style="color: #b85b6c;"></i> Edit Cake Details</h2>
                    <a href="dashboard.php" class="btn-close-modal" style="text-decoration: none;">&times;</a>
                </div>
                <form action="../controllers/admin_cake.php" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="action" value="edit">
                    <input type="hidden" name="id" value="<?php echo $editCake['id'] ?? ''; ?>">
                    <div style="display: flex; flex-direction: column; gap: 14px;">
                        <div>
                            <label style="font-size: 0.82rem; font-weight: 600; color: #2d1e1c;">Cake Name *</label>
                            <input type="text" name="name" class="form-control-dash" value="<?php echo htmlspecialchars($editCake['name'] ?? ''); ?>" required>
                        </div>
                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 14px;">
                            <div>
                                <label style="font-size: 0.82rem; font-weight: 600; color: #2d1e1c;">Type *</label>
                                <select name="cake_type" class="form-control-dash">
                                    <option value="kilo" <?php echo (($editCake['cake_type'] ?? '') === 'kilo') ? 'selected' : ''; ?>>Kilo Cake</option>
                                    <option value="custom" <?php echo (($editCake['cake_type'] ?? '') === 'custom') ? 'selected' : ''; ?>>Custom Design</option>
                                </select>
                            </div>
                            <div>
                                <label style="font-size: 0.82rem; font-weight: 600; color: #2d1e1c;">Size / Portion *</label>
                                <input type="text" name="size" class="form-control-dash" value="<?php echo htmlspecialchars($editCake['size'] ?? ''); ?>" required>
                            </div>
                        </div>
                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 14px;">
                            <div>
                                <label style="font-size: 0.82rem; font-weight: 600; color: #2d1e1c;">Base Price (Rs.) *</label>
                                <input type="number" step="100" name="base_price" class="form-control-dash" value="<?php echo htmlspecialchars($editCake['base_price'] ?? ''); ?>" required>
                            </div>
                            <div>
                                <label style="font-size: 0.82rem; font-weight: 600; color: #2d1e1c;">Change Image (Optional)</label>
                                <input type="file" name="cake_image" accept="image/*" class="form-control-dash" style="padding: 6px 10px;">
                            </div>
                        </div>
                        <div>
                            <label style="font-size: 0.82rem; font-weight: 600; color: #2d1e1c;">Description</label>
                            <input type="text" name="description" class="form-control-dash" value="<?php echo htmlspecialchars($editCake['description'] ?? ''); ?>">
                        </div>
                        <div style="display: flex; justify-content: flex-end; gap: 12px; margin-top: 10px;">
                            <a href="dashboard.php" class="btn-dash-action" style="background: #718096; text-decoration: none;">Cancel</a>
                            <button type="submit" class="btn-dash-action"><i class="fa-solid fa-pen-to-square"></i> Save Changes</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    <?php endif; ?>

    <!-- EDIT PROFILE MODAL (Pure CSS :target) -->
    <div id="editProfileModal" class="modal-overlay">
        <div class="modal-card">
            <div class="modal-header">
                <h2 class="modal-title"><i class="fa-solid fa-user-pen" style="color: #b85b6c;"></i> Update Account Details</h2>
                <a href="dashboard.php" class="btn-close-modal" style="text-decoration: none;">&times;</a>
            </div>
            <form action="../controllers/profile_update.php" method="POST">
                <div style="display: flex; flex-direction: column; gap: 14px;">
                    <div>
                        <label style="font-size: 0.82rem; font-weight: 600; color: #2d1e1c; display: block; margin-bottom: 4px;">Full Name *</label>
                        <input type="text" name="name" class="form-control-dash" value="<?php echo htmlspecialchars($userProfile['name'] ?? $user_name); ?>" required>
                    </div>
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 14px;">
                        <div>
                            <label style="font-size: 0.82rem; font-weight: 600; color: #2d1e1c; display: block; margin-bottom: 4px;">Mobile Number *</label>
                            <input type="text" name="mobile_number" class="form-control-dash" value="<?php echo htmlspecialchars($userProfile['mobile_number'] ?? ''); ?>" required>
                        </div>
                        <div>
                            <label style="font-size: 0.82rem; font-weight: 600; color: #2d1e1c; display: block; margin-bottom: 4px;">Delivery Address *</label>
                            <input type="text" name="address" class="form-control-dash" value="<?php echo htmlspecialchars($userProfile['address'] ?? ''); ?>" required>
                        </div>
                    </div>
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 14px;">
                        <div>
                            <label style="font-size: 0.82rem; font-weight: 600; color: #2d1e1c; display: block; margin-bottom: 4px;">New Password (Optional)</label>
                            <input type="password" name="new_password" class="form-control-dash" placeholder="New Password">
                        </div>
                        <div>
                            <label style="font-size: 0.82rem; font-weight: 600; color: #2d1e1c; display: block; margin-bottom: 4px;">Confirm New Password</label>
                            <input type="password" name="confirm_password" class="form-control-dash" placeholder="Confirm New Password">
                        </div>
                    </div>
                    <div style="display: flex; justify-content: flex-end; gap: 12px; margin-top: 10px;">
                        <a href="dashboard.php" class="btn-dash-action" style="background: #718096; text-decoration: none;">Cancel</a>
                        <button type="submit" class="btn-dash-action"><i class="fa-solid fa-floppy-disk"></i> Save Changes</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

</body>
</html>
