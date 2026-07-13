<?php

session_start();

if (!isset($_SESSION['role']) || $_SESSION['role'] != "siswa") {
    header("Location: ../auth/login.php");
    exit;
}

include "../config/koneksi.php";

// =============================
// AMBIL DATA
// =============================

$idSiswa = $_SESSION['id'];
$idBuku  = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($idBuku <= 0) {

    echo "<script>
            alert('ID Buku tidak valid!');
            window.location='katalog.php';
          </script>";
    exit;
}

// =============================
// CEK DATA BUKU
// =============================

$queryBuku = mysqli_query($conn, "
SELECT *
FROM buku
WHERE id_buku='$idBuku'
");

if (mysqli_num_rows($queryBuku) == 0) {

    echo "<script>
            alert('Buku tidak ditemukan!');
            window.location='katalog.php';
          </script>";
    exit;
}

$buku = mysqli_fetch_assoc($queryBuku);

// =============================
// CEK STOK
// =============================

if ($buku['stok'] <= 0) {

    echo "<script>
            alert('Maaf, stok buku habis.');
            window.location='detail_buku.php?id=".$idBuku."';
          </script>";
    exit;
}

// =============================
// CEK SUDAH DIPINJAM
// =============================

$cekPinjam = mysqli_query($conn, "
SELECT *
FROM peminjaman
WHERE id_siswa='$idSiswa'
AND id_buku='$idBuku'
AND status='Dipinjam'
");

if (mysqli_num_rows($cekPinjam) > 0) {

    echo "<script>
            alert('Kamu masih meminjam buku ini.');
            window.location='detail_buku.php?id=".$idBuku."';
          </script>";
    exit;
}
// =============================
// BATASI MAKSIMAL 3 BUKU AKTIF
// =============================

$cekTotal = mysqli_fetch_assoc(mysqli_query($conn,"
SELECT COUNT(*) AS total
FROM peminjaman
WHERE id_siswa='$idSiswa'
AND status='Dipinjam'
"));

if($cekTotal['total'] >= 3){

    echo "<script>
            alert('Maksimal peminjaman adalah 3 buku.');
            window.location='peminjaman.php';
          </script>";
    exit;
}


// =============================
// SIMPAN DATA PEMINJAMAN
// =============================

$tanggalPinjam = date("Y-m-d");
$batasKembali  = date("Y-m-d", strtotime("+7 days"));

$idAdmin = 1;

mysqli_begin_transaction($conn);

try{

    $insert = mysqli_query($conn,"
    INSERT INTO peminjaman
    (
        id_siswa,
        id_buku,
        id_admin,
        tanggal_pinjam,
        batas_kembali,
        status
    )
    VALUES
    (
        '$idSiswa',
        '$idBuku',
        '$idAdmin',
        '$tanggalPinjam',
        '$batasKembali',
        'Dipinjam'
    )
    ");

    if(!$insert){
        throw new Exception(mysqli_error($conn));
    }

    $update = mysqli_query($conn,"
    UPDATE buku
    SET stok = stok - 1
    WHERE id_buku='$idBuku'
    ");

    if(!$update){
        throw new Exception(mysqli_error($conn));
    }

    mysqli_commit($conn);

    echo "<script>
            alert('Buku berhasil dipinjam!');
            window.location='peminjaman.php';
          </script>";

}catch(Exception $e){

    mysqli_rollback($conn);

    echo "<script>
            alert('Peminjaman gagal!');
            window.location='detail_buku.php?id=".$idBuku."';
          </script>";

}

