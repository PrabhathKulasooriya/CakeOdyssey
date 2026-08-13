<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (isset($_SESSION['user_id'])) {
    header('Location: ../index.php');
    exit();
}

$error_message = $_GET['error'] ?? '';
$success_message = $_GET['success'] ?? '';
$name = $_GET['name'] ?? '';
$address = $_GET['address'] ?? '';
$mobile = $_GET['mobile'] ?? '';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up - Cake Odyssey</title>
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
                        <i class="fa-solid fa-user-plus"></i>
                    </div>
                    <h1 class="auth-title">Create Account</h1>
                    <p class="auth-subtitle">Join Cake Odyssey to order custom cakes </p>
                </div>

                <?php if (!empty($error_message)): ?>
                    <div class="alert-error" style="margin-bottom: 20px;">
                        <i class="fa-solid fa-circle-exclamation"></i>
                        <span><?php echo htmlspecialchars($error_message); ?></span>
                    </div>
                <?php endif; ?>

                <?php if (!empty($success_message)): ?>
                    <div class="alert-success" style="background: #e6fffa; border: 1px solid #b2f5ea; color: #234e52; padding: 12px 16px; border-radius: 12px; font-size: 0.85rem; font-weight: 500; display: flex; align-items: center; gap: 10px; margin-bottom: 20px;">
                        <i class="fa-solid fa-circle-check" style="color: #319795; font-size: 1.1rem;"></i>
                        <span><?php echo htmlspecialchars($success_message); ?> <a href="login.php" style="color: #2b6cb0; text-decoration: underline; font-weight: 600;">Click here to Log In</a></span>
                    </div>
                <?php endif; ?>

                <!-- Signup Form -->
                <form action="../controllers/register.php" method="POST" class="auth-form">
                    
                    <!-- Name -->
                    <div class="form-group">
                        <label for="name" class="form-label">
                            Name <span class="required">*</span>
                        </label>
                        <div class="input-wrapper">
                            <i class="fa-solid fa-user input-icon"></i>
                            <input 
                                type="text" 
                                id="name" 
                                name="name" 
                                class="form-control" 
                                placeholder="Enter your full name"
                                value="<?php echo htmlspecialchars($name); ?>"
                                required
                            >
                        </div>
                    </div>

                    <!-- Address -->
                    <div class="form-group">
                        <label for="address" class="form-label">
                            Delivery Address <span class="required">*</span>
                        </label>
                        <div class="input-wrapper">
                            <i class="fa-solid fa-location-dot input-icon" style="top: 14px;"></i>
                            <textarea 
                                id="address" 
                                name="address" 
                                class="form-control" 
                                placeholder="Enter your delivery address"
                                rows="2"
                                required
                            ><?php echo htmlspecialchars($address); ?></textarea>
                        </div>
                    </div>

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
                                placeholder="Create a strong password"
                                minlength="6"
                                required
                            >
                        </div>
                    </div>

                    <!-- Confirm Password -->
                    <div class="form-group">
                        <label for="confirm_password" class="form-label">
                            Confirm Password <span class="required">*</span>
                        </label>
                        <div class="input-wrapper">
                            <i class="fa-solid fa-lock input-icon"></i>
                            <input 
                                type="password" 
                                id="confirm_password" 
                                name="confirm_password" 
                                class="form-control" 
                                placeholder="Re-enter your password"
                                minlength="6"
                                required
                            >
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" class="btn-submit">
                        <i class="fa-solid fa-user-check"></i> Sign Up
                    </button>
                </form>

                <!-- Footer Navigation -->
                <div class="auth-footer-link">
                    Already have an account? <a href="login.php">Log In Here</a>
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
