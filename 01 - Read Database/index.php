<?php
require "functions.php";
// ambil data dari tabel mahasiswa
$mahasiswa = mysqli_query($conn, "SELECT * FROM mahasiswa");
?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>pertemuan1</title>
</head>

<body>
    <h1>Daftar Mahasiswa</h1>

    <table border="1" cellpadding="10" cellspacing="0">
        <tr>
            <th>No.</th>
            <th>Aksi</th>
            <th>Gambar</th>
            <th>NIM</th>
            <th>Nama</th>
            <th>Email</th>
            <th>Jurusan</th>
        </tr>
        <?php $i = 1; ?>
        <?php foreach ($mahasiswa as $row) : ?>
            <tr>
                <td>
                    <?= $i ?>
                </td>
                <td>
                    <a href="#">ubah</a> |
                    <a href="#">hapus</a>
                </td>
                <td>
                    <img src="img/<?= $row["gambar"] ?>" width="50px">
                </td>
                <td>
                    <?= $row["nim"] ?>
                </td>
                <td>
                    <?= $row["nama"] ?>
                </td>
                <td>
                    <?= $row["email"] ?>
                </td>
                <td>
                    <?= $row["jurusan"] ?>
                </td>
            </tr>
            <?php $i++; ?>
        <?php endforeach; ?>
    </table>
</body>

</html>