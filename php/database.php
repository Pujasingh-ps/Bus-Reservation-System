<?php
function query($query, $database, $params = [])
{
    $con = new mysqli('localhost', 'root', '', $database);

    if ($con->connect_error) {
        die(json_encode(['status' => 0, 'message' => 'Database connection failed.']));
    }

    $stmt = $con->prepare($query);

    if ($stmt && !empty($params)) {
        $types = str_repeat('s', count($params)); // Assuming all parameters are strings
        $stmt->bind_param($types, ...$params);
    }

    if (!$stmt->execute()) {
        $con->close();
        die(json_encode(['status' => 0, 'message' => 'Query execution failed.']));
    }

    $result = $stmt->get_result();
    $stmt->close();
    $con->close();
    return $result;
}

function isUser($username, $password)
{
    // Use prepared statement to prevent SQL injection
    $result = query(
        "SELECT userid FROM users WHERE BINARY username = ? AND password = ?",
        'bus1',
        [$username, $password]
    );

    return $result->num_rows === 1 ? 1 : 0;
}

function getUserId($username)
{
    // Use prepared statement
    $result = query(
        "SELECT userid FROM users WHERE BINARY username = ?",
        'bus1',
        [$username]
    );

    if ($result->num_rows === 1) {
        $row = $result->fetch_assoc();
        return $row['userid'];
    }
    return null;
}

function isAdmin($username, $password)
{
    // Use prepared statement
    $result = query(
        "SELECT * FROM admin WHERE BINARY username = ? AND password = ?",
        'bus1',
        [$username, $password]
    );

    return $result->num_rows === 1 ? 1 : 0;
}
?>
