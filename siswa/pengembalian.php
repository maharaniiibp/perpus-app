<?php

session_start();

if (!isset($_SESSION['role']) || $_SESSION['role'] != "siswa") {

    header("Location: ../auth/login.php");
    exit;

}

include "../config/koneksi.php";

$idSiswa = $_SESSION['id'];


// =====================================
// DATA PENGEMBALIAN
// =====================================

$query = mysqli_query($conn, "

SELECT

pengembalian.*,

peminjaman.tanggal_pinjam,

peminjaman.batas_kembali,

peminjaman.id_pinjam,

buku.id_buku,

buku.judul,

buku.penulis,

buku.cover

FROM pengembalian

INNER JOIN peminjaman
ON peminjaman.id_pinjam = pengembalian.id_pinjam

INNER JOIN buku
ON buku.id_buku = peminjaman.id_buku

WHERE peminjaman.id_siswa='$idSiswa'

ORDER BY pengembalian.id_pengembalian DESC

");

$totalPengembalian = mysqli_num_rows($query);


// =====================================
// CARD STATISTIK
// =====================================

$totalBelum = mysqli_num_rows(mysqli_query($conn, "

SELECT *

FROM peminjaman

WHERE id_siswa='$idSiswa'

AND status='Dipinjam'

"));


$totalHariIni = mysqli_num_rows(mysqli_query($conn, "

SELECT *

FROM peminjaman

WHERE id_siswa='$idSiswa'

AND status='Dipinjam'

AND batas_kembali = CURDATE()

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
<!-- ===================================== -->
<!-- HEADER -->
<!-- ===================================== -->

<div class="d-flex justify-content-between align-items-center mb-4">

    <div>

        <h2 class="fw-bold mb-1">

            Pengembalian Buku

        </h2>

        <p class="text-secondary mb-0">

            Kelola pengembalian buku dan lihat riwayat pengembalian.

        </p>

    </div>

</div>


<!-- ===================================== -->
<!-- CARD STATISTIK -->
<!-- ===================================== -->

<div class="row mb-4">

    <!-- Buku Belum Dikembalikan -->

    <div class="col-lg-4">

        <div class="card border-0 shadow-sm rounded-4">

            <div class="card-body d-flex justify-content-between align-items-center">

                <div>

                    <small class="text-secondary">

                        Buku Belum Dikembalikan

                    </small>

                    <h3 class="fw-bold text-primary mt-2">

                        <?= $totalBelum; ?>

                    </h3>

                </div>

                <div
                class="bg-primary bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center"
                style="width:55px;height:55px;">

                    <i class="bi bi-book text-primary fs-4"></i>

                </div>

            </div>

        </div>

    </div>


    <!-- Jatuh Tempo Hari Ini -->

    <div class="col-lg-4">

        <div class="card border-0 shadow-sm rounded-4">

            <div class="card-body d-flex justify-content-between align-items-center">

                <div>

                    <small class="text-secondary">

                        Jatuh Tempo Hari Ini

                    </small>

                    <h3 class="fw-bold text-danger mt-2">

                        <?= $totalHariIni; ?>

                    </h3>

                </div>

                <div
                class="bg-danger bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center"
                style="width:55px;height:55px;">

                    <i class="bi bi-calendar-x text-danger fs-4"></i>

                </div>

            </div>

        </div>

    </div>


    <!-- Total Pengembalian -->

    <div class="col-lg-4">

        <div class="card border-0 shadow-sm rounded-4">

            <div class="card-body d-flex justify-content-between align-items-center">

                <div>

                    <small class="text-secondary">

                        Total Dikembalikan

                    </small>

                    <h3 class="fw-bold text-success mt-2">

                        <?= $totalPengembalian; ?>

                    </h3>

                </div>

                <div
                class="bg-success bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center"
                style="width:55px;height:55px;">

                    <i class="bi bi-check-circle text-success fs-4"></i>

                </div>

            </div>

        </div>

    </div>

</div>


<!-- ===================================== -->
<!-- RIWAYAT PENGEMBALIAN -->
<!-- ===================================== -->

<div class="card border-0 shadow-sm rounded-4">

    <div class="card-body">

        <h5 class="fw-bold mb-4">

            Riwayat Pengembalian

        </h5>
        <?php

if(mysqli_num_rows($query) > 0){

while($d = mysqli_fetch_assoc($query)){

?>

<div class="row align-items-center border-bottom py-3">

    <!-- COVER -->

    <div class="col-lg-1">

        <img

        src="../assets/image/buku/<?= $d['cover']; ?>"

        class="rounded"

        style="width:55px;height:75px;object-fit:cover;">

    </div>


    <!-- JUDUL -->

    <div class="col-lg-3">

        <h6 class="fw-bold mb-1">

            <?= $d['judul']; ?>

        </h6>

        <small class="text-secondary">

            <?= $d['penulis']; ?>

        </small>

    </div>


    <!-- TANGGAL PINJAM -->

    <div class="col-lg-2 text-center">

        <small class="text-secondary d-block">

            PINJAM

        </small>

        <strong>

            <?= date("d M Y",strtotime($d['tanggal_pinjam'])); ?>

        </strong>

    </div>


    <!-- TANGGAL KEMBALI -->

    <div class="col-lg-2 text-center">

        <small class="text-secondary d-block">

            KEMBALI

        </small>

        <strong>

            <?= date("d M Y",strtotime($d['tanggal_kembali'])); ?>

        </strong>

    </div>


    <!-- STATUS -->

    <div class="col-lg-2 text-center">

        <span class="badge bg-success">

            Dikembalikan

        </span>

        <?php if($d['denda'] > 0){ ?>

            <br>

            <small class="text-danger">

                Denda Rp <?= number_format($d['denda'],0,",","."); ?>

            </small>

        <?php } ?>

    </div>


    <!-- DETAIL -->

    <div class="col-lg-2 text-end">

<a
href="detail_pengembalian.php?id=<?= $d['id_pengembalian']; ?>"

class="btn btn-outline-primary btn-sm">

<i class="bi bi-eye"></i>

</a>
    </div>

</div>

<?php

}

}else{

?>

<div class="text-center py-5">

    <i class="bi bi-journal-x fs-1 text-secondary"></i>

    <h5 class="mt-3">

        Belum Ada Riwayat Pengembalian

    </h5>

    <p class="text-secondary">

        Buku yang sudah dikembalikan akan muncul di sini.

    </p>

</div>

<?php

}

?>

</div>

</div>

</div>

<?php include "../includes/footer.php"; ?>