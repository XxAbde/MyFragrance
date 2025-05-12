<?php
session_start();
require 'db.php';

if (!isset($_SESSION['admin_id'])) {
    header('Location: admin_login.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id'])) {
    // Fetch client details
    $client_id = $_GET['id'];
    $stmt = $pdo->prepare('SELECT * FROM users WHERE id = ?');
    $stmt->execute([$client_id]);
    $client = $stmt->fetch();

    if (!$client) {
        echo "Client not found.";
        exit();
    }
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    // Update client details
    $client_id = $_POST['id'];
    $email = $_POST['email'];

    $stmt = $pdo->prepare('UPDATE users SET email = ? WHERE id = ?');
    $stmt->execute([$email, $client_id]);

    header('Location: manage_clients.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Client</title>
    <link rel="stylesheet" href="assets/css/styles.css">
</head>
<body>
    <?php if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($client)): ?>
        <form action="edit_client.php" method="POST">
            <h2>Edit Client</h2>
            <input type="hidden" name="id" value="<?php echo htmlspecialchars($client['id']); ?>">
            <label>Email:</label>
            <input type="email" name="email" value="<?php echo htmlspecialchars($client['email']); ?>" required>
            <button type="submit">Save Changes</button>
        </form>
    <?php endif; ?>
</body>
</html>