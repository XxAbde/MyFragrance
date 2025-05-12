<?php
session_start();
require 'db.php';

if (!isset($_SESSION['admin_id'])) {
    header('Location: admin_login.php');
    exit();
}

if (isset($_GET['id'])) {
    $product_id = $_GET['id'];

    // Delete the product
    $stmt = $pdo->prepare('DELETE FROM products WHERE id = ?');
    $stmt->execute([$product_id]);

    header('Location: manage_products.php');
    exit();
} else {
    echo "Invalid request.";
    exit();
}
?>