<?php
require 'db.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $cart_id = $_POST['cart_id'];
    $quantity = $_POST['quantity'];

    if ($quantity < 1) {
        // If quantity is less than 1, redirect back to cart without updating
        header('Location: cart.php');
        exit();
    }

    // Update the quantity in the cart
    $stmt = $pdo->prepare('UPDATE cart SET quantity = ? WHERE id = ?');
    $stmt->execute([$quantity, $cart_id]);

    // Redirect back to the cart
    header('Location: cart.php');
    exit();
}
?>