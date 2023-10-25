<?php
session_start();
include 'db.php';

$username = test_input($_POST['username']);
$email = test_input($_POST['email']);
$password = test_input($_POST['password']);

// Check if the username or email already exists in the database
$stmt = $conn->prepare("SELECT * FROM users WHERE username = ? OR email = ?");
$stmt->bind_param("ss", $username, $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    echo "A user with that username or email already exists!";
} else {
    // Hash the password before storing it in the database
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Use a prepared statement to prevent SQL injection
    $stmt = $conn->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $username, $email, $hashed_password);
    $stmt->execute();

    // Redirect the user to the login page
    header("Location: signin.php");
    exit(); // Terminate script to prevent further execution
}

function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
?>