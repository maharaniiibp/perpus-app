<?php

session_start();

if(!isset($_SESSION['role'])){

    header("Location: ../auth/login.php");
    exit;

}

include "../config/koneksi.php";


// ==========================
// CARD STATISTIK
// ==========================

// Total Pengembalian

$total = mysqli_fetch_assoc(

mysqli_query($conn,"
SELECT COUNT(*) AS total
FROM pengembalian
")

);


// Sudah Kembali

$selesai = mysqli_fetch_assoc(

mysqli_query($conn,"
SELECT COUNT(*) AS total
FROM pengembalian
WHERE status='Selesai'
")

);


// Terlambat

$terlambat = mysqli_fetch_assoc(

mysqli_query($conn,"
SELECT COUNT(*) AS total
FROM pengembalian
WHERE terlambat='Ya'
")

);


// Total Denda

$denda = mysqli_fetch_assoc(

mysqli_query($conn,"
SELECT SUM(denda) AS total
FROM pengembalian
")

);

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

Data Pengembalian

</h2>

<p class="text-secondary mb-0">

Kelola seluruh transaksi pengembalian buku.

</p>

</div>

<a

href="tambah_pengembalian.php"

class="btn btn-primary">

<i class="bi bi-plus-circle me-2"></i>

Tambah Pengembalian

</a>

</div>



<!-- CARD -->

<div class="row g-3 mb-4">

<!-- TOTAL -->

<div class="col-lg-3">

<div class="card border-0 shadow-sm rounded-4">

<div class="card-body">

<div class="d-flex justify-content-between align-items-center">

<div>

<small class="text-secondary">

Total Pengembalian

</small>

<h2 class="fw-bold mt-2">

<?= $total['total']; ?>

</h2>

</div>

<div class="bg-primary bg-opacity-10 rounded-3 p-3">

<i class="bi bi-arrow-return-left fs-4 text-primary"></i>

</div>

</div>

</div>

</div>

</div>



<!-- SELESAI -->

<div class="col-lg-3">

<div class="card border-0 shadow-sm rounded-4">

<div class="card-body">

<div class="d-flex justify-content-between align-items-center">

<div>

<small class="text-secondary">

Sudah Kembali

</small>

<h2 class="fw-bold text-success mt-2">

<?= $selesai['total']; ?>

</h2>

</div>

<div class="bg-success bg-opacity-10 rounded-3 p-3">

<i class="bi bi-check-circle-fill fs-4 text-success"></i>

</div>

</div>

</div>

</div>

</div>



<!-- TERLAMBAT -->

<div class="col-lg-3">

<div class="card border-0 shadow-sm rounded-4">

<div class="card-body">

<div class="d-flex justify-content-between align-items-center">

<div>

<small class="text-secondary">

Terlambat

</small>

<h2 class="fw-bold text-danger mt-2">

<?= $terlambat['total']; ?>

</h2>

</div>

<div class="bg-danger bg-opacity-10 rounded-3 p-3">

<i class="bi bi-clock-history fs-4 text-danger"></i>

</div>

</div>

</div>

</div>

</div>



<!-- DENDA -->

<div class="col-lg-3">

<div class="card border-0 shadow-sm rounded-4">

<div class="card-body">

<div class="d-flex justify-content-between align-items-center">

<div>

<small class="text-secondary">

Total Denda

</small>

<h2 class="fw-bold mt-2">

Rp <?= number_format($denda['total'] ?? 0,0,',','.'); ?>

</h2>

</div>

<div class="bg-warning bg-opacity-10 rounded-3 p-3">

<i class="bi bi-cash-stack fs-4 text-warning"></i>

</div>

</div>

</div>

</div>

</div>

</div>

<?php

// =====================================
// FILTER
// =====================================

$search = isset($_GET['search']) ? mysqli_real_escape_string($conn,$_GET['search']) : "";
$status = isset($_GET['status']) ? mysqli_real_escape_string($conn,$_GET['status']) : "";

$where = " WHERE 1=1 ";

if($search!=""){

    $where .= " AND (

        siswa.nama_siswa LIKE '%$search%'

        OR siswa.nis LIKE '%$search%'

        OR buku.judul LIKE '%$search%'

    )";

}

if($status!=""){

    $where .= " AND pengembalian.status='$status' ";

}


// =====================================
// QUERY
// =====================================

$query = mysqli_query($conn,"

SELECT

pengembalian.*,

peminjaman.tanggal_pinjam,

buku.judul,

siswa.nama_siswa,
siswa.nis,
siswa.kelas,
siswa.foto

FROM pengembalian

INNER JOIN peminjaman
ON peminjaman.id_pinjam=pengembalian.id_pinjam

INNER JOIN siswa
ON siswa.id_siswa=peminjaman.id_siswa

INNER JOIN buku
ON buku.id_buku=peminjaman.id_buku

$where

ORDER BY pengembalian.id_pengembalian DESC

");

?>



<!-- FILTER -->

<div class="card border-0 shadow-sm rounded-4 mb-4">

<div class="card-body">

<form method="GET">

<div class="row g-3">

<!-- SEARCH -->

<div class="col-lg-8">

<div class="input-group">

<span class="input-group-text bg-light border-0">

<i class="bi bi-search"></i>

</span>

<input

type="text"

name="search"

class="form-control border-0 bg-light"

placeholder="Cari nama siswa, NIS, atau judul buku..."

value="<?= $search; ?>">

</div>

</div>



<!-- STATUS -->

<div class="col-lg-2">

<select

name="status"

class="form-select">

<option value="">

Semua Status

</option>

<option

value="Selesai"

<?= ($status=="Selesai") ? "selected" : ""; ?>>

Selesai

</option>

<option

value="Terlambat"

<?= ($status=="Terlambat") ? "selected" : ""; ?>>

Terlambat

</option>

</select>

</div>



<!-- BUTTON -->

<div class="col-lg-2">

<div class="d-flex gap-2">

<button

class="btn btn-primary flex-fill">

Filter

</button>

<a

href="pengembalian.php"

class="btn btn-outline-secondary">

<i class="bi bi-arrow-clockwise"></i>

</a>

</div>

</div>

</div>

</form>

</div>

</div>



<!-- TABLE -->

<div class="card border-0 shadow-sm rounded-4">

<div class="table-responsive">

<table class="table table-hover align-middle mb-0">

<thead class="table-light">

<tr>

<th width="60">No</th>

<th>Siswa</th>

<th>NIS</th>

<th>Buku</th>

<th>Tgl Pinjam</th>

<th>Tgl Kembali</th>

<th>Denda</th>

<th>Status</th>

<th class="text-center">Aksi</th>

</tr>

</thead>

<tbody>

<?php

$no = 1;

if(mysqli_num_rows($query)>0){

?>

<?php

while($data = mysqli_fetch_assoc($query)){

?>

<tr>

    <!-- NO -->

    <td>

        <?= $no++; ?>

    </td>



    <!-- SISWA -->

    <td>

        <div class="d-flex align-items-center">

            <?php

            if(!empty($data['foto']) && file_exists("../assets/image/siswa/".$data['foto'])){

            ?>

                <img

                    src="../assets/image/siswa/<?= $data['foto']; ?>"

                    width="45"

                    height="45"

                    class="rounded-circle me-3"

                    style="object-fit:cover;">

            <?php

            }else{

            ?>

                <img

                    src="../assets/image/default-user.png"

                    width="45"

                    height="45"

                    class="rounded-circle me-3"

                    style="object-fit:cover;">

            <?php

            }

            ?>

            <div>

                <div class="fw-semibold">

                    <?= $data['nama_siswa']; ?>

                </div>

                <small class="text-secondary">

                    <?= $data['kelas']; ?>

                </small>

            </div>

        </div>

    </td>



    <!-- NIS -->

    <td>

        <?= $data['nis']; ?>

    </td>



    <!-- BUKU -->

    <td>

        <?= $data['judul']; ?>

    </td>



    <!-- TANGGAL PINJAM -->

    <td>

        <?= date('d M Y', strtotime($data['tanggal_pinjam'])); ?>

    </td>



    <!-- TANGGAL KEMBALI -->

    <td>

        <?= date('d M Y', strtotime($data['tanggal_kembali'])); ?>

    </td>



    <!-- DENDA -->

    <td>

        <?php

        if($data['denda'] > 0){

        ?>

            <span class="fw-bold text-danger">

                Rp <?= number_format($data['denda'],0,',','.'); ?>

            </span>

        <?php

        }else{

            echo "-";

        }

        ?>

    </td>



    <!-- STATUS -->

    <td>

        <?php

        if($data['status']=="Selesai"){

        ?>

            <span class="badge bg-success">

                Selesai

            </span>

        <?php

        }else{

        ?>

            <span class="badge bg-danger">

                Terlambat

            </span>

        <?php

        }

        ?>

    </td>



    <!-- AKSI -->

    <td class="text-center">

        <div class="d-flex justify-content-center gap-3">

            <a

                href="detail_pengembalian.php?id=<?= $data['id_pengembalian']; ?>"

                class="text-secondary"

                title="Detail">

                <i class="bi bi-eye-fill"></i>

            </a>

            <a

                href="edit_pengembalian.php?id=<?= $data['id_pengembalian']; ?>"

                class="text-primary"

                title="Edit">

                <i class="bi bi-pencil-square"></i>

            </a>

            <a

                href="hapus_pengembalian.php?id=<?= $data['id_pengembalian']; ?>"

                class="text-danger"

                onclick="return confirm('Yakin ingin menghapus data ini?')"

                title="Hapus">

                <i class="bi bi-trash-fill"></i>

            </a>

        </div>

    </td>

</tr>

<?php

}

?>

<?php

}else{

?>

<tr>

    <td colspan="9" class="text-center py-5">

        <i class="bi bi-inbox fs-1 text-secondary"></i>

        <h5 class="fw-bold mt-3">

            Belum Ada Data Pengembalian

        </h5>

        <p class="text-secondary mb-0">

            Data pengembalian buku belum tersedia.

        </p>

    </td>

</tr>

<?php

}

?>

</tbody>

</table>

</div>



<!-- FOOTER TABLE -->

<div class="card-footer bg-white border-0 py-3">

    <div class="d-flex justify-content-between align-items-center">

        <small class="text-secondary">

            Menampilkan

            <strong>

                <?= mysqli_num_rows($query); ?>

            </strong>

            data pengembalian

        </small>



        <!-- Pagination UI -->

        <nav>

            <ul class="pagination pagination-sm mb-0">

                <li class="page-item disabled">

                    <a class="page-link">

                        <i class="bi bi-chevron-left"></i>

                    </a>

                </li>

                <li class="page-item active">

                    <a class="page-link">

                        1

                    </a>

                </li>

                <li class="page-item disabled">

                    <a class="page-link">

                        <i class="bi bi-chevron-right"></i>

                    </a>

                </li>

            </ul>

        </nav>

    </div>

</div>

</div>

</div>

<?php include "../includes/footer.php"; ?>