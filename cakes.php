<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Our Cakes - Cake Odyssey</title>
    <!-- Local Fonts & Icons -->
    <link rel="stylesheet" href="css/fonts.css">
    <link rel="stylesheet" href="css/all.min.css">
    <link rel="stylesheet" href="css/navbar.css">
    <link rel="stylesheet" href="css/cakes.css">
</head>
<body>

    <!-- Page Wrapper with Background -->
    <div class="cakes-page-hero">
        
        <!-- Include Navbar Module -->
        <?php include 'navbar.php'; ?>

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

        <!-- Category Filters -->
        <!-- <div class="category-filter-container">
            <button class="filter-btn active"><i class="fa-solid fa-layer-group"></i> All Cakes</button>
            <button class="filter-btn"><i class="fa-solid fa-cake-candles"></i> Birthday Specials</button>
            <button class="filter-btn"><i class="fa-solid fa-cookie-bite"></i> Chocolate</button>
            <button class="filter-btn"><i class="fa-solid fa-lemon"></i> Fruit Delights</button>
            <button class="filter-btn"><i class="fa-solid fa-wand-magic-sparkles"></i> Custom Designs</button>
        </div> -->

        <!-- Cakes Grid Container -->
        <main class="cakes-container">
            <div class="cakes-grid">
                
                <!-- Cake Card 1 -->
                <div class="cake-card">
                    <div class="cake-badge bestseller">Bestseller</div>
                    <button class="wishlist-btn" aria-label="Add to Wishlist"><i class="fa-regular fa-heart"></i></button>
                    <div class="cake-img-box">
                        <i class="fa-solid fa-cake-candles cake-placeholder-icon"></i>
                    </div>
                    <div class="cake-details">
                        <div class="cake-rating">
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                            <span>(5.0 / 128)</span>
                        </div>
                        <h3 class="cake-title">Velvet Berry Delight</h3>
                        <p class="cake-desc">Red velvet layers with organic cream cheese frosting and fresh berries.</p>
                        <div class="cake-footer">
                            <div class="cake-price">$45.00</div>
                            <button class="btn-add-cart"><i class="fa-solid fa-cart-shopping"></i> Add to Cart</button>
                        </div>
                    </div>
                </div>

                <!-- Cake Card 2 -->
                <div class="cake-card">
                    <div class="cake-badge specialty">Chef's Choice</div>
                    <button class="wishlist-btn" aria-label="Add to Wishlist"><i class="fa-regular fa-heart"></i></button>
                    <div class="cake-img-box">
                        <i class="fa-solid fa-cookie-bite cake-placeholder-icon"></i>
                    </div>
                    <div class="cake-details">
                        <div class="cake-rating">
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star-half-stroke"></i>
                            <span>(4.9 / 95)</span>
                        </div>
                        <h3 class="cake-title">Royal Chocolate Truffle</h3>
                        <p class="cake-desc">Decadent dark chocolate ganache cake infused with espresso caramel.</p>
                        <div class="cake-footer">
                            <div class="cake-price">$52.00</div>
                            <button class="btn-add-cart"><i class="fa-solid fa-cart-shopping"></i> Add to Cart</button>
                        </div>
                    </div>
                </div>

                <!-- Cake Card 3 -->
                <div class="cake-card">
                    <button class="wishlist-btn" aria-label="Add to Wishlist"><i class="fa-regular fa-heart"></i></button>
                    <div class="cake-img-box">
                        <i class="fa-solid fa-wand-magic-sparkles cake-placeholder-icon"></i>
                    </div>
                    <div class="cake-details">
                        <div class="cake-rating">
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                            <span>(4.8 / 64)</span>
                        </div>
                        <h3 class="cake-title">Vanilla Bean Mousse</h3>
                        <p class="cake-desc">Madagascar vanilla sponge layered with light white chocolate mousse.</p>
                        <div class="cake-footer">
                            <div class="cake-price">$38.00</div>
                            <button class="btn-add-cart"><i class="fa-solid fa-cart-shopping"></i> Add to Cart</button>
                        </div>
                    </div>
                </div>

                <!-- Cake Card 4 -->
                <div class="cake-card">
                    <div class="cake-badge new">New</div>
                    <button class="wishlist-btn" aria-label="Add to Wishlist"><i class="fa-regular fa-heart"></i></button>
                    <div class="cake-img-box">
                        <i class="fa-solid fa-lemon cake-placeholder-icon"></i>
                    </div>
                    <div class="cake-details">
                        <div class="cake-rating">
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                            <span>(4.9 / 82)</span>
                        </div>
                        <h3 class="cake-title">Mango Passionfruit Mousse</h3>
                        <p class="cake-desc">Tropical mango puree layers paired with tangy passionfruit curd.</p>
                        <div class="cake-footer">
                            <div class="cake-price">$48.00</div>
                            <button class="btn-add-cart"><i class="fa-solid fa-cart-shopping"></i> Add to Cart</button>
                        </div>
                    </div>
                </div>

                <!-- Cake Card 5 -->
                <div class="cake-card">
                    <div class="cake-badge bestseller">Bestseller</div>
                    <button class="wishlist-btn" aria-label="Add to Wishlist"><i class="fa-regular fa-heart"></i></button>
                    <div class="cake-img-box">
                        <i class="fa-solid fa-gift cake-placeholder-icon"></i>
                    </div>
                    <div class="cake-details">
                        <div class="cake-rating">
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                            <span>(5.0 / 110)</span>
                        </div>
                        <h3 class="cake-title">Hazelnut Praline Dream</h3>
                        <p class="cake-desc">Crunchy hazelnut praline with Belgian milk chocolate sponge layers.</p>
                        <div class="cake-footer">
                            <div class="cake-price">$55.00</div>
                            <button class="btn-add-cart"><i class="fa-solid fa-cart-shopping"></i> Add to Cart</button>
                        </div>
                    </div>
                </div>

                <!-- Cake Card 6 -->
                <div class="cake-card">
                    <button class="wishlist-btn" aria-label="Add to Wishlist"><i class="fa-regular fa-heart"></i></button>
                    <div class="cake-img-box">
                        <i class="fa-solid fa-heart cake-placeholder-icon"></i>
                    </div>
                    <div class="cake-details">
                        <div class="cake-rating">
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star-half-stroke"></i>
                            <span>(4.9 / 76)</span>
                        </div>
                        <h3 class="cake-title">Strawberry Shortcake Supreme</h3>
                        <p class="cake-desc">Fluffy Japanese sponge filled with fresh farm strawberries & sweet cream.</p>
                        <div class="cake-footer">
                            <div class="cake-price">$42.00</div>
                            <button class="btn-add-cart"><i class="fa-solid fa-cart-shopping"></i> Add to Cart</button>
                        </div>
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
