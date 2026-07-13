<?php

session_start();

if(!isset($_SESSION['role'])){

    header("Location: ../auth/login.php");
    exit;

}

include "../config/koneksi.php";

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

            Tambah Peminjaman

        </h2>

        <p class="text-secondary mb-0">

            Tambahkan transaksi peminjaman buku baru.

        </p>

    </div>

    <a

        href="peminjaman.php"

        class="btn btn-outline-secondary">

        <i class="bi bi-arrow-left me-2"></i>

        Kembali

    </a>

</div>



<div class="card border-0 shadow-sm rounded-4">

<div class="card-body p-4">

<form

action="proses_tambah_peminjaman.php"

method="POST">

<div class="row">

<!-- SISWA -->

<div class="col-md-6 mb-3">

<label class="form-label fw-semibold">

Siswa

</label>

<select

name="id_siswa"

class="form-select"

required>

<option value="">

-- Pilih Siswa --

</option>

<?php

$siswa = mysqli_query($conn,"
SELECT *
FROM siswa
ORDER BY nama_siswa ASC
");

while($s=mysqli_fetch_assoc($siswa)){

?>

<option value="<?= $s['id_siswa']; ?>">

<?= $s['nama_siswa']; ?> - <?= $s['nis']; ?>

</option>

<?php

}

?>

</select>

</div>



<!-- BUKU -->

<div class="col-md-6 mb-3">

<label class="form-label fw-semibold">

Buku

</label>

<select

name="id_buku"

class="form-select"

required>

<option value="">

-- Pilih Buku --

</option>

<?php

$buku = mysqli_query($conn,"
SELECT *
FROM buku
WHERE stok > 0
ORDER BY judul ASC
");

while($b=mysqli_fetch_assoc($buku)){

?>

<option value="<?= $b['id_buku']; ?>">

<?= $b['judul']; ?>

(Stok <?= $b['stok']; ?>)

</option>

<?php

}

?>

</select>

</div>

<!-- ===========================
TANGGAL PINJAM
=========================== -->

<div class="col-md-6 mb-3">

    <label class="form-label fw-semibold">

        Tanggal Pinjam

    </label>

    <input

        type="date"

        name="tanggal_pinjam"

        class="form-control"

        value="<?= date('Y-m-d'); ?>"

        required>

</div>



<!-- ===========================
BATAS KEMBALI
=========================== -->

<div class="col-md-6 mb-3">

    <label class="form-label fw-semibold">

        Batas Kembali

    </label>

    <input

        type="date"

        name="batas_kembali"

        class="form-control"

        value="<?= date('Y-m-d', strtotime('+7 days')); ?>"

        required>

</div>



<!-- ===========================
STATUS
=========================== -->

<div class="col-md-6 mb-4">

    <label class="form-label fw-semibold">

        Status

    </label>

    <select

        name="status"

        class="form-select"

        required>

        <option value="Dipinjam" selected>

            Dipinjam

        </option>

        <option value="Dikembalikan">

            Dikembalikan

        </option>

    </select>

</div>



<!-- ===========================
ADMIN LOGIN
=========================== -->

<input

    type="hidden"

    name="id_admin"

    value="<?= $_SESSION['id']; ?>">



</div>



<!-- BUTTON -->

<hr>

<div class="d-flex justify-content-end gap-2">

    <a

        href="peminjaman.php"

        class="btn btn-outline-secondary px-4">

        <i class="bi bi-arrow-left me-2"></i>

        Batal

    </a>

    <button

        type="submit"

        class="btn btn-primary px-4">

        <i class="bi bi-floppy me-2"></i>

        Simpan Peminjaman

    </button>

</div>

</form>

</div>

</div>

</div>

<?php include "../includes/footer.php"; ?>