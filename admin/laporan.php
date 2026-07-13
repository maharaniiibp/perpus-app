<?php

session_start();

if (!isset($_SESSION['role'])) {

    header("Location: ../auth/login.php");
    exit;

}

include "../config/koneksi.php";


// ==============================
// TOTAL PEMINJAMAN
// ==============================

$totalPinjam = mysqli_fetch_assoc(mysqli_query($conn,"
SELECT COUNT(*) AS total
FROM peminjaman
"));


// ==============================
// TOTAL PENGEMBALIAN
// ==============================

$totalKembali = mysqli_fetch_assoc(mysqli_query($conn,"
SELECT COUNT(*) AS total
FROM pengembalian
"));


// ==============================
// TOTAL DENDA
// ==============================

$totalDenda = mysqli_fetch_assoc(mysqli_query($conn,"
SELECT IFNULL(SUM(denda),0) AS total
FROM pengembalian
"));


// ==============================
// BUKU TERPOPULER
// ==============================

$bukuPopuler = mysqli_fetch_assoc(mysqli_query($conn,"
SELECT
buku.judul,
COUNT(*) AS total
FROM peminjaman
INNER JOIN buku
ON buku.id_buku = peminjaman.id_buku
GROUP BY buku.id_buku
ORDER BY total DESC
LIMIT 1
"));

include "../includes/header.php";
include "../includes/sidebar_admin.php";

?>

<div
class="container-fluid"
style="
margin-left:250px;
padding:25px;
background:#F5F7FB;
min-height:100vh;
">

<?php include "../includes/navbar_admin.php"; ?>


<!-- HEADER -->

<div class="d-flex justify-content-between align-items-center mb-4">

    <div>

        <h2 class="fw-bold mb-1">

            Laporan Perpustakaan

        </h2>

        <p class="text-secondary">

            Analisis aktivitas peminjaman dan pengembalian buku.

        </p>

    </div>

</div>



<!-- FILTER -->

<div class="card border-0 shadow-sm rounded-4 mb-4">

    <div class="card-body">

        <form method="GET">

            <div class="row g-3">

                <div class="col-lg-4">

                    <label class="form-label">

                        Bulan

                    </label>

                    <select
                        name="bulan"
                        class="form-select">

                        <option value="">

                            Semua Bulan

                        </option>

                        <?php

                        for($i=1;$i<=12;$i++){

                        ?>

                        <option value="<?= $i; ?>">

                            <?= date("F",mktime(0,0,0,$i,1)); ?>

                        </option>

                        <?php

                        }

                        ?>

                    </select>

                </div>



                <div class="col-lg-4">

                    <label class="form-label">

                        Tahun

                    </label>

                    <select
                        name="tahun"
                        class="form-select">

                        <?php

                        for($i=date("Y");$i>=2024;$i--){

                        ?>

                        <option value="<?= $i; ?>">

                            <?= $i; ?>

                        </option>

                        <?php

                        }

                        ?>

                    </select>

                </div>



                <div class="col-lg-2">

                    <label class="form-label">

                        &nbsp;

                    </label>

                    <button
                        class="btn btn-primary w-100">

                        <i class="bi bi-funnel me-2"></i>

                        Filter

                    </button>

                </div>



                <div class="col-lg-2">

                    <label class="form-label">

                        &nbsp;

                    </label>

                    <button
                        type="button"
                        class="btn btn-success w-100">

                        <i class="bi bi-file-earmark-excel me-2"></i>

                        Export

                    </button>

                </div>

            </div>

        </form>

    </div>

</div>



<!-- CARD STATISTIK -->

<div class="row g-3 mb-4">

    <div class="col-lg-3">

        <div class="card border-0 shadow-sm rounded-4">

            <div class="card-body">

                <small class="text-secondary">

                    Total Peminjaman

                </small>

                <h2 class="fw-bold mt-2">

                    <?= $totalPinjam['total']; ?>

                </h2>

            </div>

        </div>

    </div>



    <div class="col-lg-3">

        <div class="card border-0 shadow-sm rounded-4">

            <div class="card-body">

                <small class="text-secondary">

                    Total Pengembalian

                </small>

                <h2 class="fw-bold text-success mt-2">

                    <?= $totalKembali['total']; ?>

                </h2>

            </div>

        </div>

    </div>



    <div class="col-lg-3">

        <div class="card border-0 shadow-sm rounded-4">

            <div class="card-body">

                <small class="text-secondary">

                    Buku Terpopuler

                </small>

                <h5 class="fw-bold mt-2">

                    <?= !empty($bukuPopuler['judul']) ? $bukuPopuler['judul'] : "-"; ?>

                </h5>

                <small class="text-secondary">

                    <?= !empty($bukuPopuler['total']) ? $bukuPopuler['total'] : 0; ?> kali dipinjam

                </small>

            </div>

        </div>

    </div>



    <div class="col-lg-3">

        <div class="card border-0 shadow-sm rounded-4">

            <div class="card-body">

                <small class="text-secondary">

                    Total Denda

                </small>

                <h4 class="fw-bold text-danger mt-2">

                    Rp<?= number_format($totalDenda['total'],0,',','.'); ?>

                </h4>

            </div>

        </div>

    </div>

</div>

<?php

// ======================================
// DATA GRAFIK PEMINJAMAN
// ======================================

$grafik = mysqli_query($conn,"
SELECT
MONTH(tanggal_pinjam) AS bulan,
COUNT(*) AS total
FROM peminjaman
GROUP BY MONTH(tanggal_pinjam)
ORDER BY MONTH(tanggal_pinjam)
");

$label = [];
$dataChart = [];

while($g = mysqli_fetch_assoc($grafik)){

    $label[] = date("M", mktime(0,0,0,$g['bulan'],1));
    $dataChart[] = $g['total'];

}


// ======================================
// RINGKASAN BULANAN
// ======================================

$ringkasan = mysqli_query($conn,"
SELECT

DATE_FORMAT(tanggal_pinjam,'%M %Y') AS periode,

COUNT(*) AS total_pinjam,

SUM(
CASE
WHEN status='Dikembalikan'
THEN 1
ELSE 0
END
) AS total_kembali

FROM peminjaman

GROUP BY MONTH(tanggal_pinjam),YEAR(tanggal_pinjam)

ORDER BY tanggal_pinjam DESC

");

?>



<div class="row g-4 mb-4">

    <!-- GRAFIK -->

    <div class="col-lg-7">

        <div class="card border-0 shadow-sm rounded-4 h-100">

            <div class="card-body">

                <h5 class="fw-bold mb-4">

                    Grafik Peminjaman Buku

                </h5>

                <canvas id="chartPinjam" height="120"></canvas>

            </div>

        </div>

    </div>



    <!-- RINGKASAN -->

    <div class="col-lg-5">

        <div class="card border-0 shadow-sm rounded-4 h-100">

            <div class="card-body">

                <h5 class="fw-bold mb-4">

                    Ringkasan Bulanan

                </h5>

                <div class="table-responsive">

                    <table class="table table-borderless align-middle">

                        <thead>

                            <tr>

                                <th>Periode</th>

                                <th>Pinjam</th>

                                <th>Kembali</th>

                            </tr>

                        </thead>

                        <tbody>

<?php

if(mysqli_num_rows($ringkasan)>0){

while($r=mysqli_fetch_assoc($ringkasan)){

?>

<tr>

<td><?= $r['periode']; ?></td>

<td>

<span class="badge bg-primary">

<?= $r['total_pinjam']; ?>

</span>

</td>

<td>

<span class="badge bg-success">

<?= $r['total_kembali']; ?>

</span>

</td>

</tr>

<?php

}

}else{

?>

<tr>

<td colspan="3" class="text-center text-secondary">

Belum ada data.

</td>

</tr>

<?php

}

?>

                        </tbody>

                    </table>

                </div>

            </div>

        </div>

    </div>

</div>



<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>

const ctx = document.getElementById("chartPinjam");

new Chart(ctx,{

type:"bar",

data:{

labels:<?= json_encode($label); ?>,

datasets:[{

label:"Peminjaman",

data:<?= json_encode($dataChart); ?>,

backgroundColor:"#2563eb",

borderRadius:8

}]

},

options:{

responsive:true,

plugins:{

legend:{

display:false

}

},

scales:{

y:{

beginAtZero:true

}

}

}

});

</script>

<!-- DETAIL LAPORAN -->

<div class="card border-0 shadow-sm rounded-4">

    <div class="card-header bg-white border-0 py-3">

        <div class="d-flex justify-content-between align-items-center">

            <h5 class="fw-bold mb-0">

                Detail Laporan Transaksi

            </h5>

            <button
                onclick="window.print()"
                class="btn btn-primary">

                <i class="bi bi-printer me-2"></i>

                Cetak Laporan

            </button>

        </div>

    </div>

    <div class="table-responsive">

        <table class="table table-hover align-middle mb-0">

            <thead class="table-light">

                <tr>

                    <th>No</th>

                    <th>Siswa</th>

                    <th>Buku</th>

                    <th>Tanggal Pinjam</th>

                    <th>Tanggal Kembali</th>

                    <th>Denda</th>

                    <th>Status</th>

                </tr>

            </thead>

            <tbody>

<?php

$laporanDetail = mysqli_query($conn,"

SELECT

peminjaman.*,

siswa.nama_siswa,

buku.judul,

pengembalian.tanggal_kembali,

pengembalian.denda

FROM peminjaman

INNER JOIN siswa
ON siswa.id_siswa = peminjaman.id_siswa

INNER JOIN buku
ON buku.id_buku = peminjaman.id_buku

LEFT JOIN pengembalian
ON pengembalian.id_pinjam = peminjaman.id_pinjam

ORDER BY peminjaman.tanggal_pinjam DESC

");

$no=1;

if(mysqli_num_rows($laporanDetail)>0){

while($d=mysqli_fetch_assoc($laporanDetail)){

?>

<tr>

<td>

<?= $no++; ?>

</td>

<td>

<?= $d['nama_siswa']; ?>

</td>

<td>

<?= $d['judul']; ?>

</td>

<td>

<?= date("d-m-Y",strtotime($d['tanggal_pinjam'])); ?>

</td>

<td>

<?php

if(!empty($d['tanggal_kembali'])){

    echo date("d-m-Y",strtotime($d['tanggal_kembali']));

}else{

    echo "-";

}

?>

</td>

<td>

Rp<?= number_format($d['denda'] ?? 0,0,",","."); ?>

</td>

<td>

<?php

if(!empty($d['tanggal_kembali'])){

?>

<span class="badge bg-success">

Dikembalikan

</span>

<?php

}else{

?>

<span class="badge bg-warning text-dark">

Dipinjam

</span>

<?php

}

?>

</td>

</tr>

<?php

}

}else{

?>

<tr>

<td colspan="7" class="text-center py-5">

<i class="bi bi-folder-x fs-1 text-secondary"></i>

<h5 class="mt-3">

Belum Ada Laporan

</h5>

<p class="text-secondary">

Belum ada transaksi peminjaman.

</p>

</td>

</tr>

<?php

}

?>

            </tbody>

        </table>

    </div>

    <div class="card-footer bg-white">

        <small class="text-secondary">

            Total Data :

            <strong>

                <?= mysqli_num_rows($laporanDetail); ?>

            </strong>

            transaksi

        </small>

    </div>

</div>

</div>

<?php include "../includes/footer.php"; ?>