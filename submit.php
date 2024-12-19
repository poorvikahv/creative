<?php
// Database configuration
$host = 'localhost';
$dbname = 'contact_form';
$username = 'root'; // Replace with your DB username
$password = '';     // Replace with your DB password

// Establish database connection
try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitize and validate input data
    $name = htmlspecialchars(trim($_POST['name']));
    $email = htmlspecialchars(trim($_POST['email']));
    $message = htmlspecialchars(trim($_POST['message']));

    // Validate required fields
    if (!empty($name) && !empty($email) && !empty($message)) {
        // Validate email format
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            try {
                // Prepare and execute SQL statement
                $stmt = $conn->prepare("INSERT INTO submissions (name, email, message) VALUES (:name, :email, :message)");
                $stmt->bindParam(':name', $name);
                $stmt->bindParam(':email', $email);
                $stmt->bindParam(':message', $message);
                $stmt->execute();

                // Success message
                echo "Thank you for contacting us! Your message has been received.";
            } catch (PDOException $e) {
                // Handle database errors
                echo "Error: Unable to save your message. Please try again later.";
            }
        } else {
            // Invalid email format
            echo "Please enter a valid email address.";
        }
    } else {
        // Missing required fields
        echo "Please fill in all the fields.";
    }
} else {
    // Invalid request method
    echo "Invalid request method.";
}
?>

