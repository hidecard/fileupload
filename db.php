<?php
$host = 'localhost';
$user = 'zklszwhh_yhaexam';  // Change this to your database username
$pass = 'hidecard1500';      // Change this to your database password
$db_name = 'zklszwhh_yhaexam';

$conn = new mysqli($host, $user, $pass, $db_name);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
