<?php
$ticket = $_POST['ticket'];
$name = $_POST['name'];
$source = $_POST['source'];
$destination = $_POST['destination'];
$date = $_POST['date'];
$timing = $_POST['timing'];
$email = $_POST['email'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Select Seats</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background: #f5f5f5;
      text-align: center;
      margin: 0;
      padding: 20px;
    }
    h2 {
      margin-bottom: 10px;
    }
    .bus-layout {
      display: grid;
      grid-template-columns: repeat(5, 1fr);
      gap: 10px 20px;
      max-width: 500px;
      margin: 0 auto;
      justify-items: center;
    }

    .seat {
      width: 45px;
      height: 45px;
      border-radius: 6px;
      display: flex;
      align-items: center;
      justify-content: center;
      background-color: green;
      color: white;
      font-weight: bold;
      cursor: pointer;
      user-select: none;
    }

    .seat.reserved {
      background-color: red;
      cursor: not-allowed;
    }

    .seat.selected {
      background-color: orange;
    }

    .legend {
      display: flex;
      justify-content: center;
      margin-top: 20px;
      gap: 30px;
      font-size: 14px;
    }

    .legend div {
      display: flex;
      align-items: center;
      gap: 8px;
    }

    .box {
      width: 20px;
      height: 20px;
      border-radius: 4px;
    }

    .reserved-box {
      background-color: red;
    }

    .available-box {
      background-color: green;
    }

    button {
      margin-top: 20px;
      padding: 10px 30px;
      font-size: 16px;
      border: none;
      border-radius: 6px;
      background-color: black;
      color: white;
      cursor: pointer;
    }

    @media (max-height: 800px) {
      html, body {
        height: 100%;
        overflow-y: auto;
      }
    }
  </style>
<?php
// Connect to your database
$conn = new mysqli("localhost", "root", "", "bus");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get reserved seats for this date, timing, source, destination
$date = $conn->real_escape_string($_POST['date']);
$timing = $conn->real_escape_string($_POST['timing']);
$source = $conn->real_escape_string($_POST['source']);
$destination = $conn->real_escape_string($_POST['destination']);

// Query for already booked seats for this trip
$sql = "SELECT seat_number FROM bookings WHERE date='$date' AND timing='$timing' AND source='$source' AND destination='$destination'";
$result = $conn->query($sql);

$reservedSeatsArr = [];
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        // If seat_number is comma separated, explode it
        foreach (explode(',', $row['seat_number']) as $sn) {
            $sn = trim($sn);
            if ($sn !== '') $reservedSeatsArr[] = $sn;
        }
    }
}
$conn->close();
?>
<script>
// Reserved seats from database
const reservedSeats = <?php echo json_encode($reservedSeatsArr); ?>;
</script>
</head>
<body>

<h2>Select Your Seat(s)</h2>
<p>Ticket No: <b><?php echo $ticket; ?></b> | Max <b>25</b> seats</p>

<form id="seatForm" action="payment.php" method="post" onsubmit="return submitSeats()">
  <input type="hidden" name="ticket" value="<?php echo $ticket; ?>">
  <input type="hidden" name="name" value="<?php echo $name; ?>">
  <input type="hidden" name="source" value="<?php echo $source; ?>">
  <input type="hidden" name="destination" value="<?php echo $destination; ?>">
  <input type="hidden" name="date" value="<?php echo $date; ?>">
  <input type="hidden" name="timing" value="<?php echo $timing; ?>">
  <input type="hidden" name="email" value="<?php echo $email; ?>">
  <input type="hidden" name="selected_seats" id="selected_seats">

  <div class="bus-layout" id="seatGrid"></div>

  <button type="button" onclick="showPayment()">Proceed to Payment</button>

</form>

<div class="legend">
  <div><div class="box reserved-box"></div> Reserved</div>
  <div><div class="box available-box"></div> Available</div>
</div>

