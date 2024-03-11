<?php
require "functions.php";

if (isset($_POST["register"])) {
    if (register($_POST) > 0) {
        echo
        "
        <script>
            alert('Registrasi Berhasil!');
        </script>
        ";
    } else {
        echo mysqli_error($conn);
    }
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Halaman Registrasi</title>
    <style>
        label {
            display: block;
        }
    </style>
</head>

<body>
    <h1>Halaman Registrasi</h1>

    <form action="" method="post">
        <ul>
            <li>
                <label for="username">Username : </label>
                <input type="text" id="username" name="username">
            </li>
            <li>
                <label for="password">Password : </label>
                <input type="password" id="password" name="password">
            </li>
            <li>
                <label for="passwordConfirm">Konfirmasi Password :</label>
                <input type="password" id="passwordConfirm" name="passwordConfirm">
            </li>
            <li>
                <button type="submit" name="register">SIGN UP</button>
            </li>
        </ul>
    </form>
</body>

</html>