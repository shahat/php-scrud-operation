<?php
$error_fields = array();
$conn = mysqli_connect("localhost","root",'',"iti");
if(! $conn){
    echo mysqli_connect_error();  
    exit; 
} 


//select user 
$id = filter_input(INPUT_GET,'id',FILTER_SANITIZE_NUMBER_INT);
$select = "SELECT * FROM `users` WHERE `users`.`id` = " . $id;
$result = mysqli_query($conn, $select);
$row = mysqli_fetch_assoc($result);

if($_SERVER['REQUEST_METHOD'] == 'POST'){

     if(!(isset($_POST['name']) && !empty($_POST['name']) )){
        $error_fields[]="name";
     }
     if(!(isset($_POST['email']) && !empty($_POST['email']) )){
        $error_fields[]="email";
     }
if(!$error_fields){
    // Escape any spacial charachter to avoid the sql injection 
$name = mysqli_escape_string($conn, $_POST["name"]);
$email = mysqli_escape_string($conn, $_POST["email"]);
$password = (!empty($row['password'])) ? sha1($_POST['password']) : $row['password']; 
$admin = (isset($_POST['admin'])) ?  1 : 0 ;  
$query = "UPDATE `users` SET `name` = '{$name}', `email` = '{$email}', `password` = '{$password}', `rule` = '{$admin}' WHERE `id` = {$id}";


if(mysqli_query($conn,$query)){
    echo "this is me before redire";
    header("Location:list.php");
    // as a best practice after redirect you put header
    exit; 
}else{
    //echo $query;
    echo mysqli_error($conn);
}
}
}
//close connection 
mysqli_free_result($result);
mysqli_close($conn);

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit user </title>
</head>

<body>
    <!-- registeration from  -->
    <form method="post">
        <!-- Name  -->
        <Label for="name"> Name </Label>
        <input type="text" name="name" id="name" value="<?=
         (isset($row['name'])) ?  $row['name']:''?>" />
        <?php if(in_array("name", $error_fields)) echo 
         "please enter your name" ?>
        <br>
        <input type="hidden" id='id' name="id" value="<?=
         (isset($row['id'])) ?  $row['id']:'' ?>" />
        <!-- Email -->
        <Label for="email"> email </Label>
        <input type="email" name="email" id="email" value="<?=
         (isset($row['email'])) ?  $row['email']:''  ?>" /> <?php if(in_array("email", $error_fields)) echo 
         "please enter your email" ?>
        <br>
        <!-- Password  -->
        <Label for="password"> Password </Label>
        <input type="password" name="password" id="password" placeholder="password" value="<?=
         (isset($row['password'])) ?  $row['password']:'' ?>" />
        <?php if(in_array("password", $error_fields)) echo 
         "please enter your password not less than 6 " ?>
        <br>
        <input type="checkbox" name="admin" value="admin" <?= ($row['rule']) ? 'checked' : '' ?> />
        <input type="submit" name="submit" value="edit user">

    </form>


</body>

</html>