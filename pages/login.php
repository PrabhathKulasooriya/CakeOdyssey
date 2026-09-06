<?php
if (session_status() === PHP_SESSION_NONE) session_start();

if (!empty($_SESSION['user_id'])) {
    header('Location: ../index.php');
    exit();
}

$error_message = $_GET['error'] ?? '';
$success_message = $_GET['success'] ?? '';
$mobile = $_GET['mobile'] ?? '';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Cake Odyssey</title>
    <!-- Local Fonts & Icons -->
    <link rel="stylesheet" href="../css/fonts.css">
    <link rel="stylesheet" href="../css/all.min.css">
    <link rel="stylesheet" href="../css/navbar.css">
    <link rel="stylesheet" href="../css/auth.css">
</head>
<body>

    <div class="auth-page-container">
        <!-- Include Navbar Module -->
        <?php include __DIR__ . '/../navbar.php'; ?>

        <main class="auth-main">
            <div class="auth-card">
                
                <div class="auth-header">
                    <div class="auth-icon-badge">
                        <i class="fa-solid fa-user-lock"></i>
                    </div>
                    <h1 class="auth-title">Welcome Back</h1>
                    <p class="auth-subtitle">Login to manage your cake orders & custom requests</p>
                </div>

                <?php if (!empty($error_message)): ?>
                    <div class="alert-error">
                        <i class="fa-solid fa-circle-exclamation"></i>
                        <span><?php echo htmlspecialchars($error_message); ?></span>
                        <button type="button" class="alert-close-btn" onclick="this.parentElement.style.display='none'">
                            <i class="fa-solid fa-xmark"></i>
                        </button>
                    </div>
                <?php endif; ?>

                <?php if (!empty($success_message)): ?>
                    <div class="alert-success">
                        <i class="fa-solid fa-circle-check"></i>
                        <span><?php echo htmlspecialchars($success_message); ?></span>
                        <button type="button" class="alert-close-btn" onclick="this.parentElement.style.display='none'">
                            <i class="fa-solid fa-xmark"></i>
                        </button>
                    </div>
                <?php endif; ?>

                <!-- Login Form -->
                <form action="../controllers/login.php" method="POST" class="auth-form">
                    
                    <!-- Mobile Number -->
                    <div class="form-group">
                        <label for="mobile" class="form-label">
                            Mobile Number <span class="required">*</span>
                        </label>
                        <div class="input-wrapper">
                            <i class="fa-solid fa-phone input-icon"></i>
                            <input 
                                type="tel" 
                                id="mobile" 
                                name="mobile" 
                                class="form-control" 
                                placeholder="07XXXXXXXX"
                                pattern="07[0-9]{8}"
                                title="Mobile number must start with 07 and be 10 digits long"
                                maxlength="10"
                                value="<?php echo htmlspecialchars($mobile); ?>"
                                required
                            >
                        </div>
                        <span class="field-hint">(e.g. 0772345678)</span>
                    </div>

                    <!-- Password -->
                    <div class="form-group">
                        <label for="password" class="form-label">
                            Password <span class="required">*</span>
                        </label>
                        <div class="input-wrapper">
                            <i class="fa-solid fa-lock input-icon"></i>
                            <input 
                                type="password" 
                                id="password" 
                                name="password" 
                                class="form-control" 
                                placeholder="Enter your password"
                                required
                            >
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" class="btn-submit">
                        <i class="fa-solid fa-right-to-bracket"></i> Login
                    </button>
                </form>

                <!-- Footer Navigation -->
                <div class="auth-footer-link">
                    Don't have an account yet? <a href="signup.php">Create an Account</a>
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
