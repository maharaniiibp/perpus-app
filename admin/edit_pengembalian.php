<?php

session_start();

if(!isset($_SESSION['role'])){

    header("Location: ../auth/login.php");
    exit;

}

include "../config/koneksi.php";

$id = $_GET['id'];

$query = mysqli_query($conn,"

SELECT

pengembalian.*,

peminjaman.id_pinjam,
peminjaman.tanggal_pinjam,
peminjaman.batas_kembali,

siswa.nama_siswa,
siswa.nis,

buku.judul

FROM pengembalian

INNER JOIN peminjaman
ON peminjaman.id_pinjam=pengembalian.id_pinjam

INNER JOIN siswa
ON siswa.id_siswa=peminjaman.id_siswa

INNER JOIN buku
ON buku.id_buku=peminjaman.id_buku

WHERE pengembalian.id_pengembalian='$id'

");

$data = mysqli_fetch_assoc($query);

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

<div class="d-flex justify-content-between align-items-center mb-4">

<div>

<h2 class="fw-bold">

Edit Pengembalian

</h2>

<p class="text-secondary">

Perbarui data pengembalian buku.

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

<div class="card-body">

<form

action="proses_edit_pengembalian.php"

method="POST">

<input

type="hidden"

name="id_pengembalian"

value="<?= $data['id_pengembalian']; ?>">

<div class="row">

<!-- Nama -->

<div class="col-md-6 mb-3">

<label class="form-label fw-semibold">

Nama Siswa

</label>

<input

type="text"

class="form-control"

value="<?= $data['nama_siswa']; ?>"

readonly>

</div>

<!-- Buku -->

<div class="col-md-6 mb-3">

<label class="form-label fw-semibold">

Judul Buku

</label>

<input

type="text"

class="form-control"

value="<?= $data['judul']; ?>"

readonly>

</div>

<!-- Tanggal Pinjam -->

<div class="col-md-6 mb-3">

<label class="form-label fw-semibold">

Tanggal Pinjam

</label>

<input

type="text"

class="form-control"

value="<?= date('d F Y',strtotime($data['tanggal_pinjam'])); ?>"

readonly>

</div>

<!-- Deadline -->

<div class="col-md-6 mb-3">

<label class="form-label fw-semibold">

Batas Kembali

</label>

<input

type="text"

class="form-control"

value="<?= date('d F Y',strtotime($data['batas_kembali'])); ?>"

readonly>

</div>

<!-- ===========================
TANGGAL KEMBALI
=========================== -->

<div class="col-md-6 mb-3">

    <label class="form-label fw-semibold">

        Tanggal Kembali

    </label>

    <input

        type="date"

        name="tanggal_kembali"

        class="form-control"

        value="<?= $data['tanggal_kembali']; ?>"

        required>

</div>



<!-- ===========================
TERLAMBAT
=========================== -->

<div class="col-md-6 mb-3">

    <label class="form-label fw-semibold">

        Terlambat

    </label>

    <select

        name="terlambat"

        class="form-select"

        required>

        <option

            value="Ya"

            <?= ($data['terlambat']=="Ya") ? "selected" : ""; ?>>

            Ya

        </option>

        <option

            value="Tidak"

            <?= ($data['terlambat']=="Tidak") ? "selected" : ""; ?>>

            Tidak

        </option>

    </select>

</div>



<!-- ===========================
DENDA
=========================== -->

<div class="col-md-6 mb-3">

    <label class="form-label fw-semibold">

        Denda (Rp)

    </label>

    <input

        type="number"

        name="denda"

        class="form-control"

        min="0"

        value="<?= $data['denda']; ?>"

        required>

</div>



<!-- ===========================
STATUS
=========================== -->

<div class="col-md-6 mb-3">

    <label class="form-label fw-semibold">

        Status

    </label>

    <select

        name="status"

        class="form-select"

        required>

        <option

            value="Selesai"

            <?= ($data['status']=="Selesai") ? "selected" : ""; ?>>

            Selesai

        </option>

        <option

            value="Terlambat"

            <?= ($data['status']=="Terlambat") ? "selected" : ""; ?>>

            Terlambat

        </option>

    </select>

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

        Update Pengembalian

    </button>

</div>

</form>

</div>

</div>

</div>

<?php include "../includes/footer.php"; ?>