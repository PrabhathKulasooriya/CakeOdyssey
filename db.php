<?php
// Simple Database Connection
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

if (!$conn) {
    die("Database Connection Failed: " . mysqli_connect_error());
}
?>