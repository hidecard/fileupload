<?php
require 'db.php';

// Fetch the uploaded files from the database
$sql = "SELECT * FROM uploads";
$result = $conn->query($sql);

$uploads = [];
while($row = $result->fetch_assoc()) {
    $uploads[] = $row;
}

// Return the data as JSON
header('Content-Type: application/json');
echo json_encode($uploads);
