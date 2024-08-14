<?php
// Database configuration
$servername = "localhost";
$username = "root"; 
$password = ""; 
$dbname = "studyspace";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect and sanitize form data
    $name = htmlspecialchars(trim($_POST['name']));
    $email = htmlspecialchars(trim($_POST['email']));
    $subject = htmlspecialchars(trim($_POST['subject']));
    $message = htmlspecialchars(trim($_POST['message']));

    // Validate the inputs (basic example)
    if (!empty($name) && !empty($email) && !empty($subject) && !empty($message) && filter_var($email, FILTER_VALIDATE_EMAIL)) {
        // Prepare and bind
        $stmt = $conn->prepare("INSERT INTO contributions (name, email, subject, message) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $name, $email, $subject, $message);

        // Execute the statement
        if ($stmt->execute()) {
            echo "Thank you, $name! Your contribution has been received.";
        } else {
            echo "Error: " . $stmt->error;
        }

        // Close the statement
        $stmt->close();
    } else {
        echo "Please fill in all fields correctly.";
    }
} else {
    echo "Invalid request method.";
}

// Close the connection
$conn->close();
?>
