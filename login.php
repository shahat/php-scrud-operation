<?php
session_start();

// --------------- Input validation ---------------

$error_fields = array();
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (!(isset($_POST['email']) && filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL))) {
        $error_fields[] = 'email';
    }
    if (!(isset($_POST['password']) && strlen($_POST['password']) > 5)) {
        $error_fields[] = 'password';
    }

    // --------------- Open Connection ---------------

    if (empty($error_fields)) {
        $conn = mysqli_connect("localhost", "root", '', "iti");
        if (!$conn) {
            echo mysqli_connect_error();
            exit;
        }

        // --------------- Escape any special characters to avoid SQL injection ---------------

        $email = mysqli_real_escape_string($conn, $_POST["email"]);

        $query = "SELECT * FROM `users` WHERE `email`=?";
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, "s", $email);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if ($result) {
            if (mysqli_num_rows($result) > 0) {
                $row = mysqli_fetch_assoc($result);

                if ($_POST['password'] == $row['password']) {

                    // Creating a session
                    $_SESSION['id'] = $row['id'];
                    $_SESSION['email'] = $row['email'];

                    // Redirect to another page
                    header("Location: /crud/loading/index.php");
                    exit;
                } else {
                    $message = "This Password is invalid ";                }
            } else {
                $message = "This Email is invalid ";
            }
        } else {
            echo "Error executing the query: ".mysqli_error($conn);
        }

        // --------------- Close Connection ---------------
        mysqli_close($conn);
    }
}
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link href="" rel="stylesheet" />
    <link rel="stylesheet" href="login.css">
    <title> Log in </title>
</head>

<body>

    <!-- registration form -->

    <form method="post">
        <!-- Email -->
        <fieldset>
            <label for="email">Email</label>
            <input type="email" name="email" id="email"
                value="<?= (isset($_POST['email'])) ? htmlspecialchars($_POST['email']) : ''; ?>" />
            <?php if (in_array("email", $error_fields)) echo "Please enter a valid email"; ?>
            <br>
            <!-- Password -->
            <label for="password">Password</label>
            <input type="password" name="password" id="password" placeholder="password"
                value="<?= (isset($_POST['password'])) ? htmlspecialchars($_POST['password']) : ''; ?>" />
            <?php if (in_array("password", $error_fields)) echo "Please enter your password (not less than 6 characters)"; ?>
            <br>
            <input type="submit" name="submit" value="Log in">
            <p style="color:red;"><?= $message ?></p>
        </fieldset>

    </form>

</body>

</html>