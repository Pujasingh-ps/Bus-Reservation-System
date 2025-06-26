<?php
include 'database.php';

if (isset($_POST['busnumber'])) {
    $busNumber = trim($_POST['busnumber']); // Sanitize input

    // Database connection
    $conn = new mysqli('localhost', 'root', '', 'bus');

    if ($conn->connect_error) {
        die("Database connection failed: " . $conn->connect_error);
    }

    // Use prepared statement to prevent SQL injection
    $stmt = $conn->prepare("DELETE FROM bus_details WHERE binary bus_number = ?");
    $stmt->bind_param("s", $busNumber);

    if ($stmt->execute()) {
        echo "1"; // Success
    } else {
        echo "0"; // Failure
    }

    $stmt->close();
    $conn->close();
} else {
    echo "Bus number not provided.";
}
?>
