<?php

session_start();

if(!isset($_SESSION['role'])){

    header("Location: ../auth/login.php");
    exit;

}

include "../config/koneksi.php";


// ==============================
// CARD STATISTIK
// ==============================

// Total Siswa
$totalSiswa = mysqli_fetch_assoc(mysqli_query($conn,"
SELECT COUNT(*) AS total
FROM siswa
"));

// Laki-laki
$laki = mysqli_fetch_assoc(mysqli_query($conn,"
SELECT COUNT(*) AS total
FROM siswa
WHERE jenis_kelamin='L'
"));

// Perempuan
$perempuan = mysqli_fetch_assoc(mysqli_query($conn,"
SELECT COUNT(*) AS total
FROM siswa
WHERE jenis_kelamin='P'
"));

// Total Kelas
$kelas = mysqli_fetch_assoc(mysqli_query($conn,"
SELECT COUNT(DISTINCT kelas) AS total
FROM siswa
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

        <h2 class="fw-bold">

            Data Siswa

        </h2>

        <p class="text-secondary">

            Kelola seluruh data siswa perpustakaan.

        </p>

    </div>

    <a
        href="tambah_siswa.php"
        class="btn btn-primary">

        <i class="bi bi-plus-circle me-2"></i>

        Tambah Siswa

    </a>

</div>



<!-- CARD -->

<div class="row g-3 mb-4">

    <!-- TOTAL SISWA -->

    <div class="col-lg-3">

        <div class="card border-0 shadow-sm rounded-4">

            <div class="card-body">

                <div class="d-flex justify-content-between">

                    <div>

                        <small class="text-secondary">

                            Total Siswa

                        </small>

                        <h2 class="fw-bold mt-2">

                            <?= $totalSiswa['total']; ?>

                        </h2>

                    </div>

                    <div class="bg-primary bg-opacity-10 rounded-3 p-3">

                        <i class="bi bi-people-fill fs-4 text-primary"></i>

                    </div>

                </div>

            </div>

        </div>

    </div>



    <!-- LAKI-LAKI -->

    <div class="col-lg-3">

        <div class="card border-0 shadow-sm rounded-4">

            <div class="card-body">

                <div class="d-flex justify-content-between">

                    <div>

                        <small class="text-secondary">

                            Laki-laki

                        </small>

                        <h2 class="fw-bold text-primary mt-2">

                            <?= $laki['total']; ?>

                        </h2>

                    </div>

                    <div class="bg-info bg-opacity-10 rounded-3 p-3">

                        <i class="bi bi-gender-male fs-4 text-info"></i>

                    </div>

                </div>

            </div>

        </div>

    </div>



    <!-- PEREMPUAN -->

    <div class="col-lg-3">

        <div class="card border-0 shadow-sm rounded-4">

            <div class="card-body">

                <div class="d-flex justify-content-between">

                    <div>

                        <small class="text-secondary">

                            Perempuan

                        </small>

                        <h2 class="fw-bold text-danger mt-2">

                            <?= $perempuan['total']; ?>

                        </h2>

                    </div>

                    <div class="bg-danger bg-opacity-10 rounded-3 p-3">

                        <i class="bi bi-gender-female fs-4 text-danger"></i>

                    </div>

                </div>

            </div>

        </div>

    </div>



    <!-- TOTAL KELAS -->

    <div class="col-lg-3">

        <div class="card border-0 shadow-sm rounded-4">

            <div class="card-body">

                <div class="d-flex justify-content-between">

                    <div>

                        <small class="text-secondary">

                            Total Kelas

                        </small>

                        <h2 class="fw-bold text-success mt-2">

                            <?= $kelas['total']; ?>

                        </h2>

                    </div>

                    <div class="bg-success bg-opacity-10 rounded-3 p-3">

                        <i class="bi bi-mortarboard-fill fs-4 text-success"></i>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>

<?php

// ==============================
// FILTER & SEARCH
// ==============================

$search = isset($_GET['search']) ? mysqli_real_escape_string($conn, $_GET['search']) : "";
$kelasFilter = isset($_GET['kelas']) ? mysqli_real_escape_string($conn, $_GET['kelas']) : "";

$where = "WHERE 1=1";

if($search != ""){

    $where .= " AND (
        nama_siswa LIKE '%$search%'
        OR nis LIKE '%$search%'
        OR email LIKE '%$search%'
    )";

}

if($kelasFilter != ""){

    $where .= " AND kelas='$kelasFilter'";

}


// ==============================
// QUERY DATA SISWA
// ==============================

$query = mysqli_query($conn, "

SELECT *

FROM siswa

$where

ORDER BY id_siswa DESC

");

?>



<!-- FILTER -->

<div class="card border-0 shadow-sm rounded-4 mb-4">

    <div class="card-body">

        <form method="GET">

            <div class="row g-3">

                <!-- SEARCH -->

                <div class="col-lg-6">

                    <div class="input-group">

                        <span class="input-group-text bg-light border-0">

                            <i class="bi bi-search"></i>

                        </span>

                        <input
                            type="text"
                            name="search"
                            class="form-control border-0 bg-light"
                            placeholder="Cari nama, NIS atau email..."
                            value="<?= htmlspecialchars($search); ?>">

                    </div>

                </div>



                <!-- FILTER KELAS -->

                <div class="col-lg-3">

                    <select
                        name="kelas"
                        class="form-select">

                        <option value="">

                            Semua Kelas

                        </option>

                        <?php

                        $kelasQuery = mysqli_query($conn, "

                        SELECT DISTINCT kelas

                        FROM siswa

                        ORDER BY kelas ASC

                        ");

                        while($k = mysqli_fetch_assoc($kelasQuery)){

                        ?>

                        <option
                            value="<?= $k['kelas']; ?>"
                            <?= ($kelasFilter == $k['kelas']) ? "selected" : ""; ?>>

                            <?= $k['kelas']; ?>

                        </option>

                        <?php

                        }

                        ?>

                    </select>

                </div>



                <!-- BUTTON -->

                <div class="col-lg-3">

                    <div class="d-flex gap-2">

                        <button
                            type="submit"
                            class="btn btn-primary flex-fill">

                            Filter

                        </button>

                        <a
                            href="siswa.php"
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

        <table class="table table-hover align-middle mb-0">

            <thead class="table-light">

                <tr>

                    <th width="60">No</th>

                    <th>Siswa</th>

                    <th>NIS</th>

                    <th>Kelas</th>

                    <th>Jenis Kelamin</th>

                    <th>Email</th>

                    <th>No. HP</th>

                    <th class="text-center">Aksi</th>

                </tr>

            </thead>

            <tbody>

<?php

$no = 1;

if(mysqli_num_rows($query) > 0){

?>

<?php

while($data = mysqli_fetch_assoc($query)){

?>

<tr>

    <!-- NO -->

    <td>

        <?= $no++; ?>

    </td>



    <!-- DATA SISWA -->

    <td>

        <div class="d-flex align-items-center">

            <?php

            $foto = "../assets/image/siswa/".$data['foto'];

            if(!empty($data['foto']) && file_exists($foto)){

            ?>

                <img

                    src="<?= $foto; ?>"

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

                    <?= htmlspecialchars($data['nama_siswa']); ?>

                </div>

                <small class="text-secondary">

                    ID : <?= $data['id_siswa']; ?>

                </small>

            </div>

        </div>

    </td>



    <!-- NIS -->

    <td>

        <?= htmlspecialchars($data['nis']); ?>

    </td>



    <!-- KELAS -->

    <td>

        <span class="badge bg-primary">

            <?= htmlspecialchars($data['kelas']); ?>

        </span>

    </td>



    <!-- JENIS KELAMIN -->

    <td>

        <?php

        if($data['jenis_kelamin']=="L"){

        ?>

            <span class="badge bg-info">

                Laki-laki

            </span>

        <?php

        }elseif($data['jenis_kelamin']=="P"){

        ?>

            <span class="badge bg-danger">

                Perempuan

            </span>

        <?php

        }else{

            echo $data['jenis_kelamin'];

        }

        ?>

    </td>



    <!-- EMAIL -->

    <td>

        <?= htmlspecialchars($data['email']); ?>

    </td>



    <!-- NO HP -->

    <td>

        <?= htmlspecialchars($data['no_hp']); ?>

    </td>



    <!-- AKSI -->

    <td class="text-center">

        <div class="d-flex justify-content-center gap-2">

            <a

                href="detail_siswa.php?id=<?= $data['id_siswa']; ?>"

                class="btn btn-sm btn-info text-white"

                title="Detail">

                <i class="bi bi-eye"></i>

            </a>



            <a

                href="edit_siswa.php?id=<?= $data['id_siswa']; ?>"

                class="btn btn-sm btn-warning text-white"

                title="Edit">

                <i class="bi bi-pencil-square"></i>

            </a>



            <a

                href="hapus_siswa.php?id=<?= $data['id_siswa']; ?>"

                class="btn btn-sm btn-danger"

                onclick="return confirm('Yakin ingin menghapus data siswa ini?')"

                title="Hapus">

                <i class="bi bi-trash"></i>

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

        <i class="bi bi-people fs-1 text-secondary"></i>

        <h5 class="fw-bold mt-3">

            Belum Ada Data Siswa

        </h5>

        <p class="text-secondary mb-0">

            Belum ada data siswa yang tersedia.

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

        <div class="d-flex justify-content-between align-items-center py-3">

            <small class="text-secondary">

                Menampilkan

                <strong>

                    <?= mysqli_num_rows($query); ?>

                </strong>

                data siswa

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