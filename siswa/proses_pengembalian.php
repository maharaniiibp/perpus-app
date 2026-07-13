<?php

session_start();

if (!isset($_SESSION['role']) || $_SESSION['role'] != "siswa") {
    header("Location: ../auth/login.php");
    exit;
}

include "../config/koneksi.php";

// ===============================
// AMBIL DATA
// ===============================

$idSiswa = $_SESSION['id'];
$idPinjam = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($idPinjam <= 0) {

    echo "<script>
            alert('ID peminjaman tidak valid!');
            window.location='peminjaman.php';
          </script>";
    exit;
}

// ===============================
// CEK DATA PEMINJAMAN
// ===============================

$query = mysqli_query($conn, "
SELECT *
FROM peminjaman
WHERE id_pinjam='$idPinjam'
AND id_siswa='$idSiswa'
AND status='Dipinjam'
");

if (mysqli_num_rows($query) == 0) {

    echo "<script>
            alert('Data peminjaman tidak ditemukan!');
            window.location='peminjaman.php';
          </script>";
    exit;
}

$data = mysqli_fetch_assoc($query);

// ===============================
// SIAPKAN DATA
// ===============================

$idBuku = $data['id_buku'];

$tanggalKembali = date("Y-m-d");

$terlambat = 0;
$denda = 0;

// ===============================
// HITUNG TERLAMBAT & DENDA
// ===============================

$batas = strtotime($data['batas_kembali']);
$kembali = strtotime($tanggalKembali);

if($kembali > $batas){

    $selisih = floor(($kembali - $batas) / (60 * 60 * 24));

    $terlambat = $selisih;

    $denda = $selisih * 2000;

}

// ===============================
// MULAI TRANSAKSI
// ===============================

mysqli_begin_transaction($conn);

try{

    // UPDATE STATUS PEMINJAMAN

    $updatePinjam = mysqli_query($conn,"
    UPDATE peminjaman
    SET status='Dikembalikan'
    WHERE id_pinjam='$idPinjam'
    ");

    if(!$updatePinjam){
        throw new Exception(mysqli_error($conn));
    }

    // UPDATE STOK BUKU

    $updateBuku = mysqli_query($conn,"
    UPDATE buku
    SET stok = stok + 1
    WHERE id_buku='$idBuku'
    ");

    if(!$updateBuku){
        throw new Exception(mysqli_error($conn));
    }

    // INSERT KE TABEL PENGEMBALIAN

    $insert = mysqli_query($conn,"
    INSERT INTO pengembalian
    (
        id_pinjam,
        tanggal_kembali,
        terlambat,
        denda,
        status
    )
    VALUES
    (
        '$idPinjam',
        '$tanggalKembali',
        '$terlambat',
        '$denda',
        'Selesai'
    )
    ");

    if(!$insert){
        throw new Exception(mysqli_error($conn));
    }

    mysqli_commit($conn);

    echo "<script>
            alert('Buku berhasil dikembalikan.');
            window.location='pengembalian.php';
          </script>";

}catch(Exception $e){

    mysqli_rollback($conn);

    echo "<script>
            alert('".$e->getMessage()."');
            window.location='detail_peminjaman.php?id=".$idPinjam."';
          </script>";

}

?>