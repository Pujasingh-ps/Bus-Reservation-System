<?php
if (isset($_POST['source'], $_POST['destination'], $_POST['Ticket_Number'], $_POST['Timing'])) {
    $source = trim($_POST['source']);
    $destination = trim($_POST['destination']);
    $ticketNumber = trim($_POST['Ticket_Number']);
    $timing = trim($_POST['Timing']);

    // Input validation
    if (empty($source) || empty($destination) || empty($ticketNumber) || empty($timing)) {
        echo 'All fields are required.';
        exit;
    }

    // Establish database connection
    $con = new mysqli('localhost', 'root', '', 'bus');
    if ($con->connect_error) {
        echo 'Database connection failed.';
        exit;
    }

    // Use prepared statement to prevent SQL injection
    $stmt = $con->prepare(
        "DELETE FROM user_info WHERE source = ? AND destination = ? AND Ticket_Number = ? AND Timing = ?"
    );

    if ($stmt) {
        $stmt->bind_param('ssss', $source, $destination, $ticketNumber, $timing);

        if ($stmt->execute()) {
            if ($stmt->affected_rows > 0) {
                echo 'Record deleted successfully.';
            } else {
                echo 'No matching record found.';
            }
        } else {
            echo 'Failed to delete the record.';
        }

        $stmt->close();
    } else {
        echo 'Failed to prepare the SQL statement.';
    }

    $con->close();
} else {
    echo 'Invalid input. All fields are required.';
}

?>
