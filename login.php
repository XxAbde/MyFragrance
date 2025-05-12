<?php
// Login functionality (login.php)
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    $stmt = $pdo->prepare('SELECT * FROM users WHERE username = ?');
    $stmt->execute([$username]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password'])) {
        session_start();
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['role'] = $user['role'];
        header('Location: index.php');
        exit();
    } else {
        $error = 'Invalid username or password.';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - MyFragrance</title>
    <link rel="stylesheet" href="assets/css/styles.css">
    <style>
        /* Remove global centering from body */
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
        }

        /* Add a wrapper for the login form */
        .login-wrapper {
            display: flex;
            justify-content: center;
            align-items: center;
            height: calc(100vh - 100px); /* Adjust based on header/footer height */
        }

        .container {
            text-align: center; /* Align text in the center */
            background: #fff; /* Optional: Add a background color to the container */
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2); /* Optional: Add a shadow effect */
            width: 300px; /* Optional: Set a fixed width */
        }

        input, button {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            box-sizing: border-box;
        }

        button {
            background-color: #333;
            color: #fff;
            border: none;
            cursor: pointer;
        }

        button:hover {
            background-color: #555;
        }
    </style>
</head>
<body>
    <?php include 'includes/header.php'; ?> <!-- Include the header -->

    <!-- Wrapper for centering the login form -->
    <div class="login-wrapper">
        <div class="container">
            <h2>Login</h2><br>
            <?php if (isset($error)) echo "<p style='color:red;'>$error</p>"; ?>
            <form action="login.php" method="POST">
                <input type="text" name="username" placeholder="Username" required><br><br>
                <input type="password" name="password" placeholder="Password" required><br><br>
                <button type="submit">Login</button>
            </form>
        </div>
    </div>

    <?php include 'includes/footer.php'; ?> <!-- Include the footer -->
</body>
</html>