<?php

session_start();

if (!isset($_SESSION['role'])) {

    header("Location: ../auth/login.php");
    exit;
}

include "../config/koneksi.php";


// ================================
// QUERY DASHBOARD
// ================================

// Total Buku
$qBuku = mysqli_query($conn, "SELECT COUNT(*) AS total FROM buku");
$totalBuku = mysqli_fetch_assoc($qBuku);

// Total Siswa
$qSiswa = mysqli_query($conn, "SELECT COUNT(*) AS total FROM siswa");
$totalSiswa = mysqli_fetch_assoc($qSiswa);

// Total Buku Dipinjam
$qPinjam = mysqli_query($conn,"
SELECT COUNT(*) AS total
FROM peminjaman
WHERE status='Dipinjam'
");
$totalPinjam = mysqli_fetch_assoc($qPinjam);

// Total Terlambat
$qTerlambat = mysqli_query($conn,"
SELECT COUNT(*) AS total
FROM peminjaman
WHERE status='Dipinjam'
AND batas_kembali < CURDATE()
");

$totalTerlambat = mysqli_fetch_assoc($qTerlambat);

// Ambil Data Admin
$idAdmin = $_SESSION['id'];

$qAdmin = mysqli_query($conn,"
SELECT *
FROM admin
WHERE id_admin='$idAdmin'
");

$admin = mysqli_fetch_assoc($qAdmin);


// ================================
// INCLUDE
// ================================

include "../includes/header.php";

include "../includes/sidebar_admin.php";

?>

<!-- CONTENT -->

<div
class="container-fluid"
style="
margin-left:250px;
background:#F5F7FB;
min-height:100vh;
padding:25px;
">

<?php include "../includes/navbar_admin.php"; ?>


<!-- HEADER DASHBOARD -->

<div class="mb-4">

    <h2 class="fw-bold mb-1">

        Dashboard Admin

    </h2>

    <p class="text-secondary mb-0">

        Kelola dan pantau aktivitas perpustakaan

    </p>

</div>


<!-- CARD STATISTIK -->

<div class="row g-4">

<!-- =========================
CARD 1 - TOTAL BUKU
========================= -->

<div class="col-xl-3 col-lg-6 col-md-6">

    <div class="card border-0 shadow-sm rounded-4 h-100">

        <div class="card-body">

            <div class="d-flex justify-content-between align-items-start">

                <div>

                    <small class="text-secondary">

                        Total Buku

                    </small>

                    <h2 class="fw-bold mt-2 mb-1">

                        <?= number_format($totalBuku['total']); ?>

                    </h2>

                    <small class="text-success">

                        <i class="bi bi-arrow-up"></i>

                        +12% bulan ini

                    </small>

                </div>

                <div
                class="rounded-4 d-flex align-items-center justify-content-center"
                style="
                width:55px;
                height:55px;
                background:#EEF2FF;">

                    <i
                    class="bi bi-book fs-4"
                    style="color:#2563EB;"></i>

                </div>

            </div>

        </div>

    </div>

</div>



<!-- =========================
CARD 2 - TOTAL SISWA
========================= -->

<div class="col-xl-3 col-lg-6 col-md-6">

    <div class="card border-0 shadow-sm rounded-4 h-100">

        <div class="card-body">

            <div class="d-flex justify-content-between align-items-start">

                <div>

                    <small class="text-secondary">

                        Total Siswa

                    </small>

                    <h2 class="fw-bold mt-2 mb-1">

                        <?= number_format($totalSiswa['total']); ?>

                    </h2>

                    <small class="text-success">

                        +5% pendaftar baru

                    </small>

                </div>

                <div
                class="rounded-4 d-flex align-items-center justify-content-center"
                style="
                width:55px;
                height:55px;
                background:#ECFDF5;">

                    <i
                    class="bi bi-people fs-4"
                    style="color:#16A34A;"></i>

                </div>

            </div>

        </div>

    </div>

</div>



<!-- =========================
CARD 3 - DIPINJAM
========================= -->

<div class="col-xl-3 col-lg-6 col-md-6">

    <div class="card border-0 shadow-sm rounded-4 h-100">

        <div class="card-body">

            <div class="d-flex justify-content-between align-items-start">

                <div>

                    <small class="text-secondary">

                        Buku Dipinjam

                    </small>

                    <h2 class="fw-bold mt-2 mb-1">

                        <?= number_format($totalPinjam['total']); ?>

                    </h2>

                    <small class="text-secondary">

                        Aktif sirkulasi

                    </small>

                </div>

                <div
                class="rounded-4 d-flex align-items-center justify-content-center"
                style="
                width:55px;
                height:55px;
                background:#FEF3C7;">

                    <i
                    class="bi bi-arrow-left-right fs-4"
                    style="color:#D97706;"></i>

                </div>

            </div>

        </div>

    </div>

</div>



<!-- =========================
CARD 4 - TERLAMBAT
========================= -->

<div class="col-xl-3 col-lg-6 col-md-6">

    <div class="card border-0 shadow-sm rounded-4 h-100">

        <div class="card-body">

            <div class="d-flex justify-content-between align-items-start">

                <div>

                    <small class="text-secondary">

                        Keterlambatan

                    </small>

                    <h2 class="fw-bold mt-2 mb-1 text-danger">

                        <?= number_format($totalTerlambat['total']); ?>

                    </h2>

                    <small class="text-danger">

                        Perlu tindakan

                    </small>

                </div>

                <div
                class="rounded-4 d-flex align-items-center justify-content-center"
                style="
                width:55px;
                height:55px;
                background:#FEE2E2;">

                    <i
                    class="bi bi-clock-history fs-4"
                    style="color:#EF4444;"></i>

                </div>

            </div>

        </div>

    </div>

</div>

</div>

<!-- AKHIR ROW CARD -->


<!-- ROW GRAFIK -->

<div class="row mt-4">

<!-- ==========================================
MONTHLY BORROWING ACTIVITY
=========================================== -->

<div class="col-lg-8">

    <div class="card border-0 shadow-sm rounded-4 h-100">

        <div class="card-header bg-white border-0 pt-4 px-4">

            <div class="d-flex justify-content-between align-items-center">

                <h6 class="fw-semibold mb-0">

                    Monthly Borrowing Activity

                </h6>

                <select class="form-select form-select-sm" style="width:130px;">

                    <option>

                        Tahun 2026

                    </option>

                </select>

            </div>

        </div>

        <div class="card-body px-4 pb-4">

            <canvas
                id="chartBorrow"
                style="height:320px;">

            </canvas>

        </div>

    </div>

</div>



<!-- ==========================================
BOOK STATUS
=========================================== -->

<div class="col-lg-4">

    <div class="card border-0 shadow-sm rounded-4 h-100">

        <div class="card-header bg-white border-0 pt-4 px-4">

            <h6 class="fw-semibold mb-0">

                Book Status

            </h6>

        </div>

        <div class="card-body text-center">

<?php

// Total buku

$total_buku = mysqli_fetch_assoc(

mysqli_query($conn,

"SELECT COUNT(*) total FROM buku")

)['total'];



// Dipinjam

$total_pinjam = mysqli_fetch_assoc(

mysqli_query($conn,

"SELECT COUNT(*) total

FROM peminjaman

WHERE status='Dipinjam'")

)['total'];



// Rusak

$total_rusak = 0;

if(mysqli_num_rows(

mysqli_query($conn,

"SHOW COLUMNS FROM buku LIKE 'status'"))>0){

$total_rusak = mysqli_fetch_assoc(

mysqli_query($conn,

"SELECT COUNT(*) total

FROM buku

WHERE status='Rusak'")

)['total'];

}



// Tersedia

$tersedia =

$total_buku -

$total_pinjam -

$total_rusak;

?>

            <div
            style="
            width:220px;
            margin:auto;
            ">

                <canvas id="chartStatus"></canvas>

            </div>

            <hr>

            <div class="mt-3">

                <div class="d-flex justify-content-between mb-2">

                    <span>

                        <i class="bi bi-circle-fill text-primary me-2"></i>

                        Tersedia

                    </span>

                    <strong>

                        <?= $tersedia ?>

                    </strong>

                </div>

                <div class="d-flex justify-content-between mb-2">

                    <span>

                        <i class="bi bi-circle-fill text-success me-2"></i>

                        Dipinjam

                    </span>

                    <strong>

                        <?= $total_pinjam ?>

                    </strong>

                </div>

                <div class="d-flex justify-content-between">

                    <span>

                        <i class="bi bi-circle-fill text-danger me-2"></i>

                        Rusak

                    </span>

                    <strong>

                        <?= $total_rusak ?>

                    </strong>

                </div>

            </div>

        </div>

    </div>

</div>

</div>
<!-- END ROW -->

<?php

// ======================================
// DATA GRAFIK PEMINJAMAN PER BULAN
// ======================================

$dataBulanan = array_fill(1,12,0);

$queryChart = mysqli_query($conn,"
SELECT
MONTH(tanggal_pinjam) bulan,
COUNT(*) total
FROM peminjaman
GROUP BY MONTH(tanggal_pinjam)
");

while($row=mysqli_fetch_assoc($queryChart)){

    $dataBulanan[$row['bulan']]=$row['total'];

}

?>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>

const chartBorrow = document.getElementById("chartBorrow");

new Chart(chartBorrow,{

type:'bar',

data:{

labels:[
'Jan',
'Feb',
'Mar',
'Apr',
'Mei',
'Jun',
'Jul',
'Agu',
'Sep',
'Okt',
'Nov',
'Des'
],

datasets:[{

label:'Peminjaman',

data:[

<?= implode(",",$dataBulanan); ?>

],

backgroundColor:'#2563EB',

borderRadius:8,

barThickness:28

}]

},

options:{

responsive:true,

maintainAspectRatio:false,

plugins:{

legend:{

display:false

}

},

scales:{

y:{

beginAtZero:true,

grid:{

drawBorder:false

}

},

x:{

grid:{

display:false

}

}

}

}

});





const chartStatus=document.getElementById("chartStatus");

new Chart(chartStatus,{

type:'doughnut',

data:{

labels:[

'Tersedia',

'Dipinjam',

'Rusak'

],

datasets:[{

data:[

<?= $tersedia ?>,

<?= $total_pinjam ?>,

<?= $total_rusak ?>

],

backgroundColor:[

'#2563EB',

'#22C55E',

'#EF4444'

],

borderWidth:0

}]

},

options:{

responsive:true,

cutout:'70%',

plugins:{

legend:{

display:false

}

}

}

});

</script>

<!-- =======================================================
RECENT TRANSACTIONS + NOTIFICATION
======================================================= -->

<div class="row mt-4">

    <!-- RECENT TRANSACTION -->

    <div class="col-lg-9">

        <div class="card border-0 shadow-sm rounded-4">

            <div class="card-header bg-white border-0 py-3">

                <div class="d-flex justify-content-between align-items-center">

                    <div>

                        <h6 class="fw-bold mb-0">

                            Recent Transactions

                        </h6>

                    </div>

                    <a
                        href="peminjaman.php"
                        class="text-decoration-none small fw-semibold">

                        Lihat Semua

                    </a>

                </div>

            </div>

            <div class="card-body p-0">

                <div class="table-responsive">

                    <table class="table table-hover align-middle mb-0">

                        <thead class="table-light">

                            <tr>

                                <th width="60">

                                    No

                                </th>

                                <th>

                                    Student Name

                                </th>

                                <th>

                                    Book Title

                                </th>

                                <th>

                                    Date

                                </th>

                                <th class="text-center">

                                    Status

                                </th>

                            </tr>

                        </thead>

                        <tbody>

<?php

$queryTransaksi = mysqli_query($conn, "

SELECT

p.id_pinjam,

s.nama_siswa,

b.judul,

p.tanggal_pinjam,

p.status

FROM peminjaman p

INNER JOIN siswa s

ON s.id_siswa = p.id_siswa

INNER JOIN buku b

ON b.id_buku = p.id_buku

ORDER BY p.id_pinjam DESC

LIMIT 5

");

$no=1;

while($row=mysqli_fetch_assoc($queryTransaksi)){

?>

<tr>

<td>

<?= $no++; ?>

</td>

<td>

<div class="d-flex align-items-center">

<div

class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center me-2"

style="width:35px;height:35px;">

<?= strtoupper(substr($row['nama_siswa'],0,1)); ?>

</div>

<?= $row['nama_siswa']; ?>

</div>

</td>

<td>

<?= $row['judul']; ?>

</td>

<td>

<?= date('d M Y',strtotime($row['tanggal_pinjam'])); ?>

</td>

<td class="text-center">

<?php

if($row['status']=="Dipinjam"){

?>

<span class="badge bg-primary">

Dipinjam

</span>

<?php

}else{

?>

<span class="badge bg-success">

Kembali

</span>

<?php

}

?>

</td>

</tr>

<?php } ?>

<?php

if(mysqli_num_rows($queryTransaksi)==0){

?>

<tr>

<td colspan="5" class="text-center text-secondary py-5">

Belum ada transaksi peminjaman.

</td>

</tr>

<?php } ?>

</tbody>

</table>

</div>

</div>

</div>

</div>

    <!-- ==========================
         NOTIFICATION PANEL
    =========================== -->

    <div class="col-lg-3">

        <div class="card border-0 shadow-sm rounded-4 mb-3">

            <div class="card-header bg-white border-0 d-flex justify-content-between align-items-center">

                <h6 class="fw-bold mb-0">

                    Notifications

                </h6>

                <span class="badge bg-danger rounded-pill">

                    3

                </span>

            </div>

            <div class="card-body">

                <!-- Notification 1 -->

                <div class="border-start border-4 border-danger ps-3 mb-4">

                    <h6 class="text-danger mb-1">

                        Overdue Alert

                    </h6>

                    <small class="text-secondary">

                        Ada buku yang melewati batas pengembalian.

                    </small>

                    <div>

                        <small class="text-danger">

                            Perlu tindakan

                        </small>

                    </div>

                </div>

                <!-- Notification 2 -->

                <div class="border-start border-4 border-primary ps-3 mb-4">

                    <h6 class="text-primary mb-1">

                        System Update

                    </h6>

                    <small class="text-secondary">

                        Backup database berhasil dilakukan.

                    </small>

                </div>

                <!-- Notification 3 -->

                <div class="border-start border-4 border-success ps-3">

                    <h6 class="text-success mb-1">

                        New Member

                    </h6>

                    <small class="text-secondary">

                        Ada siswa baru terdaftar.

                    </small>

                </div>

                <hr>

                <button class="btn btn-outline-secondary btn-sm w-100 rounded-3">

                    Bersihkan Semua

                </button>

            </div>

        </div>



        <!-- ==========================
             CHECKOUT TODAY
        =========================== -->

        <div class="card border-0 shadow rounded-4 text-white"

            style="background:#2563EB;">

            <div class="card-body">

                <small>

                    Check-out Today

                </small>

                <h2 class="fw-bold mt-2">

                    <?= $totalPinjam['total']; ?>

                </h2>

                <div class="mb-3">

                    Books

                </div>

                <div class="progress"

                    style="height:8px;">

                    <?php

                    $persen = 0;

                    if($totalBuku['total']!=0){

                        $persen = ($totalPinjam['total']/$totalBuku['total'])*100;

                    }

                    ?>

                    <div

                        class="progress-bar bg-light"

                        style="width:<?= $persen ?>%">

                    </div>

                </div>

                <small>

                    <?= round($persen) ?>% dari total koleksi

                </small>

            </div>

        </div>

    </div>

</div>

<!-- END ROW -->



</div>

<?php include "../includes/footer.php"; ?>