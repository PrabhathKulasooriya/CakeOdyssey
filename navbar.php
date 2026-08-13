<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$scriptPath = str_replace('\\', '/', $_SERVER['SCRIPT_NAME']);
$currentPage = basename($scriptPath);
$inPages = (basename(dirname($scriptPath)) === 'pages');
$basePath = $inPages ? '../' : './';
$isLoggedIn = isset($_SESSION['user_id']) && !empty($_SESSION['user_id']);
?>
<header class="navbar">
    <a href="<?php echo $basePath; ?>index.php" class="logo" style="text-decoration: none;">
        <div class="logo-title">Cake Odyssey</div>
        <div class="logo-subtitle">&mdash; HOME BAKERY &mdash;</div>
        <div class="logo-heart">&#9825;</div>
    </a>

    <ul class="nav-links" id="navLinks">
        <li><a href="<?php echo $basePath; ?>index.php" class="<?php echo ($currentPage == 'index.php' || $currentPage == '') ? 'active' : ''; ?>">Home</a></li>
        <li><a href="<?php echo $basePath; ?>pages/cakes.php" class="<?php echo ($currentPage == 'cakes.php') ? 'active' : ''; ?>">Our Cakes</a></li>
    </ul>

    <div class="nav-icons">
        <!-- Cart Icon -->
        <a href="#" class="icon-btn cart-wrapper" aria-label="Cart">
            <i class="fa-solid fa-cart-shopping"></i>
            <span class="cart-badge">0</span>
        </a>

        <ul class="nav-links nav-auth">
            <?php if ($isLoggedIn): ?>
                <li>
                    <span class="nav-user-greeting" style="font-size: 0.88rem; font-weight: 600; color: var(--text-highlight, #b85b6c); display: inline-flex; align-items: center; gap: 6px;">
                        <i class="fa-solid fa-user-check"></i> <?php echo htmlspecialchars($_SESSION['user_name']); ?>
                    </span>
                </li>
                <li><a href="<?php echo $basePath; ?>controllers/logout.php" style="color: #b85b6c;"><i class="fa-solid fa-right-from-bracket"></i> Logout</a></li>
            <?php else: ?>
                <li><a href="<?php echo $basePath; ?>pages/login.php" class="<?php echo ($currentPage == 'login.php') ? 'active' : ''; ?>">Login</a></li>
                <li><a href="<?php echo $basePath; ?>pages/signup.php" class="<?php echo ($currentPage == 'signup.php') ? 'active' : ''; ?>">Sign Up</a></li>
            <?php endif; ?>
        </ul>

        <button class="mobile-toggle" id="mobileToggle" aria-label="Toggle menu" onclick="document.getElementById('navLinks').classList.toggle('active')">
            <i class="fa-solid fa-bars"></i>
        </button>
    </div>
</header>