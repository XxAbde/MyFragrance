<?php
session_start();
require 'db.php';

if (!isset($_SESSION['admin_id'])) {
    header('Location: admin_login.php');
    exit();
}

if (isset($_GET['id'])) {
    $client_id = $_GET['id'];

    // Delete the client
    $stmt = $pdo->prepare('DELETE FROM users WHERE id = ?');
    $stmt->execute([$client_id]);

    header('Location: manage_clients.php');
    exit();
} else {
    echo "Invalid request.";
    exit();
}
?>