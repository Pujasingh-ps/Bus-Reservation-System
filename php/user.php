<?php
if (
    isset($_POST['name'], $_POST['last'], $_POST['source'], $_POST['destination'],
          $_POST['adhaar'], $_POST['mobile_no'], $_POST['Time1'], $_POST['Timing'])
) {
    $name = $_POST['name'];
    $middile = $_POST['middile'] ?? '';
    $last = $_POST['last'];
    $email = $_POST['email'] ?? '';
    $mobile = $_POST['mobile_no'];
    $adhaar = $_POST['adhaar'];
    $address = $_POST['address'] ?? '';
    $pin = $_POST['pin'] ?? '';
    $date = $_POST['Time1'];
    $source = $_POST['source'];
    $destination = $_POST['destination'];
    $timing = $_POST['Timing'];
    $gender = $_POST['gender'] ?? '';
    $citizen = $_POST['citizen'] ?? '';

    if (!preg_match('/^\d{12}$/', $adhaar)) {
        die("Error: Aadhaar must be 12 digits.");
    }

    if (!preg_match('/^\d{10}$/', $mobile)) {
        die("Error: Mobile must be 10 digits.");
    }

    $conn = new mysqli("localhost", "root", "", "bus");
    if ($conn->connect_error) {
        die("Database connection failed: " . $conn->connect_error);
    }

    $stmt = $conn->prepare("INSERT INTO user_info (name, middile, last, email, mobile_no, adhaar, address, pin, Time1, source, destination, Timing, gender, citizen) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssssssssssss", $name, $middile, $last, $email, $mobile, $adhaar, $address, $pin, $date, $source, $destination, $timing, $gender, $citizen);

    if ($stmt->execute()) {
        $lastId = $conn->insert_id;
        $ticket = "CIUBUS" . $lastId;
        $conn->query("UPDATE user_info SET Ticket_Number = '$ticket' WHERE id = $lastId");

        echo "<h2>Your Ticket is Booked</h2><hr>";
        echo "Ticket Number: <b>{$ticket}</b><br><hr>";
        echo "Name: <b>{$name} {$last}</b><br>";
        echo "From: <b>{$source}</b> To <b>{$destination}</b><br>";
        echo "Mobile: <b>{$mobile}</b><br>";
        echo "Travel Date: <b>{$date}</b> | Time: <b>{$timing}</b><br><hr>";
        echo "<button onclick='window.print()'>Print Ticket</button>";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
} else {
    echo "Error: All required fields were not submitted.<br>";

}

    echo "<form action='../php/seat_selection.php' method='post'>
        <input type='hidden' name='ticket' value='{$ticket}'>
        <input type='hidden' name='name' value='{$name} {$last}'>
        <input type='hidden' name='source' value='{$source}'>
        <input type='hidden' name='destination' value='{$destination}'>
        <input type='hidden' name='date' value='{$date}'>
        <input type='hidden' name='timing' value='{$timing}'>
        <input type='hidden' name='email' value='{$email}'>
        <button type='submit'>Continue to Seat Selection</button>
      </form>";

?>
