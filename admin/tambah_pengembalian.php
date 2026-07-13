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

            Tambah Pengembalian

        </h2>

        <p class="text-secondary mb-0">

            Tambahkan transaksi pengembalian buku.

        </p>

    </div>

    <a

        href="pengembalian.php"

        class="btn btn-outline-secondary">

        <i class="bi bi-arrow-left me-2"></i>

        Kembali

    </a>

</div>



<div class="card border-0 shadow-sm rounded-4">

<div class="card-body p-4">

<form

action="proses_tambah_pengembalian.php"

method="POST">

<div class="row">

<!-- TRANSAKSI PEMINJAMAN -->

<div class="col-md-12 mb-3">

<label class="form-label fw-semibold">

Pilih Transaksi Peminjaman

</label>

<select

name="id_pinjam"

class="form-select"

required>

<option value="">

-- Pilih Transaksi --

</option>

<?php

$query = mysqli_query($conn,"

SELECT

peminjaman.id_pinjam,

siswa.nama_siswa,

siswa.nis,

buku.judul,

peminjaman.batas_kembali

FROM peminjaman

INNER JOIN siswa
ON siswa.id_siswa=peminjaman.id_siswa

INNER JOIN buku
ON buku.id_buku=peminjaman.id_buku

WHERE peminjaman.status='Dipinjam'

ORDER BY peminjaman.id_pinjam DESC

");

while($row=mysqli_fetch_assoc($query)){

?>

<option value="<?= $row['id_pinjam']; ?>">

<?= $row['nama_siswa']; ?>

- <?= $row['judul']; ?>

(NIS <?= $row['nis']; ?>)

</option>

<?php

}

?>

</select>

</div>

<!-- ===========================
TANGGAL KEMBALI
=========================== -->

<div class="col-md-12 mb-4">

    <label class="form-label fw-semibold">

        Tanggal Kembali

    </label>

    <input

        type="date"

        name="tanggal_kembali"

        class="form-control"

        value="<?= date('Y-m-d'); ?>"

        required>

    <small class="text-secondary">

        Status pengembalian, keterlambatan, dan denda akan dihitung otomatis oleh sistem.

    </small>

</div>

</div>

<hr>

<div class="d-flex justify-content-end gap-2">

    <a

        href="pengembalian.php"

        class="btn btn-outline-secondary px-4">

        <i class="bi bi-arrow-left me-2"></i>

        Batal

    </a>

    <button

        type="submit"

        class="btn btn-primary px-4">

        <i class="bi bi-floppy me-2"></i>

        Simpan Pengembalian

    </button>

</div>

</form>

</div>

</div>

</div>

<?php include "../includes/footer.php"; ?>