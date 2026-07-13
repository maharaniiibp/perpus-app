<?php

session_start();

if (!isset($_SESSION['role'])) {

    header("Location: ../auth/login.php");
    exit;

}

include "../config/koneksi.php";


// ==============================
// TOTAL BUKU
// ==============================

$totalBuku = mysqli_fetch_assoc(
mysqli_query($conn,"
SELECT COUNT(*) total
FROM buku
"));


// ==============================
// BUKU TERSEDIA
// ==============================

$bukuTersedia = mysqli_fetch_assoc(
mysqli_query($conn,"
SELECT SUM(stok) total
FROM buku
"));


// ==============================
// SEDANG DIPINJAM
// ==============================

$dipinjam = mysqli_fetch_assoc(
mysqli_query($conn,"
SELECT COUNT(*) total
FROM peminjaman
WHERE status='Dipinjam'
"));


// ==============================
// STOK HABIS
// ==============================

$stokHabis = mysqli_fetch_assoc(
mysqli_query($conn,"
SELECT COUNT(*) total
FROM buku
WHERE stok=0
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



<!-- ============================
HEADER
============================= -->

<div class="d-flex justify-content-between align-items-center mb-4">

<div>

<h2 class="fw-bold mb-1">

Data Buku

</h2>

<p class="text-secondary mb-0">

Kelola koleksi buku perpustakaan secara efisien

</p>

</div>

<a
href="tambah_buku.php"
class="btn btn-primary rounded-3 px-4">

<i class="bi bi-plus-lg me-2"></i>

Tambah Buku

</a>

</div>



<!-- ============================
CARD STATISTIK
============================= -->

<div class="row g-3 mb-4">

<!-- TOTAL -->

<div class="col-lg-3">

<div class="card border-0 shadow-sm rounded-4">

<div class="card-body">

<div class="d-flex justify-content-between">

<div>

<small class="text-secondary">

Total Buku

</small>

<h3 class="fw-bold mt-2">

<?= number_format($totalBuku['total']); ?>

</h3>

</div>

<div
class="rounded-circle d-flex align-items-center justify-content-center"
style="
width:55px;
height:55px;
background:#EEF2FF;">

<i
class="bi bi-book text-primary fs-4">

</i>

</div>

</div>

</div>

</div>

</div>



<!-- TERSEDIA -->

<div class="col-lg-3">

<div class="card border-0 shadow-sm rounded-4">

<div class="card-body">

<div class="d-flex justify-content-between">

<div>

<small class="text-secondary">

Buku Tersedia

</small>

<h3 class="fw-bold mt-2 text-success">

<?= number_format($bukuTersedia['total']); ?>

</h3>

</div>

<div
class="rounded-circle d-flex align-items-center justify-content-center"
style="
width:55px;
height:55px;
background:#ECFDF5;">

<i
class="bi bi-check-circle text-success fs-4">

</i>

</div>

</div>

</div>

</div>

</div>



<!-- DIPINJAM -->

<div class="col-lg-3">

<div class="card border-0 shadow-sm rounded-4">

<div class="card-body">

<div class="d-flex justify-content-between">

<div>

<small class="text-secondary">

Sedang Dipinjam

</small>

<h3 class="fw-bold mt-2 text-primary">

<?= number_format($dipinjam['total']); ?>

</h3>

</div>

<div
class="rounded-circle d-flex align-items-center justify-content-center"
style="
width:55px;
height:55px;
background:#EEF2FF;">

<i
class="bi bi-arrow-left-right text-primary fs-4">

</i>

</div>

</div>

</div>

</div>

</div>



<!-- HABIS -->

<div class="col-lg-3">

<div class="card border-0 shadow-sm rounded-4">

<div class="card-body">

<div class="d-flex justify-content-between">

<div>

<small class="text-secondary">

Stok Habis

</small>

<h3 class="fw-bold mt-2 text-danger">

<?= number_format($stokHabis['total']); ?>

</h3>

</div>

<div
class="rounded-circle d-flex align-items-center justify-content-center"
style="
width:55px;
height:55px;
background:#FEE2E2;">

<i
class="bi bi-x-circle text-danger fs-4">

</i>

</div>

</div>

</div>

</div>

</div>

</div>

<?php

// ==============================
// FILTER
// ==============================

$search   = isset($_GET['search']) ? mysqli_real_escape_string($conn,$_GET['search']) : "";
$kategori = isset($_GET['kategori']) ? $_GET['kategori'] : "";
$status   = isset($_GET['status']) ? $_GET['status'] : "";

?>

<!-- ======================================
SEARCH & FILTER
====================================== -->

<div class="card border-0 shadow-sm rounded-4 mb-4">

    <div class="card-body">

        <form method="GET">

            <div class="row g-3">

                <!-- SEARCH -->

                <div class="col-lg-5">

                    <div class="input-group">

                        <span class="input-group-text bg-light border-0">

                            <i class="bi bi-search"></i>

                        </span>

                        <input
                            type="text"
                            name="search"
                            class="form-control bg-light border-0"
                            placeholder="Cari judul buku, penulis atau ISBN..."
                            value="<?= $search; ?>">

                    </div>

                </div>



                <!-- KATEGORI -->

                <div class="col-lg-2">

                    <select
                        name="kategori"
                        class="form-select">

                        <option value="">

                            Semua Kategori

                        </option>

                        <?php

                        $qKategori = mysqli_query($conn,"
                        SELECT *
                        FROM kategori
                        ORDER BY nama_kategori ASC
                        ");

                        while($k=mysqli_fetch_assoc($qKategori)){

                        ?>

                        <option
                            value="<?= $k['id_kategori']; ?>"
                            <?= ($kategori==$k['id_kategori']) ? "selected" : ""; ?>>

                            <?= $k['nama_kategori']; ?>

                        </option>

                        <?php } ?>

                    </select>

                </div>



                <!-- STATUS -->

                <div class="col-lg-2">

                    <select
                        name="status"
                        class="form-select">

                        <option value="">

                            Semua Status

                        </option>

                        <option value="tersedia">

                            Tersedia

                        </option>

                        <option value="dipinjam">

                            Dipinjam

                        </option>

                        <option value="habis">

                            Habis

                        </option>

                    </select>

                </div>



                <!-- BUTTON -->

                <div class="col-lg-3">

                    <div class="d-flex gap-2">

                        <button
                            type="submit"
                            class="btn btn-primary w-100">

                            <i class="bi bi-search me-1"></i>

                            Cari

                        </button>

                        <a
                            href="buku.php"
                            class="btn btn-outline-secondary">

                            Reset

                        </a>

                    </div>

                </div>

            </div>

        </form>

    </div>

</div>

<?php

// ======================================
// QUERY DATA BUKU
// ======================================

$where = " WHERE 1=1 ";

if($search!=""){

    $where .= " AND (
        buku.judul LIKE '%$search%'
        OR buku.penulis LIKE '%$search%'
        OR buku.isbn LIKE '%$search%'
    )";

}

if($kategori!=""){

    $where .= " AND buku.id_kategori='$kategori' ";

}

if($status=="habis"){

    $where .= " AND buku.stok=0 ";

}

if($status=="tersedia"){

    $where .= " AND buku.stok>0 ";

}

$query = mysqli_query($conn,"

SELECT

buku.*,

kategori.nama_kategori,

lokasi.nama_lokasi

FROM buku

LEFT JOIN kategori
ON kategori.id_kategori=buku.id_kategori

LEFT JOIN lokasi
ON lokasi.id_lokasi=buku.id_lokasi

$where

ORDER BY buku.id_buku DESC

");

?>



<!-- ======================================
TABLE
====================================== -->

<div class="card border-0 shadow-sm rounded-4">

    <div class="table-responsive">

        <table class="table align-middle table-hover mb-0">

            <thead class="table-light">

                <tr>

                    <th width="60">

                        No

                    </th>

                    <th>

                        Buku

                    </th>

                    <th>

                        Penulis / Penerbit

                    </th>

                    <th>

                        Kategori

                    </th>

                    <th>

                        Tahun

                    </th>

                    <th>

                        Stok

                    </th>

                    <th>

                        Status

                    </th>

                    <th width="120">

                        Aksi

                    </th>

                </tr>

            </thead>

            <tbody>

<?php

$no=1;

?>

<?php

while($data = mysqli_fetch_assoc($query)){

    // ==========================
    // STATUS BUKU
    // ==========================

    $status = "Tersedia";
    $badge  = "success";

    $cekPinjam = mysqli_query($conn,"
    SELECT *
    FROM peminjaman
    WHERE id_buku='".$data['id_buku']."'
    AND status='Dipinjam'
    ");

    if(mysqli_num_rows($cekPinjam) > 0){

        $status = "Dipinjam";
        $badge  = "primary";

    }

    if($data['stok'] == 0){

        $status = "Stok Habis";
        $badge  = "danger";

    }

    // ==========================
    // COVER
    // ==========================

    $cover = "../assets/image/buku/".$data['cover'];

?>

<tr>

    <!-- NO -->

    <td class="text-center">

        <?= $no++; ?>

    </td>



    <!-- BUKU -->

    <td>

        <div class="d-flex align-items-center">

            <?php

            if(!empty($data['cover']) && file_exists($cover)){

            ?>

                <img

                    src="<?= $cover; ?>"

                    width="55"

                    height="75"

                    class="rounded shadow-sm me-3"

                    style="object-fit:cover;">

            <?php

            }else{

            ?>

                <img

                    src="../assets/image/no-book.png"

                    width="55"

                    height="75"

                    class="rounded shadow-sm me-3"

                    style="object-fit:cover;">

            <?php

            }

            ?>

            <div>

                <div class="fw-semibold">

                    <?= $data['judul']; ?>

                </div>

                <small class="text-secondary">

                    ISBN :

                    <?= $data['isbn']; ?>

                </small>

            </div>

        </div>

    </td>



    <!-- PENULIS -->

    <td>

        <div class="fw-semibold">

            <?= $data['penulis']; ?>

        </div>

        <small class="text-secondary">

            <?= $data['penerbit']; ?>

        </small>

    </td>



    <!-- KATEGORI -->

    <td>

        <span class="badge bg-light text-dark border">

            <?= $data['nama_kategori']; ?>

        </span>

    </td>



    <!-- TAHUN -->

    <td>

        <?= $data['tahun_terbit']; ?>

    </td>



    <!-- STOK -->

    <td>

        <span class="fw-semibold">

            <?= $data['stok']; ?>

        </span>

    </td>



    <!-- STATUS -->

    <td>

        <span class="badge bg-<?= $badge; ?>">

            <?= $status; ?>

        </span>

    </td>



    <!-- AKSI -->

    <td>

        <div class="d-flex justify-content-center gap-3">

            <!-- DETAIL -->

            <a

                href="detail_buku.php?id=<?= $data['id_buku']; ?>"

                class="text-secondary"

                title="Detail">

                <i class="bi bi-eye-fill"></i>

            </a>



            <!-- EDIT -->

            <a

                href="edit_buku.php?id=<?= $data['id_buku']; ?>"

                class="text-primary"

                title="Edit">

                <i class="bi bi-pencil-square"></i>

            </a>



            <!-- HAPUS -->

            <a

                href="hapus_buku.php?id=<?= $data['id_buku']; ?>"

                class="text-danger"

                onclick="return confirm('Yakin ingin menghapus buku ini?')"

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

if(mysqli_num_rows($query) == 0){

?>

<tr>

    <td colspan="8" class="text-center py-5">

        <i class="bi bi-book fs-1 text-secondary"></i>

        <h5 class="mt-3 fw-bold">

            Data Buku Tidak Ditemukan

        </h5>

        <p class="text-secondary">

            Belum ada data buku atau hasil pencarian tidak ditemukan.

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

                Total Buku :

                <strong>

                    <?= $totalBuku['total']; ?>

                </strong>

            </small>

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
