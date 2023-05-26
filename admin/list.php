<?php 
//open connection
$conn = mysqli_connect("localhost", "root", "","iti");
if(! $conn){
    echo mysqli_connect_error(); // this return the error that happen in the connection 
    exit; // this for exit the script from continue 
}
// do the operation ( select and insert)and
$query = "SELECT * from users";

/* mysqli_fetch_assoc()  fetches a result row as an associative array */

if(isset($_GET['search'])){
    $search = mysqli_escape_string($conn , $_GET['search']);
    $query .= " WHERE `users`.`name` LIKE '%" . $search . "%' OR `users`.`email` LIKE '%" . $search . "%'";

}


$result = mysqli_query($conn , $query);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <h1> Admin :: List users </h1>
    <form method="GET">
        <input type="text" name="search" id="search" placeholder="ENTER Name or Email to search ">
        <input type="submit" value="search">
    </form>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>avatar</th>
                <th>Admin</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php while($row=mysqli_fetch_assoc($result)){
            ?>
            <tr>
                <td><?= $row['id'] ?></td>
                <td><?= $row['name'] ?></td>
                <td><?= $row['email'] ?></td>
                <td>
                    <?php if ($row['avatar']) { ?>
                    <img src="../uploads/<?= $row['avatar'] ?>" style="width:100px;height:100px" />
                    <?php } else { ?>
                    <span>no image</span>
                    <?php } ?>

                </td>
                <td><?= $row['rule'] ? 'yes' : 'No' ?></td>
                <td> <a href="edit.php?id=<?=$row['id'] ?>">Edit</a> |
                    <a href="delete.php?id=<?=$row['id'] ?>">Delete</a>
            </tr>

            <?php  } ?>

        </tbody>
        <tfoot>
            <td colspan="2" style="text-align:center"><?= mysqli_num_rows($result)?> user</td>
            <td colspan="3" style="text-align:center"><a href="add.php">addUser</a></td>
        </tfoot>
    </table>
</body>

</html>

<?php
// close the connection
mysqli_free_result($result);
mysqli_close($conn);
?>