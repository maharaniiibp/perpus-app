<?php

session_start();

if(!isset($_SESSION['role'])){

    header("Location: ../auth/login.php");
    exit;

}

if($_SESSION['role']!="siswa"){

    header("Location: ../auth/login.php");
    exit;

}

include "../config/koneksi.php";

$idSiswa = $_SESSION['id'];


// ===============================
// DATA SISWA
// ===============================

$siswa = mysqli_fetch_assoc(mysqli_query($conn,"
SELECT *
FROM siswa
WHERE id_siswa='$idSiswa'
"));


// ===============================
// BUKU SEDANG DIPINJAM
// ===============================

$aktif = mysqli_fetch_assoc(mysqli_query($conn,"
SELECT COUNT(*) total
FROM peminjaman
WHERE id_siswa='$idSiswa'
AND status='Dipinjam'
"));


// ===============================
// TOTAL PEMINJAMAN
// ===============================

$total = mysqli_fetch_assoc(mysqli_query($conn,"
SELECT COUNT(*) total
FROM peminjaman
WHERE id_siswa='$idSiswa'
"));


// ===============================
// JATUH TEMPO (≤2 HARI)
// ===============================

$jatuhTempo = mysqli_fetch_assoc(mysqli_query($conn,"
SELECT COUNT(*) total
FROM peminjaman
WHERE id_siswa='$idSiswa'
AND status='Dipinjam'
AND DATEDIFF(batas_kembali,CURDATE())<=2
"));


// ===============================
// DATA BUKU AKTIF
// ===============================

$query = mysqli_query($conn,"

SELECT

peminjaman.*,

buku.judul,

buku.penulis,

buku.cover

FROM peminjaman

INNER JOIN buku

ON buku.id_buku=peminjaman.id_buku

WHERE peminjaman.id_siswa='$idSiswa'

AND peminjaman.status='Dipinjam'

ORDER BY peminjaman.batas_kembali ASC

");


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


<!-- HEADER -->

<div class="mb-4">

<h2 class="fw-bold">

Peminjaman Buku

</h2>

<p class="text-secondary">

Kelola buku yang sedang kamu pinjam dan pantau batas pengembalian.

</p>

</div>



<!-- ALERT

<div class="alert border-0 rounded-4 shadow-sm mb-4"

style="background:#CFF7E4;">

<div class="d-flex justify-content-between align-items-center">

<div>

<i class="bi bi-info-circle-fill text-success me-2"></i>

Batas pengembalian buku tersisa

<strong>

2 Hari

</strong>

</div>

<a

href="#"

class="text-success text-decoration-none fw-semibold">

Lihat Detail

</a>

</div>

</div> -->



<!-- CARD -->

<div class="row g-3 mb-4">

<div class="col-lg-4">

<div class="card border-0 shadow-sm rounded-4">

<div class="card-body d-flex justify-content-between align-items-center">

<div>

<small class="text-secondary">

Buku Sedang Dipinjam

</small>

<h2 class="fw-bold mt-2">

<?= $aktif['total']; ?>

</h2>

</div>

<div class="bg-primary bg-opacity-10 p-3 rounded-3">

<i class="bi bi-book text-primary fs-3"></i>

</div>

</div>

</div>

</div>



<div class="col-lg-4">

<div class="card border-0 shadow-sm rounded-4">

<div class="card-body d-flex justify-content-between align-items-center">

<div>

<small class="text-secondary">

Jatuh Tempo

</small>

<h2 class="fw-bold mt-2 text-danger">

<?= $jatuhTempo['total']; ?>

</h2>

</div>

<div class="bg-danger bg-opacity-10 p-3 rounded-3">

<i class="bi bi-calendar-x text-danger fs-3"></i>

</div>

</div>

</div>

</div>



<div class="col-lg-4">

<div class="card border-0 shadow-sm rounded-4">

<div class="card-body d-flex justify-content-between align-items-center">

<div>

<small class="text-secondary">

Total Peminjaman

</small>

<h2 class="fw-bold mt-2 text-success">

<?= $total['total']; ?>

</h2>

</div>

<div class="bg-success bg-opacity-10 p-3 rounded-3">

<i class="bi bi-clock-history text-success fs-3"></i>

</div>

</div>

</div>

</div>

</div>



<h4 class="fw-bold mb-3">

Buku Aktif

</h4>

<style>

.borrow-grid{

display:grid;

grid-template-columns:repeat(2,1fr);

gap:20px;

}

.borrow-card{

background:#fff;

border-radius:18px;

padding:15px;

box-shadow:0 5px 20px rgba(0,0,0,.08);

transition:.3s;

}

.borrow-card:hover{

transform:translateY(-5px);

box-shadow:0 15px 30px rgba(0,0,0,.12);

}

.borrow-cover{

width:110px;

height:150px;

object-fit:cover;

border-radius:10px;

}

.borrow-title{

font-weight:700;

font-size:18px;

margin-bottom:3px;

}

.borrow-author{

color:#666;

font-size:14px;

margin-bottom:12px;

}

.borrow-info{

font-size:14px;

line-height:1.9;

}

@media(max-width:992px){

.borrow-grid{

grid-template-columns:1fr;

}

}

</style>



<div class="borrow-grid">

<?php

if(mysqli_num_rows($query)>0){

while($d=mysqli_fetch_assoc($query)){

?>



<div class="borrow-card">

<div class="row">

<!-- COVER -->

<div class="col-md-3 text-center">

<img

src="../assets/image/buku/<?= $d['cover']; ?>"

class="borrow-cover">

</div>



<!-- DETAIL -->

<div class="col-md-9">

<div class="d-flex justify-content-between">

<div>

<div class="borrow-title">

<?= $d['judul']; ?>

</div>

<div class="borrow-author">

<?= $d['penulis']; ?>

</div>

</div>

<div>

<span class="badge bg-success rounded-pill">

Sedang Dipinjam

</span>

</div>

</div>



<div class="borrow-info">

<strong>Tgl Pinjam :</strong>

<?= date("d M Y",strtotime($d['tanggal_pinjam'])); ?>

<br>

<strong>Batas Kembali :</strong>

<span class="text-danger fw-bold">

<?= date("d M Y",strtotime($d['batas_kembali'])); ?>

</span>

</div>



<div class="mt-3 d-flex gap-2">

<a

href="detail_peminjaman.php?id=<?= $d['id_pinjam']; ?>"

class="btn btn-outline-primary w-50">

Detail

</a>



<a
href="proses_pengembalian.php?id=<?= $d['id_pinjam']; ?>"
class="btn btn-primary w-50">

Kembalikan

</a>
</div>

</div>

</div>

</div>



<?php

}

}else{

?>



<div class="col-12">

<div class="alert alert-warning rounded-4">

Belum ada buku yang sedang dipinjam.

</div>

</div>



<?php

}

?>

</div>