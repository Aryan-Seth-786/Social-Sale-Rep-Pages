<?php
header('Content-Type: application/json');

// Database configuration
$host = 'localhost'; // Or your MySQL host
$dbname = 'your_database_name';
$username = 'your_username';
$password = 'your_password';

// Create connection
$conn = new mysqli($host, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Retrieve data from request
$data = json_decode(file_get_contents('php://input'), true);
$name = $conn->real_escape_string($data['name']);
$email = $conn->real_escape_string($data['email']);

// Insert data into database
$sql = "INSERT INTO subscribers (name, email) VALUES ('$name', '$email')";

if ($conn->query($sql) === TRUE) {
    echo json_encode(['message' => 'Data saved successfully']);
} else {
    echo json_encode(['message' => 'Error saving data: ' . $conn->error]);
}

$conn->close();
?>
