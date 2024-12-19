<?php
session_start();

// Check if admin is logged in
if (!isset($_SESSION['logged_in']) || !$_SESSION['logged_in']) {
    header('Location: login.php');
    exit;
}

// Database configuration
$host = 'localhost';
$dbname = 'contact_form';
$username = 'root'; 
$password = '';     

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Fetch submitted data
    $stmt = $conn->query("SELECT * FROM submissions ORDER BY created_at DESC");
    $submissions = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f9f9f9;
            padding: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
            background: #fff;
        }
        table th, table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        table th {
            background: #007BFF;
            color: #fff;
        }
        .logout {
            margin-bottom: 20px;
        }
        .logout a {
            color: #007BFF;
            text-decoration: none;
        }
        .logout a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="logout">
        <a href="logout.php">Logout</a>
    </div>
    <h1>Admin Dashboard</h1>
    <table>
        <tr>
            
            <th>Name</th>
            <th>Email</th>
            <th>Message</th>
            <th>Date</th>
        </tr>
        <?php foreach ($submissions as $submission): ?>
        <tr>
            
            <td><?= htmlspecialchars($submission['name']) ?></td>
            <td><?= htmlspecialchars($submission['email']) ?></td>
            <td><?= htmlspecialchars($submission['message']) ?></td>
            <td><?= htmlspecialchars($submission['created_at']) ?></td>
        </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>
