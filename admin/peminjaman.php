<?php

session_start();

if(!isset($_SESSION['role'])){

    header("Location: ../auth/login.php");
    exit;

}

include "../config/koneksi.php";


// ===================================
// STATISTIK
// ===================================

// Total Peminjaman

$totalPinjam = mysqli_fetch_assoc(

    mysqli_query($conn,"
    SELECT COUNT(*) AS total
    FROM peminjaman
    ")

);


// Sedang Dipinjam

$sedangDipinjam = mysqli_fetch_assoc(

    mysqli_query($conn,"
    SELECT COUNT(*) AS total
    FROM peminjaman
    WHERE status='Dipinjam'
    ")

);


// Sudah Dikembalikan

$sudahKembali = mysqli_fetch_assoc(

    mysqli_query($conn,"
    SELECT COUNT(*) AS total
    FROM peminjaman
    WHERE status='Dikembalikan'
    ")

);


// Terlambat

$terlambat = mysqli_fetch_assoc(

    mysqli_query($conn,"
    SELECT COUNT(*) AS total
    FROM peminjaman
    WHERE status='Dipinjam'
    AND batas_kembali < CURDATE()
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

            Data Peminjaman

        </h2>

        <p class="text-secondary mb-0">

            Kelola dan pantau seluruh transaksi peminjaman buku.

        </p>

    </div>

    <a

        href="tambah_peminjaman.php"

        class="btn btn-primary rounded-3">

        <i class="bi bi-plus-circle me-2"></i>

        Tambah Peminjaman

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

                            Total Peminjaman

                        </small>

                        <h2 class="fw-bold mt-2">

                            <?= $totalPinjam['total']; ?>

                        </h2>

                    </div>

                    <div class="bg-primary bg-opacity-10 rounded-3 p-3">

                        <i class="bi bi-journal-bookmark-fill fs-4 text-primary"></i>

                    </div>

                </div>

            </div>

        </div>

    </div>



    <!-- DIPINJAM -->

    <div class="col-lg-3">

        <div class="card border-0 shadow-sm rounded-4">

            <div class="card-body">

                <div class="d-flex justify-content-between align-items-center">

                    <div>

                        <small class="text-secondary">

                            Sedang Dipinjam

                        </small>

                        <h2 class="fw-bold text-success mt-2">

                            <?= $sedangDipinjam['total']; ?>

                        </h2>

                    </div>

                    <div class="bg-success bg-opacity-10 rounded-3 p-3">

                        <i class="bi bi-book-fill fs-4 text-success"></i>

                    </div>

                </div>

            </div>

        </div>

    </div>



    <!-- KEMBALI -->

    <div class="col-lg-3">

        <div class="card border-0 shadow-sm rounded-4">

            <div class="card-body">

                <div class="d-flex justify-content-between align-items-center">

                    <div>

                        <small class="text-secondary">

                            Sudah Dikembalikan

                        </small>

                        <h2 class="fw-bold text-secondary mt-2">

                            <?= $sudahKembali['total']; ?>

                        </h2>

                    </div>

                    <div class="bg-secondary bg-opacity-10 rounded-3 p-3">

                        <i class="bi bi-check-circle-fill fs-4 text-secondary"></i>

                    </div>

                </div>

            </div>

        </div>

    </div>



    <!-- TERLAMBAT -->

    <div class="col-lg-3">

        <div class="card border border-danger-subtle shadow-sm rounded-4">

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

                        <i class="bi bi-exclamation-triangle-fill fs-4 text-danger"></i>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>

<?php

// ==========================
// FILTER
// ==========================

$search  = isset($_GET['search']) ? mysqli_real_escape_string($conn,$_GET['search']) : "";
$status  = isset($_GET['status']) ? mysqli_real_escape_string($conn,$_GET['status']) : "";
$tanggal = isset($_GET['tanggal']) ? mysqli_real_escape_string($conn,$_GET['tanggal']) : "";

$where = "WHERE 1=1";

if($search!=""){

    $where .= " AND (
        siswa.nama_siswa LIKE '%$search%'
        OR siswa.nis LIKE '%$search%'
        OR buku.judul LIKE '%$search%'
    )";

}

if($status!=""){

    $where .= " AND peminjaman.status='$status'";

}

if($tanggal!=""){

    $where .= " AND peminjaman.tanggal_pinjam='$tanggal'";

}


// ==========================
// QUERY DATA
// ==========================

$query = mysqli_query($conn,"

SELECT

peminjaman.*,

siswa.nama_siswa,
siswa.nis,
siswa.kelas,
siswa.foto,

buku.judul,

admin.nama_admin

FROM peminjaman

INNER JOIN siswa
ON siswa.id_siswa=peminjaman.id_siswa

INNER JOIN buku
ON buku.id_buku=peminjaman.id_buku

INNER JOIN admin
ON admin.id_admin=peminjaman.id_admin

$where

ORDER BY id_pinjam DESC

");

?>



<!-- FILTER -->

<div class="card border-0 shadow-sm rounded-4 mb-4">

<div class="card-body">

<form method="GET">

<div class="row g-3 align-items-center">

    <!-- SEARCH -->

    <div class="col-lg-5">

        <div class="input-group">

            <span class="input-group-text bg-light border-0">

                <i class="bi bi-search"></i>

            </span>

            <input

                type="text"

                name="search"

                class="form-control border-0 bg-light"

                placeholder="Cari nama siswa atau judul buku..."

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

                value="Dipinjam"

                <?= ($status=="Dipinjam") ? "selected" : ""; ?>>

                Dipinjam

            </option>

            <option

                value="Dikembalikan"

                <?= ($status=="Dikembalikan") ? "selected" : ""; ?>>

                Dikembalikan

            </option>

        </select>

    </div>



    <!-- TANGGAL -->

    <div class="col-lg-3">

        <input

            type="date"

            name="tanggal"

            class="form-control"

            value="<?= $tanggal; ?>">

    </div>



    <!-- BUTTON -->

    <div class="col-lg-2">

        <div class="d-flex gap-2">

            <button

                type="submit"

                class="btn btn-primary flex-fill">

                Filter

            </button>

            <a

                href="peminjaman.php"

                class="btn btn-outline-secondary">

                <i class="bi bi-arrow-clockwise"></i>

            </a>

        </div>

    </div>

</div>

</form>

</div>

</div>



<!-- TABEL -->

<div class="card border-0 shadow-sm rounded-4">

<div class="table-responsive">

<table class="table align-middle table-hover mb-0">

<thead class="table-light">

<tr>

<th width="60">No</th>

<th>Siswa</th>

<th>NIS</th>

<th>Judul Buku</th>

<th>Tanggal Pinjam</th>

<th>Batas Kembali</th>

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

    // ===========================
    // STATUS
    // ===========================

    if($data['status']=="Dipinjam"){

        if(strtotime($data['batas_kembali']) < strtotime(date("Y-m-d"))){

            $badge = "danger";
            $status = "Terlambat";

        }else{

            $badge = "success";
            $status = "Sedang Dipinjam";

        }

    }else{

        $badge = "primary";
        $status = "Dikembalikan";

    }

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

                    class="rounded-circle me-3"

                    width="45"

                    height="45"

                    style="object-fit:cover;">

            <?php

            }else{

            ?>

                <img

                    src="../assets/image/default-user.png"

                    class="rounded-circle me-3"

                    width="45"

                    height="45">

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



    <!-- JUDUL -->

    <td>

        <?= $data['judul']; ?>

    </td>



    <!-- TANGGAL PINJAM -->

    <td>

        <?= date('d M Y',strtotime($data['tanggal_pinjam'])); ?>

    </td>



    <!-- BATAS KEMBALI -->

    <td>

        <?php

        if($status=="Terlambat"){

        ?>

            <span class="text-danger fw-semibold">

                <?= date('d M Y',strtotime($data['batas_kembali'])); ?>

            </span>

        <?php

        }else{

            echo date('d M Y',strtotime($data['batas_kembali']));

        }

        ?>

    </td>



    <!-- STATUS -->

    <td>

        <span class="badge bg-<?= $badge; ?>">

            <?= $status; ?>

        </span>

    </td>



    <!-- AKSI -->

    <td class="text-center">

        <div class="d-flex justify-content-center gap-3">

            <!-- DETAIL -->

            <a

                href="detail_peminjaman.php?id=<?= $data['id_pinjam']; ?>"

                class="text-secondary"

                title="Detail">

                <i class="bi bi-eye-fill"></i>

            </a>



            <!-- EDIT -->

            <a

                href="edit_peminjaman.php?id=<?= $data['id_pinjam']; ?>"

                class="text-primary"

                title="Edit">

                <i class="bi bi-pencil-square"></i>

            </a>



            <!-- HAPUS -->

            <a

                href="hapus_peminjaman.php?id=<?= $data['id_pinjam']; ?>"

                class="text-danger"

                title="Hapus"

                onclick="return confirm('Yakin ingin menghapus transaksi ini?')">

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

    <td colspan="8" class="text-center py-5">

        <i class="bi bi-journal-x fs-1 text-secondary"></i>

        <h5 class="fw-bold mt-3">

            Belum Ada Data Peminjaman

        </h5>

        <p class="text-secondary mb-0">

            Silakan tambahkan transaksi peminjaman terlebih dahulu.

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

<div class="card-footer bg-white border-0">

    <div class="d-flex justify-content-between align-items-center py-2">

        <small class="text-secondary">

            Menampilkan

            <strong>

                <?= mysqli_num_rows($query); ?>

            </strong>

            transaksi

        </small>



        <!-- PAGINATION UI -->

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