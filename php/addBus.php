<?php
include 'database.php';

if (isset($_POST['busnumber'], $_POST['source'], $_POST['destination'],$_POST['DATE'])) {
    $busNumber = trim($_POST['busnumber']);
    $source = trim($_POST['source']);
    $destination = trim($_POST['destination']);
    $date = trim($_POST['DATE']); // Fix: capture the date

    // Validate input
    if (empty($busNumber) || empty($source) || empty($destination) || empty($date)) {
        echo 'All fields are required.';
        exit;
    }

    // Use prepared statements to prevent SQL injection
    $db = new mysqli('localhost', 'username', 'password', 'bus'); // Update credentials

    if ($db->connect_error) {
        echo 'Database connection failed.';
        exit;
    }

    $stmt = $db->prepare("INSERT INTO bus_details (Bus_number, source, destination, date) VALUES (?, ?, ?, ?)");
    if ($stmt) {
        $stmt->bind_param('ssss', $busNumber, $source, $destination, $date);

        if ($stmt->execute()) {
            echo  'Bus details added successfully.';
        } else {
            echo 'Failed to add bus details.';
        }

        $stmt->close();
    } else {
        echo 'Failed to prepare the SQL statement.';
    }

    $db->close();
} else {
    echo 'Invalid request.';
}

//include 'database.php';

//if (isset($_POST['busnumber'], $_POST['source'], $_POST['destination'],$_POST['DATE'])) {
   // $busNumber = trim($_POST['busnumber']);
    //$source = trim($_POST['source']);
   // $destination = trim($_POST['destination']);
    

    // Validate input
   // if (empty($busNumber) || empty($source) || empty($destination)) {
       // echo 'All fields are required.';
       // exit;
   // }

    // Use prepared statements to prevent SQL injection
    //$db = new mysqli('localhost', 'username', 'password', 'bus'); // Update credentials

   // if ($db->connect_error) {
       // echo 'Database connection failed.';
       // exit;
  //  }

  //  $stmt = $db->prepare("INSERT INTO bus_details (Bus_number, source, destination, date) VALUES (?, ?, ?, ?)");
  //  if ($stmt) {
      //  $stmt->bind_param('sss', $busNumber, $source, $destination);

     //   if ($stmt->execute()) {
     //       echo  'Bus details added successfully.';
      //  } else {
      //      echo 'Failed to add bus details.';
       // }

     //   $stmt->close();
  //  } else {
  //      echo 'Failed to prepare the SQL statement.';
   // }

  //  $db->close();
//} else {
    echo 'Invalid request.';
//}
