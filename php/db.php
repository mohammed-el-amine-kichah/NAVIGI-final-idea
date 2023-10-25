<?php
include 'config.php';

// Create a connection to the database
$conn = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Set character set to UTF-8 (optional)
if (!$conn->set_charset("utf8")) {
    printf("Error loading character set utf8: %s\n", $conn->error);
    exit();
}
?>
