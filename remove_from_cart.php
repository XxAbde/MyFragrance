<?php
require 'db.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $cart_id = $_POST['cart_id'];

    $stmt = $pdo->prepare('DELETE FROM cart WHERE id = ?');
    $stmt->execute([$cart_id]);

    header('Location: cart.php');
    exit();
}
?>