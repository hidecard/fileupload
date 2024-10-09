<?php
$host = 'localhost';
$user = '';  // Change this to your database username
$pass = '';      // Change this to your database password
$db_name = '';

$conn = new mysqli($host, $user, $pass, $db_name);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
