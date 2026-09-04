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
?>