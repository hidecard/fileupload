<?php
session_start();
require 'db.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - File List</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
    <div class="container mt-5">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2>Uploaded Files</h2>
        </div>
        <table class="table table-bordered" id="fileTable">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>File Name</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody id="fileTableBody">
                <!-- Data will be populated by JavaScript -->
            </tbody>
        </table>
    </div>

    <script>
        // Function to fetch and update the table data without reloading
        function fetchUploads() {
            const xhr = new XMLHttpRequest();
            xhr.open('GET', 'get_uploads.php', true);
            xhr.onload = function() {
                if (xhr.status === 200) {
                    const uploads = JSON.parse(xhr.responseText);

                    // Get the table body
                    const tableBody = document.getElementById('fileTableBody');
                    tableBody.innerHTML = ''; // Clear the current table rows

                    // Loop through the uploaded files and add rows dynamically
                    uploads.forEach(file => {
                        const row = document.createElement('tr');

                        row.innerHTML = `
                            <td>${file.id}</td>
                            <td>${file.file_name}</td>
                            <td>
                                <a href="download.php?file=${encodeURIComponent(file.file_path)}" class="btn btn-success btn-sm">Download</a>
                                <a href="delete.php?id=${encodeURIComponent(file.id)}" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this file?');">Delete</a>
                            </td>
                        `;

                        // Append the row to the table body
                        tableBody.appendChild(row);
                    });
                }
            };
            xhr.send();
        }

        // Fetch the uploads when the page loads
        window.onload = function() {
            fetchUploads();

            // You can set an interval to keep fetching new data every few seconds (optional)
            setInterval(fetchUploads, 5000); // Refresh every 5 seconds
        };
    </script>
</body>
</html>
