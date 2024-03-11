<?php
session_start();

if (!isset($_SESSION["login"])) {
    header("Location: login.php");
    exit;
}

require "functions.php";

// Pagination
$jumlahDataPerHalaman = 3;
$jumlahData = count(query("SELECT * FROM mahasiswa"));
$jumlahHalaman = ceil($jumlahData / $jumlahDataPerHalaman);
$halamanAktif = (isset($_GET["page"])) ? $_GET["page"] : 1;
$awalData = ($jumlahDataPerHalaman * $halamanAktif) - $jumlahDataPerHalaman;

// ambil data dari tabel mahasiswa
$mahasiswa = mysqli_query($conn, "SELECT * FROM mahasiswa LIMIT $awalData, $jumlahDataPerHalaman");

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
    <title>Pagination</title>
</head>

<body>
    <a href="logout.php">Logout</a>
    <h1>Daftar Mahasiswa</h1>

    <a href="tambah.php">Tambah Data Mahasiswa</a>
    <br>
    <br>

    <form action="" method="post">
        <input type="text" name="keyword" size="40" autofocus placeholder="Cari Sesuatu" autocomplete="off">
        <button type="submit" name="cari">Cari</button>
    </form>
    <br>

    <!-- agar panah nomor page 1 tidak ke belakang -->
    <?php if ($halamanAktif > 1) : ?>
        <a href="?page=<?= $halamanAktif - 1 ?>">&laquo;</a>
    <?php endif; ?>




    <!-- agar kita tau sedang ada di halaman berapa -->
    <?php for ($i = 1; $i <= $jumlahHalaman; $i++) : ?>
        <?php if ($i == $halamanAktif) : ?>
            <a href="?page=<?= $i ?>" style="font-weight: bold; color: red;">
                <?= $i ?>
            </a>
        <?php else : ?>
            <a href="?page=<?= $i ?>">
                <?= $i ?>
            </a>
        <?php endif; ?>
    <?php endfor; ?>


    <!-- agar pada nomor page terakhir tidak ke depan lagi -->
    <?php if ($halamanAktif < $jumlahHalaman) : ?>
        <a href="?page=<?= $halamanAktif + 1 ?>">&raquo;</a>
    <?php endif; ?>
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
        <?php $i = 1 + $awalData; ?>
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