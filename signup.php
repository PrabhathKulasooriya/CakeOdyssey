<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up - Cake Odyssey</title>
    <!-- Local Fonts & Icons -->
    <link rel="stylesheet" href="css/fonts.css">
    <link rel="stylesheet" href="css/all.min.css">
    <link rel="stylesheet" href="css/navbar.css">
    <link rel="stylesheet" href="css/auth.css">
</head>
<body>

    <div class="auth-page-container">
        <!-- Include Navbar Module -->
        <?php include 'navbar.php'; ?>

        <main class="auth-main">
            <div class="auth-card">
                
                <div class="auth-header">
                    <div class="auth-icon-badge">
                        <i class="fa-solid fa-user-plus"></i>
                    </div>
                    <h1 class="auth-title">Create Account</h1>
                    <p class="auth-subtitle">Join Cake Odyssey to order custom cakes & track orders</p>
                </div>

                <!-- Signup Form -->
                <form action="#" method="POST" class="auth-form">
                    
                    <!-- Full Name -->
                    <div class="form-group">
                        <label for="name" class="form-label">
                            Full Name <span class="required">*</span>
                        </label>
                        <div class="input-wrapper">
                            <i class="fa-solid fa-user input-icon"></i>
                            <input 
                                type="text" 
                                id="name" 
                                name="name" 
                                class="form-control" 
                                placeholder="Enter your full name"
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
                            ></textarea>
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
