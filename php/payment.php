<?php
// Include FPDF
require('../php/fpdf/fpdf.php');

// Fetch booking details from form
$ticket = $_POST['ticket'];
$name = $_POST['name'];
$source = $_POST['source'];
$destination = $_POST['destination'];
$date = $_POST['date'];
$timing = $_POST['timing'];
$seats = $_POST['selected_seats'];
$email = $_POST['email'];

// Connect to database to check seat availability
$conn = new mysqli("localhost", "root", "", "bus");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Sanitize values
$escaped_date = $conn->real_escape_string($date);
$escaped_timing = $conn->real_escape_string($timing);
$escaped_source = $conn->real_escape_string($source);
$escaped_destination = $conn->real_escape_string($destination);
$selected_seats = explode(',', $seats);

// Fetch already booked seats for this trip
$sql = "SELECT seat_number FROM bookings WHERE date='$escaped_date' AND timing='$escaped_timing' AND source='$escaped_source' AND destination='$escaped_destination'";
$result = $conn->query($sql);

$already_booked = [];
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        foreach (explode(',', $row['seat_number']) as $seat) {
            $already_booked[] = trim($seat);
        }
    }
}

// Check for conflicts
$conflict = array_intersect($selected_seats, $already_booked);

if (count($conflict) > 0) {
    echo "<h2 style='color:red;'>❌ Error: These seats are already booked: " . implode(', ', $conflict) . "</h2>";
    echo "<a href='javascript:history.back()'><button>Go Back</button></a>";
    exit;
}

// Save the booking in the database
$stmt = $conn->prepare("INSERT INTO bookings (ticket, name, source, destination, date, timing, email, seat_number) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
$stmt->bind_param("ssssssss", $ticket, $name, $source, $destination, $date, $timing, $email, $seats);

if ($stmt->execute()) {
    $msg = "✅ Ticket generated successfully";
} else {
    echo "<h2 style='color:red;'>❌ Booking failed: " . $stmt->error . "</h2>";
    echo "<a href='javascript:history.back()'><button>Try Again</button></a>";
    exit;
}

$stmt->close();
$conn->close();



// Generate PDF ticket
$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 16);
$pdf->Cell(0, 10, 'CIUBUS TICKET', 0, 1, 'C');
$pdf->SetFont('Arial', '', 12);
$pdf->Ln(10);
$pdf->Cell(0, 10, "Ticket Number: $ticket", 0, 1);
$pdf->Cell(0, 10, "Name: $name", 0, 1);
$pdf->Cell(0, 10, "From: $source to $destination", 0, 1);
$pdf->Cell(0, 10, "Date: $date    Time: $timing", 0, 1);
$pdf->Cell(0, 10, "Selected Seats: $seats", 0, 1);
$pdf->Ln(10);
$pdf->MultiCell(0, 10, "Please carry a valid ID and show this ticket at boarding.\nThank you for booking with CIUBUS!");

$ticketPath = "../tickets/$ticket.pdf";
$pdf->Output('F', $ticketPath); // Save to file

$msg = "✅ Ticket generated successfully";
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Ticket Confirmed</title>
  <style>
    body {
      font-family: Arial;
      padding: 40px;
      background: #f5f5f5;
      text-align: center;
    }
    .card {
      max-width: 600px;
      margin: auto;
      background: white;
      padding: 30px;
      border-radius: 10px;
      box-shadow: 0 0 10px #ccc;
    }
    button {
      padding: 10px 30px;
      margin-top: 20px;
      font-size: 16px;
      border: none;
      border-radius: 5px;
      background-color: black;
      color: white;
      cursor: pointer;
    }
  </style>
</head>
<body>
<div class="card">
  <h2>🎫 Ticket Booked Successfully</h2>
  <p><strong>Ticket No:</strong> <?php echo $ticket; ?></p>
  <p><strong>Name:</strong> <?php echo $name; ?></p>
  <p><strong>From:</strong> <?php echo $source; ?> → <strong>To:</strong> <?php echo $destination; ?></p>
  <p><strong>Date:</strong> <?php echo $date; ?> | <strong>Time:</strong> <?php echo $timing; ?></p>
  <p><strong>Seats:</strong> <?php echo $seats; ?></p>
  <p><?php echo $msg; ?></p>

  <button onclick="window.print()">🖨️ Print</button><br><br>
  <a href="../html/home.html"><button>Back to Home</button></a>
</div>
</body>
</html>