<?php
session_start();
require 'db.php';

if (!isset($_SESSION['admin_id'])) {
    header('Location: admin_login.php');
    exit();
}

// Fetch all clients
$stmt = $pdo->prepare('SELECT * FROM users WHERE role = ?');
$stmt->execute(['client']);
$clients = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Clients</title>
    <link rel="stylesheet" href="assets/css/styles.css">
</head>
<body>
    <h1>Manage Clients</h1>
    <?php if (count($clients) > 0): ?>
        <table>
            <thead>
                <tr>
                    <th>Email</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($clients as $client): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($client['email']); ?></td>
                        <td>
                            <a href="edit_client.php?id=<?php echo $client['id']; ?>">Edit</a>
                            <a href="delete_client.php?id=<?php echo $client['id']; ?>" onclick="return confirm('Are you sure?')">Delete</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        
    <?php else: ?>
        <p>No clients found.</p>
    <?php endif; ?>
    <a href="admin_dashboard.php">Back to Dashboard</a> 
</body>
</html>