<?php

session_start();

if(!isset($_SESSION['role'])){

    header("Location: ../auth/login.php");
    exit;

}

include "../config/koneksi.php";

$id = $_GET['id'];

$query = mysqli_query($conn,"

SELECT *

FROM peminjaman

WHERE id_pinjam='$id'

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



<!-- HEADER -->

<div class="d-flex justify-content-between align-items-center mb-4">

    <div>

        <h2 class="fw-bold mb-1">

            Edit Peminjaman

        </h2>

        <p class="text-secondary mb-0">

            Perbarui data transaksi peminjaman.

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

action="proses_edit_peminjaman.php"

method="POST">

<input

type="hidden"

name="id_pinjam"

value="<?= $data['id_pinjam']; ?>">

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

<?php

$siswa = mysqli_query($conn,"
SELECT *
FROM siswa
ORDER BY nama_siswa ASC
");

while($s=mysqli_fetch_assoc($siswa)){

?>

<option

value="<?= $s['id_siswa']; ?>"

<?= ($data['id_siswa']==$s['id_siswa']) ? "selected" : ""; ?>>

<?= $s['nama_siswa']; ?>

- <?= $s['nis']; ?>

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

<?php

$buku = mysqli_query($conn,"
SELECT *
FROM buku
ORDER BY judul ASC
");

while($b=mysqli_fetch_assoc($buku)){

?>

<option

value="<?= $b['id_buku']; ?>"

<?= ($data['id_buku']==$b['id_buku']) ? "selected" : ""; ?>>

<?= $b['judul']; ?>

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

        value="<?= $data['tanggal_pinjam']; ?>"

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

        value="<?= $data['batas_kembali']; ?>"

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

            value="Dipinjam"

            <?= ($data['status']=="Dipinjam") ? "selected" : ""; ?>>

            Dipinjam

        </option>

        <option

            value="Dikembalikan"

            <?= ($data['status']=="Dikembalikan") ? "selected" : ""; ?>>

            Dikembalikan

        </option>

    </select>

</div>



<!-- ===========================
ADMIN
=========================== -->

<input

type="hidden"

name="id_admin"

value="<?= $_SESSION['id']; ?>">

</div>



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

        Update Peminjaman

    </button>

</div>

</form>

</div>

</div>

</div>

<?php include "../includes/footer.php"; ?>