<?php 
//---------------input validation---------------//
$error_fields = array();
if($_SERVER['REQUEST_METHOD'] == 'POST'){
if(!(isset($_POST['name'])&& !empty($_POST['name']))){
    $error_fields[]='name';
} 
if(!(isset($_POST['email'])&& filter_input(INPUT_POST, 'email',FILTER_VALIDATE_EMAIL))){
    $error_fields[]='email';
} 
if(!(isset($_POST['password'])&& strlen($_POST['password']) > 5 )){
    $error_fields[]='password';
} 
//--------------- Open Connection ---------------//
if(!$error_fields){
$conn = mysqli_connect("localhost","root",'',"iti");
if(! $conn){
    echo mysqli_connect_error();  
    exit; 
} 

//---------------Escape any spacial charachter to avoid the sql injection---------------//

$name = mysqli_real_escape_string($conn, $_POST["name"]);
$email = mysqli_real_escape_string($conn, $_POST["email"]);
$password = sha1($_POST["password"]);
$admin = (isset($_POST['admin'])) ? 1 : 0;


//--------------- upload files---------------//C:/xampp/htdocs
$uploads_dir = $_SERVER['DOCUMENT_ROOT'].'/crud/uploads/';
$avatar = '';
if ($_FILES['avatar']['error'] == UPLOAD_ERR_OK) {
    $temp_name = $_FILES["avatar"]['tmp_name'];
    $avatar = basename($_FILES['avatar']['name']);
    move_uploaded_file($temp_name, "$uploads_dir/$name.$avatar");
    echo " file uploaded successfully";
} else {
    echo "File can't be uploaded";
    sleep(1);
}

$query = "INSERT INTO `users` (`id`, `name`, `email`, `password`, `rule`, `avatar`) VALUES (NULL, '$name', '$email', '$password', '$admin', '$name.$avatar')";

if (mysqli_query($conn, $query) ) {
    echo "Redirecting...";
    sleep(3);
    header("Location: list.php");
    exit;
} else {
    echo mysqli_error($conn);
}



//--------------- close Connection ---------------//
mysqli_close($conn);
}
}
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="add.css">
    <title> Admin :: Add user </title>
</head>

<body>
    <div class="container">
        <!-- registeration from  -->
        <form method="post" enctype="multipart/form-data">
            <!-- Name  -->
            <Label for="name"> Name </Label>
            <input type="text" name="name" id="name" value="<?=
         (isset($_POST['name'])) ?  $_POST['name']:''  ?>" />
            <?php if(in_array("name", $error_fields)) echo 
         "please enter your name " ?>
            <br>
            <!-- Email -->
            <Label for="email"> email </Label>
            <input type="email" name="email" id="email" value="<?= (isset($_POST['email'])) ?  $_POST['email']:'' ?>" />
            <?php if(in_array("name", $error_fields)) echo "please enter your name" ?>
            <br>
            <!-- Password  -->
            <Label for="password"> Password </Label>
            <input type="password" name="password" id="password" placeholder="password" value="<?=
         (isset($_POST['email'])) ?  $_POST['email']:''  ?>" />
            <?php if(in_array("password", $error_fields)) echo 
         "please enter your password not less than 6 " ?>
            <br>
            <input type="file" name="avatar" /></br>
            <label><input type="checkbox" name="admin" value="admin"
                    <?= (isset($_POST['admin'])) ? 'checked' : '' ?> />admin</label></br>

            <input type="submit" name="submit" value="Add user">

        </form>


    </div>

</body>

</html>