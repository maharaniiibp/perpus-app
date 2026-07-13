<?php

session_start();

if(!isset($_SESSION['role']) || $_SESSION['role']!="siswa"){

    header("Location: ../auth/login.php");
    exit;

}

include "../config/koneksi.php";

$idSiswa = $_SESSION['id'];
$idPinjam = isset($_GET['id']) ? intval($_GET['id']) : 0;


// =====================================
// AMBIL DATA PEMINJAMAN
// =====================================

$query = mysqli_query($conn,"

SELECT

peminjaman.*,

buku.id_buku,

buku.judul,

buku.penulis,

buku.penerbit,

buku.tahun_terbit,

buku.isbn,

buku.cover,

buku.deskripsi,

kategori.nama_kategori

FROM peminjaman

INNER JOIN buku
ON buku.id_buku = peminjaman.id_buku

LEFT JOIN kategori
ON kategori.id_kategori = buku.id_kategori

WHERE peminjaman.id_pinjam='$idPinjam'

AND peminjaman.id_siswa='$idSiswa'

");

if(mysqli_num_rows($query)==0){

    echo "<script>

    alert('Data peminjaman tidak ditemukan.');

    window.location='peminjaman.php';

    </script>";

    exit;

}

$data = mysqli_fetch_assoc($query);


// =====================================
// HITUNG SISA HARI
// =====================================

$today = new DateTime(date("Y-m-d"));
$batas = new DateTime($data['batas_kembali']);

$selisih = $today->diff($batas);

if($today > $batas){

    $statusHari = "Terlambat ".$selisih->days." Hari";

}else{

    $statusHari = $selisih->days." Hari Lagi";

}

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

<div class="d-flex justify-content-between align-items-center mb-4">

<div>

<h2 class="fw-bold">

Detail Peminjaman

</h2>

<p class="text-secondary">

Informasi lengkap peminjaman buku.

</p>

</div>

<a
href="peminjaman.php"
class="btn btn-outline-secondary">

<i class="bi bi-arrow-left me-2"></i>

Kembali

</a>

</div>



<div class="card border-0 shadow rounded-4">

<div class="card-body">

<div class="row">

<!-- COVER -->

<div class="col-lg-4 text-center">

<img

src="../assets/image/buku/<?= $data['cover']; ?>"

class="img-fluid rounded shadow"

style="max-height:480px;object-fit:cover;">

</div>



<!-- DETAIL -->

<div class="col-lg-8">

<h2 class="fw-bold mb-2">

<?= $data['judul']; ?>

</h2>

<p class="text-secondary fs-5">

<?= $data['penulis']; ?>

</p>

<?php

if($data['status']=="Dipinjam"){

?>

<span class="badge bg-success px-3 py-2 mb-4">

Sedang Dipinjam

</span>

<?php

}else{

?>

<span class="badge bg-secondary px-3 py-2 mb-4">

Dikembalikan

</span>

<?php

}

?>



<div class="card border-0 bg-light rounded-4 mb-4">

<div class="card-body">

<h5 class="fw-bold mb-3">

<i class="bi bi-journal-text me-2"></i>

Informasi Peminjaman

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

<div class="fw-semibold text-danger">

<?= date("d F Y",strtotime($data['batas_kembali'])); ?>

</div>

</div>



<div class="col-md-6 mb-3">

<label class="text-secondary">

Status

</label>

<div class="fw-semibold">

<?= $data['status']; ?>

</div>

</div>



<div class="col-md-6 mb-3">

<label class="text-secondary">

Sisa Waktu

</label>

<div class="fw-bold text-primary">

<?= $statusHari; ?>

</div>

</div>

</div>

</div>

</div>



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

<div class="d-flex gap-2">

<?php if($data['status']=="Dipinjam"){ ?>

<a

href="proses_pengembalian.php?id=<?= $data['id_pinjam']; ?>"

class="btn btn-success">

<i class="bi bi-arrow-return-left me-2"></i>

Kembalikan Buku

</a>

<?php }else{ ?>

<button

class="btn btn-secondary"

disabled>

<i class="bi bi-check-circle me-2"></i>

Sudah Dikembalikan

</button>

<?php } ?>

<a

href="peminjaman.php"

class="btn btn-outline-secondary">

<i class="bi bi-arrow-left me-2"></i>

Kembali

</a>

</div>

</div>

</div>

</div>

</div>

<?php include "../includes/footer.php"; ?>