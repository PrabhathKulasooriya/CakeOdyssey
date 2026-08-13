<?php
// Simple Database Connection & Initialization
mysqli_report(MYSQLI_REPORT_OFF);

$host = "localhost";
$user = "root";
$pass = "";
$db   = "cake_odyssey";

// Connect to Database
$conn = @mysqli_connect($host, $user, $pass, $db, 3306);
if (!$conn) {
    $conn = @mysqli_connect($host, $user, $pass, $db, 3307);
}

// Auto-create database if it doesn't exist
if (!$conn) {
    $server_conn = @mysqli_connect($host, $user, $pass, "", 3306);
    if (!$server_conn) {
        $server_conn = @mysqli_connect($host, $user, $pass, "", 3307);
    }
    if ($server_conn) {
        @mysqli_query($server_conn, "CREATE DATABASE IF NOT EXISTS `$db` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
        @mysqli_close($server_conn);
    }
    $conn = @mysqli_connect($host, $user, $pass, $db, 3306);
    if (!$conn) {
        $conn = @mysqli_connect($host, $user, $pass, $db, 3307);
    }
}

if (!$conn) {
    die("Database Connection Failed: " . mysqli_connect_error());
}

// 1. Users Table
$sql_users = "CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    address TEXT NOT NULL,
    mobile_number VARCHAR(15) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role ENUM('admin', 'customer') DEFAULT 'customer' NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";
@mysqli_query($conn, $sql_users);

// 2. Cakes Table
$sql_cakes = "CREATE TABLE IF NOT EXISTS cakes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    cake_type ENUM('custom', 'kilo') NOT NULL,
    size VARCHAR(50) NOT NULL,
    image VARCHAR(255) NOT NULL,
    description TEXT,
    base_price DECIMAL(10,2) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";
@mysqli_query($conn, $sql_cakes);

// 3. Cart Items Table
$sql_cart = "CREATE TABLE IF NOT EXISTS cart_items (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    cake_id INT NOT NULL,
    quantity INT DEFAULT 1 NOT NULL,
    weight_kg DECIMAL(4,2) DEFAULT 1.00 NOT NULL,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (cake_id) REFERENCES cakes(id) ON DELETE CASCADE
)";
@mysqli_query($conn, $sql_cart);

// 4. Orders Table
$sql_orders = "CREATE TABLE IF NOT EXISTS orders (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    total_amount DECIMAL(10,2) NOT NULL,
    due_date DATE NULL,
    status ENUM('pending', 'paid', 'completed') DEFAULT 'pending' NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
)";
@mysqli_query($conn, $sql_orders);

// Auto-migrate: Add due_date column if missing from existing orders table
$checkCol = @mysqli_query($conn, "SHOW COLUMNS FROM orders LIKE 'due_date'");
if ($checkCol && mysqli_num_rows($checkCol) == 0) {
    @mysqli_query($conn, "ALTER TABLE orders ADD COLUMN due_date DATE NULL AFTER total_amount");
}

// 5. Order Items Table
$sql_order_items = "CREATE TABLE IF NOT EXISTS order_items (
    id INT AUTO_INCREMENT PRIMARY KEY,
    order_id INT NOT NULL,
    cake_id INT,
    quantity INT NOT NULL,
    weight_kg DECIMAL(4,2) NOT NULL,
    price_locked DECIMAL(10,2) NOT NULL,
    FOREIGN KEY (order_id) REFERENCES orders(id) ON DELETE CASCADE,
    FOREIGN KEY (cake_id) REFERENCES cakes(id) ON DELETE SET NULL
)";
@mysqli_query($conn, $sql_order_items);

// Seed Default Admin Account if missing
$checkAdmin = @mysqli_query($conn, "SELECT id FROM users WHERE role = 'admin' LIMIT 1");
if ($checkAdmin && mysqli_num_rows($checkAdmin) == 0) {
    $seedAdmin = "INSERT INTO users (name, address, mobile_number, password, role) 
                  VALUES ('Bakery Admin', 'Cake Odyssey Main Store, Colombo', '0700000000', 'admin123', 'admin')";
    @mysqli_query($conn, $seedAdmin);
}

// Seed Default Sample Cakes if missing
$checkCakes = @mysqli_query($conn, "SELECT id FROM cakes LIMIT 1");
if ($checkCakes && mysqli_num_rows($checkCakes) == 0) {
    $seedCakes = "INSERT INTO cakes (name, cake_type, size, image, description, base_price) VALUES
    ('Velvet Berry Delight', 'kilo', '1 KG', '1700000001.jpg', 'Red velvet layers with organic cream cheese frosting and fresh berries.', 45.00),
    ('Royal Chocolate Truffle', 'custom', 'Medium', '1700000002.jpg', 'Decadent dark chocolate ganache cake infused with espresso caramel.', 52.00),
    ('Vanilla Bean Mousse', 'kilo', '1 KG', 'fa-wand-magic-sparkles', 'Madagascar vanilla sponge layered with light white chocolate mousse.', 38.00),
    ('Mango Passionfruit Mousse', 'kilo', '1.5 KG', 'fa-lemon', 'Tropical mango puree layers paired with tangy passionfruit curd.', 48.00),
    ('Hazelnut Praline Dream', 'custom', 'Large', 'fa-gift', 'Crunchy hazelnut praline with Belgian milk chocolate sponge layers.', 55.00),
    ('Strawberry Shortcake Supreme', 'kilo', '1 KG', 'fa-heart', 'Fluffy Japanese sponge filled with fresh farm strawberries & sweet cream.', 42.00)";
    @mysqli_query($conn, $seedCakes);
} else {
    // Optionally update first two default cakes if they have icon placeholders
    @mysqli_query($conn, "UPDATE cakes SET image = '1700000001.jpg' WHERE id = 1 AND image = 'fa-cake-candles'");
    @mysqli_query($conn, "UPDATE cakes SET image = '1700000002.jpg' WHERE id = 2 AND image = 'fa-cookie-bite'");
}
?>