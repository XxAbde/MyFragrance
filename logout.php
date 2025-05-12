<?php
// Logout functionality (logout.php)

// Start the session if it hasn't already been started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Destroy the session
session_destroy();

// Redirect to the homepage
header('Location: index.php');
exit();
?>