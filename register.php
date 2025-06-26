<?php
    if (
        isset($_POST['fname']) && isset($_POST['lname']) &&
        isset($_POST['email']) && isset($_POST['phno']) &&
        isset($_POST['pass']) && isset($_POST['cpass'])
    ) {
        if ($_POST['pass'] != $_POST['cpass']) {
            echo '<script>alert("Password Mismatch")</script>';
            exit;
        }

        // Connect to database
        $connect = new mysqli('localhost', 'root', '', 'bus');

        if ($connect->connect_error) {
            echo 'System_range';
            exit;
        }

        // Validate password: at least 6 characters, at least one special character
    $password = $_POST['pass'];
    if (strlen($password) < 6) {
        echo '<script>alert("Password must be at least 6 characters long.")</script>';
        exit;
    }
    if (!preg_match('/[^a-zA-Z0-9]/', $password)) {
        echo '<script>alert("Password must contain at least one special character.")</script>';
        exit;
    }

        // Passwords in PHP are case sensitive by default
        $hashed_pass = password_hash($_POST['pass'], PASSWORD_DEFAULT);

        // Use prepared statement to avoid SQL injection
        $stmt = $connect->prepare("INSERT INTO new_user (fname, lname, email, phno, pass) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", $_POST['fname'], $_POST['lname'], $_POST['email'], $_POST['phno'], $hashed_pass);

        if ($stmt->execute()) {
            $stmt->close();
            $connect->close();
            echo '<script>
                alert("Your registration has been successfully done.");
                window.location.href = "main.php";
            </script>';
            exit;

        } else {
            echo 'insert_failed';
            $stmt->close();
            $connect->close();
        }
        // No additional code needed here, as the success popup and redirect are already handled above.
    } else {
        echo "missing_fields";
    }
?>
