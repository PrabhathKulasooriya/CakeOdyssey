<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Our Cakes - Cake Odyssey</title>
    <!-- Local Fonts & Icons -->
    <link rel="stylesheet" href="../css/fonts.css">
    <link rel="stylesheet" href="../css/all.min.css">
    <link rel="stylesheet" href="../css/navbar.css">
    <link rel="stylesheet" href="../css/cakes.css">
</head>
<body>

    <!-- Page Wrapper with Background -->
    <div class="cakes-page-hero">
        
        <!-- Include Navbar Module -->
        <?php include __DIR__ . '/../navbar.php'; ?>

        <!-- Hero Header -->
        <header class="cakes-header">
            <div class="header-container">
                <p class="greeting">Handcrafted Delight <span class="heart-icon">&#9825;</span></p>
                <h1 class="main-heading">
                    Explore Our <span class="heading-highlight">Cake Collection</span>
                </h1>
                <div class="divider">
                    <span>&mdash;&mdash;</span> <span class="heart-icon">&#9825;</span> <span>&mdash;&mdash;</span>
                </div>
                <p class="description">
                    Discover our artisanal range of signature cakes, baked fresh daily with organic ingredients and timeless love.
                </p>
            </div>
        </header>

        <!-- Category Filters / Success Alert -->
        <?php if (!empty($_GET['success'])): ?>
            <div class="success-alert">
                <i class="fa-solid fa-circle-check"></i>
                <span><?php echo htmlspecialchars($_GET['success']); ?></span>
            </div>
        <?php endif; ?>

        <!-- Cakes Grid Container -->
        <main class="cakes-container">
            <div class="cakes-grid">
                
                <?php 
                // Fetch logged-in user's cart state to render active inline quantity controls on product cards
                $userCart = [];
                if (!empty($_SESSION['user_id'])) {
                    $cartRes = mysqli_query($conn, "SELECT id, cake_id, quantity FROM cart_items WHERE user_id = " . (int)$_SESSION['user_id']);
                    while ($cRow = mysqli_fetch_assoc($cartRes)) {
                        $userCart[$cRow['cake_id']] = $cRow;
                    }
                }

                $cakesResult = mysqli_query($conn, "SELECT * FROM cakes ORDER BY id ASC");
                $hasCakes = false;
                
                while ($cake = mysqli_fetch_assoc($cakesResult)):
                    $hasCakes = true;
                    $cakeId = $cake['id'];
                    $isIcon = !empty($cake['image']) && strpos($cake['image'], 'fa-') === 0;
                    $isKilo = ($cake['cake_type'] === 'kilo');
                    
                    $inCart = isset($userCart[$cakeId]);
                    $cartQty = $inCart ? (int)$userCart[$cakeId]['quantity'] : 0;
                    $cartItemId = $inCart ? (int)$userCart[$cakeId]['id'] : 0;
                ?>
                    <!-- Cake Card -->
                    <div class="cake-card">
                        <div class="cake-badge bestseller"><?php echo ucfirst(htmlspecialchars($cake['cake_type'])); ?> - <?php echo htmlspecialchars($cake['size']); ?></div>
                        
                        <div class="cake-img-box">
                            <?php if ($isIcon): ?>
                                <i class="fa-solid <?php echo htmlspecialchars($cake['image']); ?> cake-placeholder-icon"></i>
                            <?php else: ?>
                                <img src="../assests/cake/<?php echo htmlspecialchars($cake['image']); ?>" alt="<?php echo htmlspecialchars($cake['name']); ?>">
                            <?php endif; ?>
                        </div>

                        <div class="cake-details">
                            <div class="cake-rating">
                                <i class="fa-solid fa-star"></i>
                                <i class="fa-solid fa-star"></i>
                                <i class="fa-solid fa-star"></i>
                                <i class="fa-solid fa-star"></i>
                                <i class="fa-solid fa-star"></i>
                                <span>(5.0)</span>
                            </div>
                            <h3 class="cake-title"><?php echo htmlspecialchars($cake['name']); ?></h3>
                            <p class="cake-desc"><?php echo htmlspecialchars($cake['description']); ?></p>
                            
                            <div class="cake-footer">
                                <div class="cake-price">
                                    Rs. <?php echo number_format($cake['base_price'], 2); ?>
                                    <?php if ($isKilo): ?><span class="price-unit"> / KG</span><?php endif; ?>
                                </div>

                                <!-- Plus / Minus Control at Add to Cart Button Position -->
                                <?php if ($cartQty == 0): ?>
                                    <a href="../controllers/cart_add.php?cake_id=<?php echo $cakeId; ?>&quantity=1" class="btn-add-cart">
                                        <i class="fa-solid fa-cart-shopping"></i> Add to Cart
                                    </a>
                                <?php else: ?>
                                    <div class="cake-footer-qty-control">
                                        <a href="../controllers/cart_remove.php?id=<?php echo $cartItemId; ?>&action=decrease&redirect=cakes" class="btn-qty-footer btn-minus" title="Reduce Quantity">
                                            <i class="fa-solid fa-minus"></i>
                                        </a>
                                        <span class="qty-footer-val"><?php echo $cartQty; ?><?php echo $isKilo ? ' KG' : ''; ?></span>
                                        <a href="../controllers/cart_add.php?cake_id=<?php echo $cakeId; ?>&quantity=1" class="btn-qty-footer btn-plus" title="Add More">
                                            <i class="fa-solid fa-plus"></i>
                                        </a>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>
                <?php if (!$hasCakes): ?>
                    <p class="no-cakes-msg">No cakes available at the moment.</p>
                <?php endif; ?>

            </div>
        </main>
    </div>

    <!-- Bottom Banner -->
    <footer class="bottom-banner">
        <div class="banner-item">
            <i class="fa-solid fa-truck-fast banner-icon"></i>
            <span>Islandwide<br>Delivery</span>
        </div>
        <div class="banner-item">
            <i class="fa-solid fa-wand-magic-sparkles banner-icon"></i>
            <span>Custom Designs<br>Available</span>
        </div>
        <div class="banner-item">
            <i class="fa-solid fa-award banner-icon"></i>
            <span>Best Quality<br>Assured</span>
        </div>
        <div class="banner-item">
            <i class="fa-solid fa-headset banner-icon"></i>
            <span>Friendly<br>Support</span>
        </div>
    </footer>

</body>
</html>
