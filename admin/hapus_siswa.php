<?php

session_start();

if (!isset($_SESSION['role'])) {
    header("Location: ../auth/login.php");
    exit;
}

include "../config/koneksi.php";

if (!isset($_GET['id'])) {
    header("Location: siswa.php");
    exit;
}

$id = (int) $_GET['id'];


// ==========================
// AMBIL DATA SISWA
// ==========================

$query = mysqli_query($conn, "
SELECT *
FROM siswa
WHERE id_siswa='$id'
");

if (mysqli_num_rows($query) == 0) {

    echo "<script>
            alert('Data siswa tidak ditemukan.');
            window.location='siswa.php';
          </script>";
    exit;
}

$data = mysqli_fetch_assoc($query);


// ==========================
// CEK APAKAH MASIH ADA DATA PEMINJAMAN
// ==========================

$cek = mysqli_query($conn, "
SELECT COUNT(*) AS total
FROM peminjaman
WHERE id_siswa='$id'
");

$row = mysqli_fetch_assoc($cek);

if ($row['total'] > 0) {

    echo "<script>
            alert('Data siswa tidak dapat dihapus karena masih memiliki riwayat peminjaman.');
            window.location='siswa.php';
          </script>";
    exit;
}


// ==========================
// HAPUS FOTO
// ==========================

if (!empty($data['foto'])) {

    $path = "../assets/image/siswa/" . $data['foto'];

    if (file_exists($path)) {
        unlink($path);
    }

}


// ==========================
// HAPUS DATA SISWA
// ==========================

try {

    mysqli_query($conn, "
    DELETE FROM siswa
    WHERE id_siswa='$id'
    ");

    echo "<script>
            alert('Data siswa berhasil dihapus.');
            window.location='siswa.php';
          </script>";

} catch (mysqli_sql_exception $e) {

    echo "<script>
            alert('Data siswa tidak dapat dihapus karena masih digunakan pada data lain.');
            window.location='siswa.php';
          </script>";

}

exit;

?>