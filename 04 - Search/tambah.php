<?php
require "functions.php";

// koneksi ke DBMS
$conn = mysqli_connect("localhost", "root", "root", "learn_php_basic");


// cek apakah tombol submit sudah ditekan atau belum
if (isset($_POST["submit"])) {

    // cek keberhasilan input data
    if (tambah($_POST) > 0) {
        echo "
                <script>
                    alert('DATA BERHASIL DITAMBAHKAN!');
                    document.location.href = 'index.php';
                </script>
        ";
    } else {
        echo "
                <script>
                    alert('DATA GAGAL DITAMBAHKAN!');
                    document.location.href = 'index.php';
                </script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Data Mahasiswa</title>
</head>

<body>
    <h1>Tambah Data Mahasiswa</h1>

    <form action="" method="post">
        <ul>
            <li>
                <label for="nim">NIM : </label>
                <input type="text" name="nim" id="nim" required>
            </li>
            <li>
                <label for="nama">Nama : </label>
                <input type="text" name="nama" id="nama" required>
            </li>
            <li>
                <label for="email">Email : </label>
                <input type="email" name="email" id="email" required>
            </li>
            <li>
                <label for="jurusan">Jurusan : </label>
                <input type="text" name="jurusan" id="jurusan" required>
            </li>
            <li>
                <label for="gambar">Gambar : </label>
                <input type="text" name="gambar" id="gambar" required>
            </li>
            <li>
                <button type="submit" name="submit">Tambah Data</button>
            </li>
        </ul>
    </form>
</body>

</html>