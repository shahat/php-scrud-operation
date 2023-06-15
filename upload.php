<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $uploads_dir = './uploads/'; // Specify the directory to which you want to upload the files

    // Check if the file was uploaded without errors
    if (isset($_FILES['avatar']) && $_FILES['avatar']['error'] == UPLOAD_ERR_OK) {
        $tmp_name = $_FILES['avatar']['tmp_name'];
        $name = $_FILES['avatar']['name'];
        
        // Move the uploaded file to the desired location
        if (move_uploaded_file($tmp_name, $uploads_dir.$name)) {
            echo 'File uploaded successfully.';
            echo "globals"."<pre>";

            var_dump($GLOBALS)  ;
            echo "globals"."</pre>";
        } else {
            echo 'Error uploading file.';
        }
    } else {
        echo 'File upload error.';
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>File Upload</title>
</head>

<body>
    <form method="post" enctype="multipart/form-data">
        <input type="file" name="avatar">
        <input type="submit" value="Upload">
    </form>
</body>

</html>