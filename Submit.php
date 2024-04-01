<?php
// Assuming the incoming request is JSON,
// decode it to an associative array.
$data = json_decode(file_get_contents('php://input'), true);

// Check if data has been received
if ($data) {
    // Extract and sanitize the name and email
    $name = strip_tags(trim($data['name']));
    $email = filter_var($data['email'], FILTER_SANITIZE_EMAIL);
    
    // Prepare the data string to write
    $logEntry = "Name: " . $name . ", Email: " . $email . "\n";
    
    // Specify the file to store submissions
    $file = "submissions.txt";
    
    // Try to append the data to the file
    if (file_put_contents($file, $logEntry, FILE_APPEND | LOCK_EX)) {
        // Send a JSON response back
        echo json_encode(['message' => 'Thank you for your submission!']);
    } else {
        // Send a JSON error message if unable to write to the file
        echo json_encode(['message' => 'Sorry, there was an error saving your submission.']);
    }
} else {
    // Send a JSON error message if no data is received
    echo json_encode(['message' => 'No data received.']);
}
?>
