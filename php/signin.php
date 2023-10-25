<?php
session_start();
include 'db.php';

$email = test_input($_POST['email']);
$password = test_input($_POST['password']);

// Use a prepared statement to prevent SQL injection
$stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo "Your email or password is incorrect!";
} else {
    $row = $result->fetch_assoc();
    if (password_verify($password, $row['password'])) {
        // Password is correct, set session variables
        $_SESSION['id'] = $row['id'];
        header("Location: ../index.php");
        exit(); // Terminate script to prevent further execution
    } else {
        echo "Your email or password is incorrect!";
    }
}

function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
?>
