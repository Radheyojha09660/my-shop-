<?php
// includes/config.php
session_start();

$DB_HOST = 'localhost';
$DB_USER = 'root';
$DB_PASS = ''; // XAMPP default - change if needed
$DB_NAME = 'myshop';

// Razorpay keys - replace with your keys (test mode)
define('RAZORPAY_KEY', 'YOUR_RAZORPAY_KEY_ID');
define('RAZORPAY_SECRET', 'YOUR_RAZORPAY_KEY_SECRET');

try {
    $pdo = new PDO("mysql:host=$DB_HOST;dbname=$DB_NAME;charset=utf8mb4", $DB_USER, $DB_PASS, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    ]);
} catch (Exception $e) {
    die('DB connection error: ' . $e->getMessage());
}
