<?php
session_start();

if (isset($_SESSION["login"])) {
    header("Location: index.php");
    exit;
}

require "functions.php";

if (isset($_POST["login"])) {
    $username = $_POST["username"];
    $password = $_POST["password"];

    $result = mysqli_query($conn, " SELECT * FROM user WHERE username = '$username' ");



    // check username
    if (mysqli_num_rows($result) === 1) {

        //check password
        $row = mysqli_fetch_assoc($result);
        if (password_verify($password, $row["password"])) {
            // set Session
            $_SESSION["login"] = true;
            header("Location: index.php");
            exit;
        }
    }

    $error = true;
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Halaman Login</title>
    <style>
        label {
            display: block;
        }
    </style>
</head>

<body>
    <h1>Halaman Login</h1>
    <form action="" method="post">
        <ul>
            <li>
                <label for="username">Username : </label>
                <input type="text" name="username" id="username">
            </li>
            <li>
                <label for="password">Password</label>
                <input type="password" name="password" id="password">
            </li>
            <li>
                <button type="submit" name="login">LOGIN</button>
            </li>
            <?php if (isset($error)) : ?>
                <p style="color: red;">Username/Password Salah!</p>
            <?php endif; ?>

        </ul>
    </form>
</body>

</html>