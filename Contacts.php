<?php
// Database config
require_once __DIR__ . '/vendor/autoload.php';

use Dotenv\Dotenv;

// Load the .env file for environment variables
$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

// Now use the environment variables
$host = $_ENV['DB_HOST'];
$db   = $_ENV['DB_DATABASE'];
$user = $_ENV['DB_USERNAME'];
$pass = $_ENV['DB_PASSWORD'];

// Connect to DB
$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Sanitize inputs
$name = htmlspecialchars(strip_tags(trim($_POST['name'])));
$email = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);
$subject = htmlspecialchars(strip_tags(trim($_POST['subject'])));
$message = htmlspecialchars(strip_tags(trim($_POST['message'])));

// Simple validation
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo "Invalid email format.";
    exit;
}

// Insert into DB
$stmt = $conn->prepare("INSERT INTO submissions (name, email, subject, message) VALUES (?, ?, ?, ?)");
$stmt->bind_param("ssss", $name, $email, $subject, $message);

if ($stmt->execute()) {
    echo "success";
} else {
    echo "Failed to submit";
}

$stmt->close();
$conn->close();
?>
