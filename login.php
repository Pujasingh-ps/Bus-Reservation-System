<?php
if (isset($_POST['email']) && isset($_POST['pass'])) {
    $email = $_POST['email'];
    $pass = $_POST['pass'];

    // Connect to the database
    $connect = new mysqli('localhost', 'root', '', 'bus');

    if ($connect->connect_error) {
        echo 'System_error';
        exit;
    }

    // Use prepared statement to prevent SQL injection
    $stmt = $connect->prepare("SELECT pass FROM new_user WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();

    $stmt->store_result();

    if ($stmt->num_rows === 1) {
        $stmt->bind_result($hashed_password);
        $stmt->fetch();

        // Verify the password
        if (password_verify($pass, $hashed_password)) {
            // Redirect on success
            header("Location: html/home.html");
            exit;
        } else {
            echo "Incorrect password";
        }
    } else {
        echo "User not found";
    }

    $stmt->close();
    $connect->close();
} else {
    echo "Please enter email and password";
}
?>
