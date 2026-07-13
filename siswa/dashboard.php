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


// ======================================
// DATA SISWA
// ======================================

$siswa = mysqli_fetch_assoc(mysqli_query($conn,"
SELECT *
FROM siswa
WHERE id_siswa='$idSiswa'
"));


// ======================================
// BUKU SEDANG DIPINJAM
// ======================================

$sedangDipinjam = mysqli_fetch_assoc(mysqli_query($conn,"
SELECT COUNT(*) AS total
FROM peminjaman
WHERE id_siswa='$idSiswa'
AND status='Dipinjam'
"));


// ======================================
// TOTAL RIWAYAT
// ======================================

$totalRiwayat = mysqli_fetch_assoc(mysqli_query($conn,"
SELECT COUNT(*) AS total
FROM peminjaman
WHERE id_siswa='$idSiswa'
"));


// ======================================
// PENGEMBALIAN TERDEKAT
// ======================================

$pengembalian = mysqli_fetch_assoc(mysqli_query($conn,"
SELECT batas_kembali
FROM peminjaman
WHERE id_siswa='$idSiswa'
AND status='Dipinjam'
ORDER BY batas_kembali ASC
LIMIT 1
"));



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

Selamat Datang,

<?= $siswa['nama_siswa']; ?>

👋

</h2>

<p class="text-secondary">

Temukan dan kelola koleksi buku perpustakaan dengan mudah.

</p>

</div>



<!-- SEARCH -->

<div class="card border-0 shadow-sm rounded-4 mb-4">

<div class="card-body">

<div class="input-group">

<span class="input-group-text bg-white border-0">

<i class="bi bi-search"></i>

</span>

<input

type="text"

class="form-control border-0"

placeholder="Cari judul buku, penulis, atau kategori...">

</div>

</div>

</div>
<?php

// ======================================
// HITUNG SISA HARI PENGEMBALIAN
// ======================================

$sisaHari = "-";

if(!empty($pengembalian['batas_kembali'])){

    $today = new DateTime(date("Y-m-d"));
    $batas = new DateTime($pengembalian['batas_kembali']);

    $selisih = $today->diff($batas);

    if($today > $batas){

        $sisaHari = "Terlambat ".$selisih->days." Hari";

    }else{

        $sisaHari = "Dalam ".$selisih->days." Hari";

    }

}

?>



<!-- CARD STATISTIK -->

<div class="row g-3 mb-4">

    <!-- BUKU DIPINJAM -->

    <div class="col-lg-4">

        <div class="card border-0 shadow-sm rounded-4 h-100">

            <div class="card-body">

                <div class="d-flex justify-content-between align-items-center">

                    <div>

                        <small class="text-secondary">

                            Buku Sedang Dipinjam

                        </small>

                        <h1 class="fw-bold text-primary mt-2">

                            <?= $sedangDipinjam['total']; ?>

                        </h1>

                    </div>

                    <div
                    class="rounded-3 bg-primary bg-opacity-10 p-3">

                        <i class="bi bi-journal-bookmark-fill fs-2 text-primary"></i>

                    </div>

                </div>

            </div>

        </div>

    </div>



    <!-- PENGEMBALIAN -->

    <div class="col-lg-4">

        <div class="card border-0 shadow-sm rounded-4 h-100">

            <div class="card-body">

                <div class="d-flex justify-content-between align-items-center">

                    <div>

                        <small class="text-secondary">

                            Jadwal Pengembalian

                        </small>

                        <h2 class="fw-bold text-danger mt-2">

                            <?= $sisaHari; ?>

                        </h2>

                    </div>

                    <div
                    class="rounded-3 bg-danger bg-opacity-10 p-3">

                        <i class="bi bi-calendar-check fs-2 text-danger"></i>

                    </div>

                </div>

            </div>

        </div>

    </div>



    <!-- RIWAYAT -->

    <div class="col-lg-4">

        <div class="card border-0 shadow-sm rounded-4 h-100">

            <div class="card-body">

                <div class="d-flex justify-content-between align-items-center">

                    <div>

                        <small class="text-secondary">

                            Total Riwayat Peminjaman

                        </small>

                        <h1 class="fw-bold text-success mt-2">

                            <?= $totalRiwayat['total']; ?>

                        </h1>

                    </div>

                    <div
                    class="rounded-3 bg-success bg-opacity-10 p-3">

                        <i class="bi bi-clock-history fs-2 text-success"></i>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>

<?php

// ======================================
// REKOMENDASI BUKU
// ======================================

$buku = mysqli_query($conn,"
SELECT *
FROM buku
ORDER BY id_buku DESC
LIMIT 3
");


// ======================================
// AKTIVITAS TERBARU
// ======================================

$aktivitas = mysqli_query($conn,"
SELECT

peminjaman.*,

buku.judul

FROM peminjaman

INNER JOIN buku
ON buku.id_buku=peminjaman.id_buku

WHERE peminjaman.id_siswa='$idSiswa'

ORDER BY peminjaman.tanggal_pinjam DESC

LIMIT 4

");

?>



<div class="row">

    <!-- REKOMENDASI -->

    <div class="col-lg-8">

        <div class="d-flex justify-content-between align-items-center mb-3">

            <h4 class="fw-bold">

                Rekomendasi Buku

            </h4>

            <a
            href="katalog.php"
            class="text-decoration-none fw-semibold">

                Lihat Semua

            </a>

        </div>

        <div class="row">

<?php

while($b=mysqli_fetch_assoc($buku)){

?>

<div class="col-lg-4 mb-4">

<div class="card border-0 shadow-sm rounded-4 h-100">

<img

src="../assets/image/buku/<?= $b['cover']; ?>"

class="card-img-top"

style="height:260px;object-fit:cover;">

<div class="card-body">

<h6 class="fw-bold">

<?= $b['judul']; ?>

</h6>

<p class="text-secondary mb-2">

<?= $b['penulis']; ?>

</p>

<?php

if($b['stok']>0){

?>

<span class="badge bg-success mb-3">

Tersedia

</span>

<?php

}else{

?>

<span class="badge bg-danger mb-3">

Dipinjam

</span>

<?php

}

?>

<a

href="detail_buku.php?id=<?= $b['id_buku']; ?>"

class="btn btn-outline-primary w-100">

Lihat Detail

</a>

</div>

</div>

</div>

<?php

}

?>

        </div>

    </div>



    <!-- AKTIVITAS -->

    <div class="col-lg-4">

        <div class="card border-0 shadow-sm rounded-4">

            <div class="card-body">

                <h5 class="fw-bold mb-4">

                    Aktivitas Terbaru

                </h5>

<?php

if(mysqli_num_rows($aktivitas)>0){

while($a=mysqli_fetch_assoc($aktivitas)){

?>

<div class="d-flex mb-4">

<div class="me-3">

<i class="bi bi-journal-check text-success fs-3"></i>

</div>

<div>

<strong>

<?= $a['judul']; ?>

</strong>

<br>

<small class="text-secondary">

<?= date("d M Y",strtotime($a['tanggal_pinjam'])); ?>

</small>

<br>

<?php

if($a['status']=="Dipinjam"){

?>

<span class="badge bg-warning text-dark">

Sedang Dipinjam

</span>

<?php

}else{

?>

<span class="badge bg-success">

Dikembalikan

</span>

<?php

}

?>

</div>

</div>

<?php

}

}else{

?>

<div class="text-center py-5">

<i class="bi bi-clock-history fs-1 text-secondary"></i>

<p class="text-secondary mt-3">

Belum ada aktivitas.

</p>

</div>

<?php

}

?>

            </div>

        </div>

    </div>

</div>

<!-- TARGET MEMBACA -->

<?php

$target = 20;

$dibaca = $totalRiwayat['total'];

$persen = ($dibaca/$target)*100;

if($persen>100){

    $persen=100;

}

?>

<div class="row mt-4">

<div class="col-lg-8">

</div>

<div class="col-lg-4">

<div
class="card border-0 shadow rounded-4 text-white"
style="background:#2563eb;">

<div class="card-body">

<small>

TARGET MEMBACA <?= date("Y"); ?>

</small>

<h2 class="fw-bold mt-2">

<?= $dibaca; ?>

/

<?= $target; ?>

 Buku

</h2>

<div
class="progress mt-3"
style="height:8px;">

<div

class="progress-bar bg-success"

style="width:<?= $persen; ?>%;">

</div>

</div>

<p class="small mt-3 mb-0">

<?php

if($dibaca<$target){

?>

Tinggal

<strong>

<?= $target-$dibaca; ?>

</strong>

buku lagi untuk mencapai target.

<?php

}else{

?>

Selamat!

Target membaca tercapai 🎉

<?php

}

?>

</p>

</div>

</div>

</div>

</div>



</div>

<?php include "../includes/footer.php"; ?>