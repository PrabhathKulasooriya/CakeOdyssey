<?php
// Simple Database Connection
mysqli_report(MYSQLI_REPORT_OFF);

// Establish database connection with automatic fallback for alternative MySQL ports (3306 -> 3307)
$conn = @mysqli_connect("localhost", "root", "", "cake_odyssey", 3306);
if (!$conn) {
    $conn = @mysqli_connect("localhost", "root", "", "cake_odyssey", 3307);
}
if (!$conn) {
    die("Database Connection Failed: " . mysqli_connect_error());
}

// Automatically ensure orders status column is VARCHAR(50) to support custom status values ('Order Received', 'In the Oven', 'Cake is Ready', etc.)
@mysqli_query($conn, "ALTER TABLE orders MODIFY status VARCHAR(50) NOT NULL DEFAULT 'Order Received'");
?>