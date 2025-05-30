<?php
require 'db.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$user_id = $_SESSION['user_id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['buy_now'])) {
    $payment_method = $_POST['payment_method'];


    $stmt = $pdo->prepare('
        SELECT cart.id AS cart_id, products.id AS product_id, products.name, products.price, products.quantity AS stock_quantity, cart.quantity AS cart_quantity 
        FROM cart 
        JOIN products ON cart.product_id = products.id 
        WHERE cart.user_id = ?
    ');
    $stmt->execute([$user_id]);
    $cart_items = $stmt->fetchAll();

    if (!empty($cart_items)) {
        $pdo->beginTransaction();
        try {
            foreach ($cart_items as $item) {
                if ($item['cart_quantity'] > $item['stock_quantity']) {
                    $pdo->rollBack();
                    echo "<p>Sorry, insufficient stock for product: " . htmlspecialchars($item['name']) . "</p>";
                    exit();
                }
                $stmt = $pdo->prepare('UPDATE products SET quantity = quantity - ? WHERE id = ?');
                $stmt->execute([$item['cart_quantity'], $item['product_id']]);

                $stmt = $pdo->prepare('
                    INSERT INTO orders (user_id, product_id, quantity, total_price, payment_method, created_at)
                    VALUES (?, ?, ?, ?, ?, NOW())
                ');
                $stmt->execute([
                    $user_id,
                    $item['product_id'],
                    $item['cart_quantity'],
                    $item['price'] * $item['cart_quantity'],
                    $payment_method
                ]);
            }

            $stmt = $pdo->prepare('DELETE FROM cart WHERE user_id = ?');
            $stmt->execute([$user_id]);

            $pdo->commit();

            header('Location: order_confirmation.php');
            exit();
        } catch (Exception $e) {
            $pdo->rollBack();
            echo "<p>Something went wrong: " . $e->getMessage() . "</p>";
            exit();
        }
    } else {
        header('Location: cart.php');
        exit();
    }
}
?>