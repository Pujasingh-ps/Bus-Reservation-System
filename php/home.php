<?php
echo "........................................PASSENGER INFORMATION.................................<br>";

if (isset($_POST['Ticket_Number']) && isset($_POST['source']) && isset($_POST['destination'])) {
    // Sanitize input
    $ticketNumber = trim($_POST['Ticket_Number']);
    $source = trim($_POST['source']);
    $destination = trim($_POST['destination']);

    // Establish database connection
    $conn = new mysqli('localhost', 'root', '', 'bus');

    if ($conn->connect_error) {
        die('Database connection failed.');
    }

    // Use prepared statement to prevent SQL injection
    $stmt = $conn->prepare(
        "SELECT Ticket_Number, name, last, source, destination, adhaar, mobile_no, Time1 FROM user_info 
        WHERE source = ? AND destination = ? AND Ticket_Number = ?"
    );

    if ($stmt) {
        $stmt->bind_param('sss', $source, $destination, $ticketNumber);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<hr><b>Ticket-Number  ---></b> " . htmlspecialchars($row['Ticket_Number']) . "<br>";
                echo "<b>Passenger Name ---></b> " . htmlspecialchars($row['name']) . " " . htmlspecialchars($row['last']) . "<br>";
                echo "<b>Source ---></b> " . htmlspecialchars($row['source']) . " <b>To</b> " . htmlspecialchars($row['destination']) . "<br>";
                echo "<b>Adhaar-Number ---></b> " . substr(htmlspecialchars($row['adhaar']), 0, 4) . "********<br>";
                echo "<b>Mobile Number ---></b> **********<br>";
                echo "<b>Date ---></b> " . htmlspecialchars($row['Time1']) . "<br>";
            }
        } else {
            echo "No passenger information found for the provided details.";
        }

        $stmt->close();
    } else {
        echo "Failed to prepare the SQL statement.";
    }

    $conn->close();
} else {
    echo "Please provide Ticket Number, Source, and Destination.";
}

echo '<br><button class="button" type="submit"><a href="../html/home.html">Back to Home Page</a></button>';
?>
