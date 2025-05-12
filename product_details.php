<?php
require 'db.php';
session_start();

if (!isset($_GET['id'])) {
    header('Location: index.php');
    exit();
}

$product_id = $_GET['id'];

// Fetch product details
$stmt = $pdo->prepare("SELECT * FROM products WHERE id = ?");
$stmt->execute([$product_id]);
$product = $stmt->fetch();

if (!$product) {
    echo "Product not found.";
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($product['name']); ?></title>
    <link rel="stylesheet" href="assets/css/styles.css">
</head>
<body>
    <?php include 'includes/header.php'; ?>

    <div class="container">
        <h1><?php echo htmlspecialchars($product['name']); ?></h1>
        <div class="product-details">
            <img src="assets/images/<?php echo htmlspecialchars($product['image']); ?>" alt="<?php echo htmlspecialchars($product['name']); ?>">
            <p><strong>Category:</strong> <?php echo htmlspecialchars($product['category']); ?></p>
            <p><strong>Price:</strong> $<?php echo number_format($product['price'], 2); ?></p>
            <p><strong>Description:</strong> <?php echo htmlspecialchars($product['description']); ?></p>
            <a href="index.php" class="back-button">Back to Home</a>
        </div>
    </div>

    <?php include 'includes/footer.php'; ?>
</body>
</html>