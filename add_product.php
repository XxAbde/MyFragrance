<?php
session_start();
require 'db.php';

if (!isset($_SESSION['admin_id'])) {
    header('Location: admin_login.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $category = $_POST['category'];
    $image = $_POST['image'];

    $stmt = $pdo->prepare('INSERT INTO products (name, description, price, category, image) VALUES (?, ?, ?, ?, ?)');
    $stmt->execute([$name, $description, $price, $category, $image]);

    header('Location: manage_products.php');
    exit();
}
?>
<form action="" method="POST">
    <h2>Add Product</h2>
    <label>Name:</label>
    <input type="text" name="name" required>
    <label>Description:</label>
    <textarea name="description" required></textarea>
    <label>Price:</label>
    <input type="number" step="0.01" name="price" required>
    <label>Category:</label>
    <input type="text" name="category" required>
    <label>Image URL:</label>
    <input type="text" name="image" required>
    <button type="submit">Add</button>
</form>