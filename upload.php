<?php
require 'db.php';

// Handle file upload
if (isset($_FILES['file'])) {
    $file_name = basename($_FILES['file']['name']);
    $file_tmp = $_FILES['file']['tmp_name'];
    $file_path = 'uploads/' . $file_name;

    // Sanitize file name
    $file_name = preg_replace("/[^a-zA-Z0-9\._-]/", "", $file_name);

    // Move file to uploads folder
    if (move_uploaded_file($file_tmp, $file_path)) {
        // Insert file information into the database
        $sql = "INSERT INTO uploads (file_name, file_path) VALUES ('$file_name', '$file_path')";
        if ($conn->query($sql)) {
            echo '<div class="alert alert-success">File uploaded successfully!</div>';
        } else {
            echo '<div class="alert alert-danger">Failed to save file info in the database.</div>';
        }
    } else {
        echo '<div class="alert alert-danger">Failed to upload the file.</div>';
    }
    exit; // End the script to avoid HTML response
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload a File</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
    <div class="container mt-5">
        <h2 class="text-center">Upload a File</h2>
        
        <!-- Display success or error messages -->
        <div id="message"></div>
        
        <!-- File upload form -->
        <form id="uploadForm" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="file" class="form-label">Choose file:</label>
                <input type="file" class="form-control" id="file" name="file" required>
            </div>
            <button type="submit" class="btn btn-primary w-100">Upload</button>
        </form>
    </div>

    <script>
        // Handle form submission with AJAX
        document.getElementById('uploadForm').addEventListener('submit', function(event) {
            event.preventDefault(); // Prevent default form submission
            
            // Create a FormData object to hold the form data
            var formData = new FormData(this);
            
            // AJAX request to upload file
            var xhr = new XMLHttpRequest();
            xhr.open('POST', 'upload.php', true);

            xhr.onload = function() {
                if (xhr.status === 200) {
                    // Show the response message (success or error)
                    document.getElementById('message').innerHTML = xhr.responseText;

                    // Optionally, you can add any code to clear the file input field
                    document.getElementById('file').value = '';
                } else {
                    document.getElementById('message').innerHTML = 'An error occurred during file upload.';
                }
            };

            xhr.send(formData); // Send the form data via AJAX
        });
    </script>
</body>
</html>
