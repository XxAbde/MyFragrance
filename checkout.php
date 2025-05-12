<?php
// Order checkout (checkout.php)
require 'db.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

// Handle order checkout process
?>
<h1>Checkout</h1>