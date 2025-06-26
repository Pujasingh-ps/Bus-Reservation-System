<style>
    .home-btn a{
        text-decoration: none;
        font-size: larger;
        color: black;
    }
</style>
<div class="home-btn">
    <button>
        <a href="main.php">Home</a>
    </button>
</div>
<?php
// Database connection
$host = "localhost";
$username = "root";
$password = "";
$database = "bus"; // Change this

$conn = new mysqli($host, $username, $password, $database);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Retrieve POST data
$from = $_POST['from'] ?? '';
$to = $_POST['to'] ?? '';
$date = $_POST['date'] ?? '';

echo "<!DOCTYPE html>
<html>
<head>
    <title>Bus Availability</title>
    <link href='https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css' rel='stylesheet'>
</head>
<body>

<div class='container my-5'>
<h3>Available Buses</h3>";


if (!empty($from) && !empty($to) && !empty($date)) {
    $stmt = $conn->prepare("SELECT * FROM bus_details WHERE source = ? AND destination = ? AND date = ?");
    $stmt->bind_param("sss", $from, $to, $date);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo "<table class='table table-bordered mt-3'>
                <thead>
                    <tr>
                        
                        <th>Bus Number</th>
                        <th>Source</th>
                        <th>Destination</th>
                        <th>Date</th>
                    </tr>
                </thead><tbody>";
        while ($row = $result->fetch_assoc()) {
            echo "<tr>
                    
                    <td>{$row['Bus_number']}</td>
                    <td>{$row['source']}</td>
                    <td>{$row['destination']}</td>
                    <td>{$row['date']}</td>
                  </tr>";
        }
        echo "</tbody></table>";
    } else {
        echo "<p class='text-danger mt-3'>No buses found for the selected route and date.</p>";
    }
    $stmt->close();
} else {
    echo "<p class='text-danger mt-3'>Please fill in all fields.</p>";
}

echo "</div></body></html>";

$conn->close();
?>
