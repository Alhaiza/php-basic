<?php
require "functions.php";
// ambil data dari tabel mahasiswa
$mahasiswa = mysqli_query($conn, "SELECT * FROM mahasiswa");

// jika tombol cari diclick
if (isset($_POST["cari"])) {
    $mahasiswa = cari($_POST["keyword"]);
}

?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrasi</title>
</head>

<body>
    <h1>Daftar Mahasiswa</h1>

    <a href="tambah.php">Tambah Data Mahasiswa</a>
    <br>
    <br>

    <form action="" method="post">
        <input type="text" name="keyword" size="40" autofocus placeholder="Cari Sesuatu" autocomplete="off">
        <button type="submit" name="cari">Cari</button>
    </form>
    <br>
    <br>

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
                    <a href="ubah.php?id=<?= $row["id"] ?>">ubah</a> |
                    <a href="hapus.php?id=<?= $row["id"] ?>" onclick="
                    return confirm('Apakah anda yakin ingin menghapus data ini?')">hapus</a>
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