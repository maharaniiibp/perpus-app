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

        <h2 class="fw-bold">

            Tambah Siswa

        </h2>

        <p class="text-secondary">

            Tambahkan data siswa baru ke sistem.

        </p>

    </div>

    <a

        href="siswa.php"

        class="btn btn-outline-secondary">

        <i class="bi bi-arrow-left me-2"></i>

        Kembali

    </a>

</div>



<div class="card border-0 shadow-sm rounded-4">

<div class="card-body">

<form

action="proses_tambah_siswa.php"

method="POST"

enctype="multipart/form-data">

<div class="row">

<!-- NIS -->

<div class="col-md-6 mb-3">

<label class="form-label fw-semibold">

NIS

</label>

<input

type="text"

name="nis"

class="form-control"

required>

</div>



<!-- NAMA -->

<div class="col-md-6 mb-3">

<label class="form-label fw-semibold">

Nama Siswa

</label>

<input

type="text"

name="nama_siswa"

class="form-control"

required>

</div>



<!-- KELAS -->

<div class="col-md-6 mb-3">

<label class="form-label fw-semibold">

Kelas

</label>

<input

type="text"

name="kelas"

class="form-control"

required>

</div>



<!-- JENIS KELAMIN -->

<div class="col-md-6 mb-3">

<label class="form-label fw-semibold">

Jenis Kelamin

</label>

<select

name="jenis_kelamin"

class="form-select"

required>

<option value="">

-- Pilih Jenis Kelamin --

</option>

<option value="L">

Laki-laki

</option>

<option value="P">

Perempuan

</option>

</select>

</div>

<!-- EMAIL -->

<div class="col-md-6 mb-3">

    <label class="form-label fw-semibold">

        Email

    </label>

    <input

        type="email"

        name="email"

        class="form-control"

        required>

</div>



<!-- NO HP -->

<div class="col-md-6 mb-3">

    <label class="form-label fw-semibold">

        No. HP

    </label>

    <input

        type="text"

        name="no_hp"

        class="form-control"

        required>

</div>



<!-- ALAMAT -->

<div class="col-md-12 mb-3">

    <label class="form-label fw-semibold">

        Alamat

    </label>

    <textarea

        name="alamat"

        class="form-control"

        rows="3"

        required></textarea>

</div>



<!-- PASSWORD -->

<div class="col-md-6 mb-3">

    <label class="form-label fw-semibold">

        Password

    </label>

    <input

        type="password"

        name="password"

        class="form-control"

        required>

</div>



<!-- FOTO -->

<div class="col-md-6 mb-4">

    <label class="form-label fw-semibold">

        Foto Siswa

    </label>

    <input

        type="file"

        name="foto"

        class="form-control"

        accept=".jpg,.jpeg,.png">

    <small class="text-secondary">

        Format: JPG, JPEG, PNG

    </small>

</div>

</div>

<hr>

<div class="d-flex justify-content-end gap-2">

    <a

        href="siswa.php"

        class="btn btn-outline-secondary px-4">

        <i class="bi bi-arrow-left me-2"></i>

        Batal

    </a>

    <button

        type="submit"

        class="btn btn-primary px-4">

        <i class="bi bi-floppy me-2"></i>

        Simpan Siswa

    </button>

</div>

</form>

</div>

</div>

</div>

<?php include "../includes/footer.php"; ?>