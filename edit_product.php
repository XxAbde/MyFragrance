<?php
session_start();
require 'db.php';

if (!isset($_SESSION['admin_id'])) {
    header('Location: admin_login.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id'])) {
    $product_id = $_GET['id'];


    $stmt = $pdo->prepare('SELECT * FROM products WHERE id = ?');
    $stmt->execute([$product_id]);
    $product = $stmt->fetch();

    if (!$product) {
        echo "Product not found.";
        exit();
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $product_id = $_POST['id'];
    $name = $_POST['name'];
    $category = $_POST['category'];
    $brand = $_POST['brand'];
    $gender = $_POST['gender'];
    $price = $_POST['price'];
    $quantity = $_POST['quantity'];
    $description = $_POST['description'];

    $stmt = $pdo->prepare('UPDATE products SET name = ?, category = ?, brand = ?, gender = ?, price = ?, quantity = ?, description = ? WHERE id = ?');
    $stmt->execute([$name, $category, $brand, $gender, $price, $quantity, $description, $product_id]);

    header('Location: manage_products.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Product</title>
    <link rel="stylesheet" href="assets/css/styles.css">
</head>
<body>
    <?php if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($product)): ?>
        <form action="edit_product.php" method="POST">
            <h2>Edit Product</h2>
            <input type="hidden" name="id" value="<?php echo htmlspecialchars($product['id']); ?>">
            <label>Name:</label>
            <input type="text" name="name" value="<?php echo htmlspecialchars($product['name']); ?>" required>
            <label>Category:</label>
            <input type="text" name="category" value="<?php echo htmlspecialchars($product['category']); ?>" required>
            <label>Brand:</label>
            <input type="text" name="brand" value="<?php echo htmlspecialchars($product['brand']); ?>" required>
            <label>Gender:</label>
            <select name="gender" required>
                <option value="male" <?php echo $product['gender'] === 'male' ? 'selected' : ''; ?>>Male</option>
                <option value="female" <?php echo $product['gender'] === 'female' ? 'selected' : ''; ?>>Female</option>
                <option value="unisex" <?php echo $product['gender'] === 'unisex' ? 'selected' : ''; ?>>Unisex</option>
            </select>
            <label>Price:</label>
            <input type="number" step="0.01" name="price" value="<?php echo htmlspecialchars($product['price']); ?>" required>
            <label>Quantity:</label>
            <input type="number" name="quantity" value="<?php echo htmlspecialchars($product['quantity']); ?>" min="0" required>
            <label>Description:</label>
            <textarea name="description" required><?php echo htmlspecialchars($product['description']); ?></textarea>
            <button type="submit">Save Changes</button>
        </form>
    <?php endif; ?>
    <a href="manage_products.php">Back to Products</a>
</body>
</html>