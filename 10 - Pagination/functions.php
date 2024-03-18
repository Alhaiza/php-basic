<?php
// koneksi ke database
$conn = mysqli_connect("localhost", "root", "root", "learn_php_basic");


// Function Query Database ke web
function query($query)
{
    global $conn;
    $result = mysqli_query($conn, $query);
    $rows = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }

    return $rows;
}

function tambah($data)
{
    // ambil data dari tiap data dalam form
    global $conn;

    $nim = htmlspecialchars($data["nim"]);
    $nama = htmlspecialchars($data["nama"]);
    $email = htmlspecialchars($data["email"]);
    $jurusan = htmlspecialchars($data["jurusan"]);


    // Jalankan fungsi Upload Gambar
    $gambar = upload();
    if (!$gambar) {
        return false;
    }

    // query insert data
    $query = "INSERT INTO mahasiswa (nama, nim, email, jurusan, gambar)
                VALUES
                ('$nama', '$nim', '$email', '$jurusan', '$gambar')
    
    ";
    mysqli_query($conn, $query);

    return mysqli_affected_rows($conn);
}

function upload()
{
    $namaFile = $_FILES['gambar']['name'];
    $ukuranFile = $_FILES['gambar']['size'];
    $error = $_FILES['gambar']['error'];
    $tmpName = $_FILES['gambar']['tmp_name'];

    // cek apakah tidak ada gambar yang diupload
    if ($error === 4) {
        echo
        "<script>
            alert('Pilih Gambar Terlebih Dahulu!');
        </script>
        ";

        return false;
    }

    // cek apakah file diupload itu format gambar atau bukan
    $formatIMG = ['jpg', 'jpeg', 'png'];
    $imgName = explode('.', $namaFile);
    $imgName = strtolower(end($imgName));

    if (!in_array($imgName, $formatIMG)) {
        echo
        "<script>
            alert('Format yang diterima hanya jpg, jpeg, dan png!');
        </script>
        ";
        return false;
    }

    // cek jika ukurannya terlalu besar
    if ($ukuranFile > 1000000) {
        echo
        "<script>
            alert('Max Ukuran Gambar Adalah 1mb!');
        </script>
        ";
        return false;
    }

    // jika lolos pengecekan
    //generate nama baru untuk gambar
    $newFileName = uniqid();
    $newFileName .= '.';
    $newFileName .= $imgName;


    move_uploaded_file($tmpName, 'img/' . $newFileName);
    return $newFileName;
}

function hapus($id)
{
    global $conn;
    mysqli_query($conn, "DELETE FROM mahasiswa WHERE id = $id");

    return mysqli_affected_rows($conn);
}

function ubah($data)
{
    global $conn;

    $id = $data["id"];
    $nim = htmlspecialchars($data["nim"]);
    $nama = htmlspecialchars($data["nama"]);
    $email = htmlspecialchars($data["email"]);
    $jurusan = htmlspecialchars($data["jurusan"]);
    $gambar = htmlspecialchars($data["gambar"]);
    $oldIMG = htmlspecialchars($data["oldIMG"]);

    // cek apakah user pilih gambar baru atau tidak
    if ($_FILES['gambar']['error'] === 4) {
        $gambar = $oldIMG;
    } else {
        $gambar = upload();
    }

    // query edit data
    $query = "UPDATE mahasiswa SET
                nim = '$nim',
                nama = '$nama',
                email = '$email',
                jurusan = '$jurusan',
                gambar = '$gambar'
            WHERE id = $id
    ";

    mysqli_query($conn, $query);
    return mysqli_affected_rows($conn);
}

function cari($keyword)
{
    $query = "SELECT * FROM mahasiswa
                WHERE 
                nim LIKE '%$keyword%' OR
                nama LIKE '%$keyword%' OR
                email LIKE '%$keyword%' OR
                jurusan LIKE '%$keyword%'
               
        ";
    return query($query);
}

function register($data)
{
    global $conn;
    $username = strtolower(stripslashes($data["username"]));
    $password = mysqli_real_escape_string($conn, $data["username"]);
    $passwordConfirm = mysqli_real_escape_string($conn, $data["passwordConfirm"]);

    // cek username
    $checkUsername = mysqli_query($conn, "SELECT username FROM user WHERE username = '$username'");
    if (mysqli_fetch_assoc($checkUsername)) {
        echo
        "<script>
            alert('Username sudah ada!');
        </script>
        ";
        return false;
    }

    // cek konfirmasi password
    if ($password !== $passwordConfirm) {
        echo
        "<script>
            alert('Masukan Password dan Konfirmasi Password yang serupa!');
        </script>
        ";
        return false;
    }

    // enkripsi password
    $password = password_hash($password, PASSWORD_DEFAULT);

    // tambahkan user baru ke database
    mysqli_query($conn, "INSERT INTO user (username, password)
                            VALUES
                        ('$username', '$password')
                ");
    return mysqli_affected_rows($conn);
}
