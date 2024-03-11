<?php

session_start();
require "functions.php";
// cek cookie
if (isset($_COOKIE['id']) && isset($_COOKIE['key'])) {
    $id = $_COOKIE['id'];
    $key = $_COOKIE['key'];

    // ambil username berdasarkan id
    $result = mysqli_query($conn, "SELECT username FROM user WHERE id = $id");

    $row = mysqli_fetch_assoc($result);

    // check cookie dan username
    if ($key === hash('sha256', $row['username'])) {
        $_SESSION['login'] = true;
    }
}

if (isset($_SESSION["login"])) {
    header("Location: index.php");
    exit;
}



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

            // check remember me
            if (isset($_POST["rememberme"])) {
                // buat cookie
                setcookie('id', $row['id'], time() + 60);
                setcookie('key', hash('sha256', $row['username']), time() + 60);
            }
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
                <input type="checkbox" name="rememberme">
                <label for="rememberme">Remember Me</label>
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