<?php
$host = "localhost";
$user = "root";
$pass = "";
$db   = "cake_odyssey";

// Connect to the database
$conn = mysqli_connect($host, $user, $pass, $db);

if (!$conn) {
    die("Database Connection Failed: " . mysqli_connect_error());
}
?>