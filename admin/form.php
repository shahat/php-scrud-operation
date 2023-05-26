<!DOCTYPE html>

<?php

$errors_arr = array();
if(isset($_GET['error_fields'])){
    $errors_arr = explode(',',$_GET['error_fields']);
}

?>


<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <!-- registeration from  -->
    <form method="post" action="index.php">
        <Label for="name"> Name </Label>
        <input type="text" name="name" id="name" />
        <?php if(in_array("name", $errors_arr)) echo 
         "please enter your name " ?>
        <br>
        <Label for="email"> email </Label>
        <input type="email" name="email" id="email" />
        <?php if(in_array("name", $errors_arr)) echo 
         "please enter your name" ?>
        <br>
        <Label for="password"> Password </Label>
        <input type="password" name="password" id="password" placeholder="password" />
        <?php if(in_array("password", $errors_arr)) echo 
         "please enter your password not less than 6 " ?>

        <br>


        <label for="gender">Gender</label>
        <input id="male" type="radio" name="gender" value="male" id="">Male
        <input id="female" type="radio" name="gender" value="Female" id="">Female
        <input type="submit" name="submit" value="submit">

    </form>
</body>

</html>