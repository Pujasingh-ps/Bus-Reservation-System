<?php
if (isset($_POST['name'])) {
    $name = trim($_POST['name']); // Trim input to remove unnecessary whitespace

    // Validate input
    if (empty($name)) {
        echo json_encode(['status' => 0, 'message' => 'Name cannot be empty.']);
        exit;
    }

    // Establish database connection
    $con = new mysqli('localhost', 'root', '', 'go');
    if ($con->connect_error) {
        echo json_encode(['status' => 0, 'message' => 'Database connection failed.']);
        exit;
    }

    // Use prepared statement to prevent SQL injection
    $stmt = $con->prepare("INSERT INTO q (name) VALUES (?)");
    if ($stmt) {
        $stmt->bind_param('s', $name);

        if ($stmt->execute()) {
            echo json_encode(['status' => 1, 'message' => 'Data inserted successfully.']);

            // Retrieve and display all data from the `q` table
            $result = $con->query("SELECT * FROM q");
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<br>Name: " . htmlspecialchars($row['name']);
                }
            } else {
                echo "<br>No data found.";
            }
        } else {
            echo 'Failed to insert data.';
        }

        $stmt->close();
    } else {
        echo 'Failed to prepare SQL statement.';
    }

    $con->close();
} else {
    echo 'Name parameter not found.';
}
?>
