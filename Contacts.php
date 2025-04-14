<?php
// Database config
$host = 'localhost';
$db = 'contact_form';
$user = 'root';
$pass = 'root';

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
