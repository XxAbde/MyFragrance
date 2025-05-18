<?php
require 'db.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_SESSION['user_id'];
    $product_id = $_POST['product_id'];

    $stmt = $pdo->prepare('SELECT quantity FROM products WHERE id = ?');
    $stmt->execute([$product_id]);
    $product = $stmt->fetch();

    if ($product['quantity'] <= 0) {
        echo "<p>Sorry, this product is out of stock.</p>";
        exit();
    }

    $stmt = $pdo->prepare('SELECT * FROM cart WHERE user_id = ? AND product_id = ?');
    $stmt->execute([$user_id, $product_id]);
    $cart_item = $stmt->fetch();

    if ($cart_item) {
        $stmt = $pdo->prepare('UPDATE cart SET quantity = quantity + 1 WHERE user_id = ? AND product_id = ?');
        $stmt->execute([$user_id, $product_id]);
    } else {
        $stmt = $pdo->prepare('INSERT INTO cart (user_id, product_id, quantity) VALUES (?, ?, 1)');
        $stmt->execute([$user_id, $product_id]);
    }

    header('Location: cart.php');
    exit();
}
?>