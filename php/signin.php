<?php
session_start();
include 'db.php';

// Ensure this is a POST request
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = test_input($_POST['email']);
    $password = test_input($_POST['password']);

    // Use a prepared statement to prevent SQL injection
    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 0) {
        // User not found 
        http_response_code(400); // Set a 400 Bad Request status code 
    } else {
        $row = $result->fetch_assoc();
        if (password_verify($password, $row['pwd'])) {
            // Password is correct, set session variables
            $_SESSION['id'] = $row['id'];
            http_response_code(200);
        } else {
            // Incorrect password
            http_response_code(400); // Set a 400 Bad Request status code
    }
}
}
 else {
    // Invalid request method
    http_response_code(405); // Set a 405 Method Not Allowed status code
}

function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
?>
