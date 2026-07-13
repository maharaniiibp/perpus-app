<?php

session_start();

if(!isset($_SESSION['role']) || $_SESSION['role']!="siswa"){

    header("Location: ../auth/login.php");
    exit;

}

include "../config/koneksi.php";

$idSiswa = $_SESSION['id'];
$idPengembalian = isset($_GET['id']) ? intval($_GET['id']) : 0;


// =====================================
// AMBIL DATA PENGEMBALIAN
// =====================================

$query = mysqli_query($conn,"

SELECT

pengembalian.*,

peminjaman.id_pinjam,

peminjaman.tanggal_pinjam,

peminjaman.batas_kembali,

buku.id_buku,

buku.judul,

buku.penulis,

buku.penerbit,

buku.tahun_terbit,

buku.isbn,

buku.cover,

buku.deskripsi,

kategori.nama_kategori

FROM pengembalian

INNER JOIN peminjaman
ON peminjaman.id_pinjam = pengembalian.id_pinjam

INNER JOIN buku
ON buku.id_buku = peminjaman.id_buku

LEFT JOIN kategori
ON kategori.id_kategori = buku.id_kategori

WHERE pengembalian.id_pengembalian='$idPengembalian'

AND peminjaman.id_siswa='$idSiswa'

");

if(mysqli_num_rows($query)==0){

    echo "<script>

    alert('Data pengembalian tidak ditemukan.');

    window.location='pengembalian.php';

    </script>";

    exit;

}

$data = mysqli_fetch_assoc($query);

include "../includes/header.php";
include "../includes/sidebar_siswa.php";

?>

<div
class="container-fluid"
style="
margin-left:250px;
padding:25px;
background:#F5F7FB;
min-height:100vh;
">

<?php include "../includes/navbar_siswa.php"; ?>

<!-- ===================================== -->
<!-- HEADER -->
<!-- ===================================== -->

<div class="d-flex justify-content-between align-items-center mb-4">

    <div>

        <h2 class="fw-bold">

            Detail Pengembalian

        </h2>

        <p class="text-secondary">

            Informasi lengkap riwayat pengembalian buku.

        </p>

    </div>

    <a

    href="pengembalian.php"

    class="btn btn-outline-secondary">

        <i class="bi bi-arrow-left me-2"></i>

        Kembali

    </a>

</div>



<div class="card border-0 shadow rounded-4">

<div class="card-body">

<div class="row">

<!-- ========================= -->
<!-- COVER BUKU -->
<!-- ========================= -->

<div class="col-lg-4 text-center">

<img

src="../assets/image/buku/<?= $data['cover']; ?>"

class="img-fluid rounded shadow"

style="max-height:450px;object-fit:cover;">

</div>



<!-- ========================= -->
<!-- INFORMASI -->
<!-- ========================= -->

<div class="col-lg-8">

<h2 class="fw-bold mb-2">

<?= $data['judul']; ?>

</h2>

<p class="text-secondary fs-5">

<?= $data['penulis']; ?>

</p>

<span class="badge bg-success px-3 py-2 mb-4">

Dikembalikan

</span>



<!-- ========================= -->
<!-- INFORMASI PENGEMBALIAN -->
<!-- ========================= -->

<div class="card border-0 bg-light rounded-4 mb-4">

<div class="card-body">

<h5 class="fw-bold mb-3">

<i class="bi bi-arrow-return-left me-2"></i>

Informasi Pengembalian

</h5>

<div class="row">

<div class="col-md-6 mb-3">

<label class="text-secondary">

Tanggal Pinjam

</label>

<div class="fw-semibold">

<?= date("d F Y",strtotime($data['tanggal_pinjam'])); ?>

</div>

</div>



<div class="col-md-6 mb-3">

<label class="text-secondary">

Batas Pengembalian

</label>

<div class="fw-semibold">

<?= date("d F Y",strtotime($data['batas_kembali'])); ?>

</div>

</div>



<div class="col-md-6 mb-3">

<label class="text-secondary">

Tanggal Dikembalikan

</label>

<div class="fw-semibold text-success">

<?= date("d F Y",strtotime($data['tanggal_kembali'])); ?>

</div>

</div>



<div class="col-md-6 mb-3">

<label class="text-secondary">

Status

</label>

<div>

<span class="badge bg-success">

<?= $data['status']; ?>

</span>

</div>

</div>



<div class="col-md-6 mb-3">

<label class="text-secondary">

Terlambat

</label>

<div class="fw-semibold">

<?= $data['terlambat']; ?> Hari

</div>

</div>



<div class="col-md-6 mb-3">

<label class="text-secondary">

Denda

</label>

<div class="fw-bold text-danger">

Rp <?= number_format($data['denda'],0,",","."); ?>

</div>

</div>

</div>

</div>

</div>

<!-- ===================================== -->
<!-- INFORMASI BUKU -->
<!-- ===================================== -->

<div class="card border-0 bg-light rounded-4">

<div class="card-body">

<h5 class="fw-bold mb-3">

<i class="bi bi-book me-2"></i>

Informasi Buku

</h5>

<div class="row">

<div class="col-md-6 mb-3">

<label class="text-secondary">

ID Buku

</label>

<div class="fw-semibold">

BK-<?= str_pad($data['id_buku'],4,"0",STR_PAD_LEFT); ?>

</div>

</div>



<div class="col-md-6 mb-3">

<label class="text-secondary">

ISBN

</label>

<div class="fw-semibold">

<?= $data['isbn']; ?>

</div>

</div>



<div class="col-md-6 mb-3">

<label class="text-secondary">

Penerbit

</label>

<div class="fw-semibold">

<?= $data['penerbit']; ?>

</div>

</div>



<div class="col-md-6 mb-3">

<label class="text-secondary">

Tahun Terbit

</label>

<div class="fw-semibold">

<?= $data['tahun_terbit']; ?>

</div>

</div>



<div class="col-md-6 mb-3">

<label class="text-secondary">

Kategori

</label>

<div>

<span class="badge bg-primary">

<?= $data['nama_kategori']; ?>

</span>

</div>

</div>

</div>

<label class="text-secondary mt-2">

Deskripsi Buku

</label>

<div class="border rounded-3 bg-white p-3">

<?= nl2br($data['deskripsi']); ?>

</div>

</div>

</div>

<hr class="my-4">

<div class="d-flex justify-content-end">

<a

href="pengembalian.php"

class="btn btn-outline-secondary">

<i class="bi bi-arrow-left me-2"></i>

Kembali ke Riwayat

</a>

</div>

</div>

</div>

</div>

</div>

<?php include "../includes/footer.php"; ?>