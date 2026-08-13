<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cake Odyssey</title>
    <!-- Local Fonts & Icons -->
    <link rel="stylesheet" href="css/fonts.css">
    <link rel="stylesheet" href="css/all.min.css">
    <link rel="stylesheet" href="css/navbar.css">
    <link rel="stylesheet" href="css/index.css">
</head>
<body>

    <!-- Hero Section with Background -->
    <div class="hero-section">
        
        <!-- Include Navbar Module -->
        <?php include 'navbar.php'; ?>

        <main class="hero-content">
            <div class="text-content">
                <p class="greeting">Made with love,<br>baked for happiness <span class="heart-icon">&#9825;</span></p>
                
                <h1 class="main-heading">
                    Every Cake<br>
                    <span class="heading-highlight">has a story</span>
                </h1>
                
                <div class="divider">
                    <span>&mdash;&mdash;</span> <span class="heart-icon">&#9825;</span> <span>&mdash;&mdash;</span>
                </div>
                
                <p class="description">
                    From timeless classics to custom creations,<br>
                    we bake moments that stay with you.
                </p>
                
                <a href="pages/cakes.php" class="btn-order">ORDER YOUR CAKE</a>

                <div class="mini-features">
                    <div class="mini-feature">
                        <i class="fa-solid fa-cake-candles feature-icon"></i>
                        <span>Premium<br>Ingredients</span>
                    </div>
                    <div class="mini-feature">
                        <i class="fa-solid fa-heart feature-icon"></i>
                        <span>Made with<br>Love</span>
                    </div>
                    <div class="mini-feature">
                        <i class="fa-solid fa-gift feature-icon"></i>
                        <span>Perfect for Every<br>Occasion</span>
                    </div>
                </div>
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