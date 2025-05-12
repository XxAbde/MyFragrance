<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Confirmation</title>
    <link rel="stylesheet" href="assets/css/styles.css">
</head>
<body>
    <?php include 'includes/header.php'; ?>

    <div class="container">
        <h2>Order Confirmation</h2>
        <p>Thank you for your purchase! Your order has been placed successfully.</p>
        <a href="index.php" class="button">Continue Shopping</a>
    </div>

    <?php include 'includes/footer.php'; ?>
</body>
</html>