<?php
$currentPage = basename($_SERVER['SCRIPT_NAME']);
?>
<header class="navbar">
    <a href="index.php" class="logo" style="text-decoration: none;">
        <div class="logo-title">Cake Odyssey</div>
        <div class="logo-subtitle">&mdash; HOME BAKERY &mdash;</div>
        <div class="logo-heart">&#9825;</div>
    </a>

    <ul class="nav-links" id="navLinks">
        <li><a href="index.php" class="<?php echo ($currentPage == 'index.php' || $currentPage == '') ? 'active' : ''; ?>">Home</a></li>
        <li><a href="cakes.php" class="<?php echo ($currentPage == 'cakes.php') ? 'active' : ''; ?>">Our Cakes</a></li>
    </ul>

    <div class="nav-icons">
        <!-- Cart Icon -->
        <a href="#" class="icon-btn cart-wrapper" aria-label="Cart">
            <i class="fa-solid fa-cart-shopping"></i>
            <span class="cart-badge">0</span>
        </a>

        <ul class="nav-links nav-auth">
            <li><a href="login.php" class="<?php echo ($currentPage == 'login.php') ? 'active' : ''; ?>">Login</a></li>
            <li><a href="signup.php" class="<?php echo ($currentPage == 'signup.php') ? 'active' : ''; ?>">Sign Up</a></li>
        </ul>

        <button class="mobile-toggle" id="mobileToggle" aria-label="Toggle menu" onclick="document.getElementById('navLinks').classList.toggle('active')">
            <i class="fa-solid fa-bars"></i>
        </button>
    </div>
</header>