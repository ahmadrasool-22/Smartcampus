<?php
$env = parse_ini_file(__DIR__ . '/../.env');

// Database credentials
$host = $env['DB_HOST'];
$dbname = $env['DB_NAME'];
$username = $env['DB_USER'];     // default in XAMPP
$password = $env['DB_PASS'];         // default is empty

try {
    // Create PDO connection
    $conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);

    // Set error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Optional: echo "Connected successfully"; // for testing

} catch (PDOException $e) {
    // If connection fails
    die("Connection failed: " . $e->getMessage());
}
?>