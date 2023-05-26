<?php 
//open connection

$conn = mysqli_connect("localhost", "root", "","iti");

if(! $conn){
    echo mysqli_connect_error(); // this return the error that happen in the connection 
    exit; // this for exit the script from continue 
}


// do the operation ( select and insert)and
$query = "SELECT * from users";
$result = mysqli_query($conn , $query);
/* mysqli_fetch_assoc()  fetches a result row as an associative array */


while($row = mysqli_fetch_assoc($result))

{

    echo "Id :".$row['id']."<br>";
    echo "Name :".$row['name']."<br>";
    echo "email :".$row['email']."<br>";
    echo str_repeat("-",50)."<br>";

}


// close connection
mysqli_free_result($result);
mysqli_close($conn);
?>