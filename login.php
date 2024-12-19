<?php
session_start();

// Hardcoded credentials (replace with database validation if needed)
$adminUser = "admin";
$adminPass = "password123";

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    if ($username === $adminUser && $password === $adminPass) {
        $_SESSION['logged_in'] = true;
        header('Location: admin.php');
        exit;
    } else {
        $error = "Invalid username or password.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f4f4;
            padding: 50px;
        }
        form {
            max-width: 300px;
            margin: auto;
            padding: 20px;
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }
        form input, form button {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
        }
        form button {
            background: #007BFF;
            color: #fff;
            border: none;
            cursor: pointer;
        }
        form button:hover {
            background: #0056b3;
        }
        .error {
            color: red;
            font-size: 0.9em;
        }
    </style>
</head>
<body>
    <form method="post">
        <h2>Admin Login</h2>
        <?php if (isset($error)) echo "<p class='error'>$error</p>"; ?>
        <input type="text" name="username" placeholder="Username" required>
        <input type="password" name="password" placeholder="Password" required>
        <button type="submit">Login</button>
    </form>
</body>
</html>
