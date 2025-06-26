<?php
include 'database.php';

if (isset($_POST['from'], $_POST['to'])) {
    $source = trim($_POST['from']);
    $destination = trim($_POST['to']);

    // Validate inputs
    if (empty($source) || empty($destination)) {
        echo json_encode(['status' => 0, 'message' => 'Source and destination are required.']);
        exit;
    }

    // Establish database connection
    $db = new mysqli('localhost', 'username', 'password', 'bus'); // Update with actual credentials

    if ($db->connect_error) {
        echo 'Database connection failed.';
        exit;
    }

    // Use prepared statement to prevent SQL injection
    $stmt = $db->prepare("SELECT Bus_number FROM Bus_details WHERE source = ? AND destination = ?");
    if ($stmt) {
        $stmt->bind_param('ss', $source, $destination);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            // Fetch all matching bus numbers
            $buses = [];
            while ($row = $result->fetch_assoc()) {
                $buses[] = $row['Bus_number'];
            }
            echo json_encode(['status' => 1, 'buses' => $buses]);
        } else {
            echo json_encode(['status' => 0, 'message' => 'No buses found.']);
        }

        $stmt->close();
    } else {
        echo 'Failed to prepare the SQL statement.';
    }

    $db->close();
} else {
    echo 'Invalid request.';
}
?>
