<?php 
// echo "<pre>";
// var_dump($_POST);
// echo "</pre>"
// input back end calidation



$error_fields = array();
if(!(isset($_POST['name'])&& !empty($_POST['name']))){
    $error_fields[]='name';
} 
if(!(isset($_POST['email'])&& filter_input(INPUT_POST, 'email',FILTER_VALIDATE_EMAIL))){
    $error_fields[]='email';
} 
if(!(isset($_POST['password'])&& strlen($_POST['password']) > 5 )){
    $error_fields[]='password';
} 
if($error_fields){
    header("Location:form.php?error_fields=".implode(",", $error_fields));
    exit;
} 
// connect to db to save data 
$conn = mysqli_connect("localhost","root",'',"iti");

if(! $conn){
    echo mysqli_connect_error(); // this return the error that happen in the connection 
    exit; // this for exit the script from continue 
}

// Escape any spacial charachter to avoid the sql injection 
$name = mysqli_escape_string($conn, $_POST["name"]);
$email = mysqli_escape_string($conn, $_POST["email"]);
$password = mysqli_escape_string($conn, $_POST["password"]);

// insert the data 
$query = "INSERT INTO `users` (`id`, `name`, `email`, `password`, `rule`) VALUES (NULL, '{$name}', '{$email}', '{$password}', '');";
if(mysqli_query($conn,$query)){
    echo "thank you , you information is saved ";
     
}
else{
    echo $query;
    echo mysqli_error($conn);
}
// close conn
mysqli_close($conn);






?>