<!-- Payment Modal -->
<div id="paymentModal" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:#000000b3; justify-content:center; align-items:center; z-index:999;">
  <div style="background:#fff; padding:30px; border-radius:10px; width:90%; max-width:400px; text-align:left; position:relative;">
    <h3 style="margin-top:0;">Payment Details</h3>
    <div id="summaryBox" style="background:#f1f1f1; padding:15px; border-radius:6px; margin-bottom:20px;">
      <p><b>Selected Seats:</b> <span id="summarySeats">-</span></p>
      <p><b>Total Seats:</b> <span id="summaryCount">0</span></p>
      <p><b>Total Amount:</b> ₹<span id="summaryAmount">0</span></p>
    </div>


    <label>Name on Card</label>
    <input type="text" placeholder="John Doe" style="width:100%; margin-bottom:10px; padding:8px;" required>

    <label>Card Number</label>
    <input type="text" placeholder="1234 5678 9012 3456" style="width:100%; margin-bottom:10px; padding:8px;" required>

    <div style="display: flex; gap: 10px; margin-bottom:10px;">
      <div style="flex: 1;">
        <label>CVC</label>
        <input type="text" placeholder="ex. 311" style="width:100%; padding:8px;" required>
      </div>
    </div>

    <label>Expiration</label>
    <div style="display:flex; gap:10px; margin-bottom:15px;">
      <input type="text" placeholder="MM" style="flex:1; padding:8px;" required>
      <input type="text" placeholder="YYYY" style="flex:2; padding:8px;" required>
    </div>


    

    <button type="button" onclick="submitPayment()" style="width:100%; background:#1976d2; color:#fff; padding:10px; margin-top:10px; border:none; border-radius:4px; font-size:16px;">
      Pay »
    </button>


    <button onclick="closePayment()" style="position:absolute; top:10px; right:15px; background:none; border:none; font-size:20px; cursor:pointer;">×</button>
  </div>
</div>
  <script>
  // reservedSeats is already defined from PHP above
  const seatGrid = document.getElementById('seatGrid');
  const selectedSeats = [];
  const maxSeats = 25;
  const pricePerSeat = 300;

  const seatNumbers = [
    '01','02','03','04','05','06','07','08','09','10',
    '11','12','13','14','15','16','17','18','19','20',
    '21','22','23','24','25','26','27','28','29','30',
    '31','32','33','34','35','36','37','38','39','40'
  ];

  // Generate seat layout
  seatNumbers.forEach(num => {
    const seat = document.createElement('div');
    seat.classList.add('seat');
    seat.textContent = num;

    if (reservedSeats.includes(num)) {
      seat.classList.add('reserved');
    } else {
      seat.addEventListener('click', () => {
        if (seat.classList.contains('selected')) {
          seat.classList.remove('selected');
          selectedSeats.splice(selectedSeats.indexOf(num), 1);
        } else {
          if (selectedSeats.length >= maxSeats) {
            alert('Maximum 25 seats allowed');
            return;
          }
          seat.classList.add('selected');
          selectedSeats.push(num);
        }
        document.getElementById('selected_seats').value = selectedSeats.join(',');
      });
    }

    seatGrid.appendChild(seat);
  });

  // Check seat selection
  function submitSeats() {
    if (selectedSeats.length === 0) {
      alert('Please select at least one seat');
      return false;
    }
    return true;
  }

  // Show payment modal
  function showPayment() {
    if (!submitSeats()) return;

    // Fill the summary
    document.getElementById('summarySeats').textContent = selectedSeats.join(', ');
    document.getElementById('summaryCount').textContent = selectedSeats.length;
    document.getElementById('summaryAmount').textContent = selectedSeats.length * pricePerSeat;

    document.getElementById('paymentModal').style.display = 'flex';
  }

  // Close modal
  function closePayment() {
    document.getElementById('paymentModal').style.display = 'none';
  }

  // Final form submission
  function submitPayment() {
    closePayment();
    document.getElementById('seatForm').submit();
  }
</script>



</body>
</html>
