<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header('Location: admin_login.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="assets/css/styles.css">
</head>
<body>
    <h1>Welcome, Admin</h1>
    <nav>
        <a href="manage_products.php">Manage Products</a>
        <a href="manage_clients.php">Manage Clients</a>
        <a href="logout.php">Logout</a>
    </nav>
</body>
</html>