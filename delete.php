<?php
session_start();
require 'db.php';


if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    
    // Fetch the file path from the database
    $sql = "SELECT file_path FROM uploads WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $file_path = $row['file_path'];
        
        // Delete the file from the server
        if (file_exists('uploads/' . $file_path)) {
            unlink('uploads/' . $file_path); // Deletes the file
        }
        
        // Delete the entry from the database
        $delete_sql = "DELETE FROM uploads WHERE id = ?";
        $delete_stmt = $conn->prepare($delete_sql);
        $delete_stmt->bind_param('i', $id);
        $delete_stmt->execute();
        
        header("Location: admin.php");
        exit();
    } else {
        echo "File not found.";
    }
} else {
    echo "Invalid request.";
}
?>
