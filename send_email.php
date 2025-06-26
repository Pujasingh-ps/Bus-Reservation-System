<?php
// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    // Get and sanitize input values
    $name = trim($_POST["name"]);
    $email = trim($_POST["email"]);
    $message = trim($_POST["message"]);

    // Validate input
    if (empty($name) || empty($email) || empty($message)) {
        die("All fields are required.");
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        die("Invalid email format.");
    }

    // Database configuration
    $host = "localhost";
    $user = "root";
    $pass = "";
    $db   = "bus";

    // Create connection
    $conn = new mysqli($host, $user, $pass, $db);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Prepare and bind
    $stmt = $conn->prepare("INSERT INTO contact_feedback (name, email, message) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $name, $email, $message);

    // Execute and check
    if ($stmt->execute()) {
        echo "<h2>Thank you for your feedback!</h2>";
        echo "<p>Your message has been recorded successfully.</p>";
        echo '<a href="html/home.html">Back to Home Page</a>';
    } else {
        echo "Error: " . $stmt->error;
    }

    // Close
    $stmt->close();
    $conn->close();

} else {
    echo "Invalid request method.";
}
?>
