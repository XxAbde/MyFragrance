<?php
// Reusable PHP functions (functions.php)

function isAdmin() {
    return isset($_SESSION['user_id']) && $_SESSION['role'] === 'admin';
}

function isAuthenticated() {
    return isset($_SESSION['user_id']);
}
?>