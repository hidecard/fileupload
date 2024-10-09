<?php
require 'db.php';

if (isset($_POST['upload'])) {
    $file_name = $_FILES['file']['name'];
    $file_tmp = $_FILES['file']['tmp_name'];
    $file_path = 'uploads/' . $file_name;

    if (move_uploaded_file($file_tmp, $file_path)) {
        $sql = "INSERT INTO uploads (file_name, file_path) VALUES ('$file_name', '$file_path')";
        if ($conn->query($sql)) {
            $success = "File uploaded successfully!";
        } else {
            $error = "Failed to save file info in database.";
        }
    } else {
        $error = "Failed to upload file.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>File Upload</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    </head>
<body>
    <div class="container mt-5">
        <h2 class="text-center">Upload a File</h2>
        <?php if (isset($success)) { ?>
            <div class="alert alert-success"><?= $success ?></div>
        <?php } elseif (isset($error)) { ?>
            <div class="alert alert-danger"><?= $error ?></div>
        <?php } ?>
        <form action="index.php" method="POST" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="file" class="form-label">Choose file:</label>
                <input type="file" class="form-control" id="file" name="file" required>
            </div>
            <button type="submit" name="upload" class="btn btn-primary w-100">Upload</button>
        </form>
    </div>
</body>
</html>
