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
FROM siswa
WHERE id_siswa='$id'
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

            Edit Siswa

        </h2>

        <p class="text-secondary">

            Perbarui data siswa.

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

action="proses_edit_siswa.php"

method="POST"

enctype="multipart/form-data">

<input

type="hidden"

name="id_siswa"

value="<?= $data['id_siswa']; ?>">

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

value="<?= $data['nis']; ?>"

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

value="<?= $data['nama_siswa']; ?>"

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

value="<?= $data['kelas']; ?>"

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

<option value="L" <?= ($data['jenis_kelamin']=="L") ? "selected" : ""; ?>>

Laki-laki

</option>

<option value="P" <?= ($data['jenis_kelamin']=="P") ? "selected" : ""; ?>>

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

        value="<?= $data['email']; ?>"

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

        value="<?= $data['no_hp']; ?>"

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

        required><?= $data['alamat']; ?></textarea>

</div>



<!-- PASSWORD -->

<div class="col-md-6 mb-3">

    <label class="form-label fw-semibold">

        Password Baru

    </label>

    <input

        type="password"

        name="password"

        class="form-control">

    <small class="text-secondary">

        Kosongkan jika password tidak ingin diubah.

    </small>

</div>



<!-- FOTO -->

<div class="col-md-6 mb-3">

    <label class="form-label fw-semibold">

        Foto Baru

    </label>

    <input

        type="file"

        name="foto"

        class="form-control"

        accept=".jpg,.jpeg,.png">

    <small class="text-secondary">

        Kosongkan jika tidak ingin mengganti foto.

    </small>

</div>



<!-- PREVIEW FOTO -->

<div class="col-md-12 mb-4 text-center">

<?php

if(!empty($data['foto']) && file_exists("../assets/image/siswa/".$data['foto'])){

?>

<img

src="../assets/image/siswa/<?= $data['foto']; ?>"

width="150"

height="150"

class="rounded-circle shadow"

style="object-fit:cover;">

<?php

}else{

?>

<img

src="../assets/image/default-user.png"

width="150"

height="150"

class="rounded-circle shadow"

style="object-fit:cover;">

<?php

}

?>

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

        Update Siswa

    </button>

</div>

</form>

</div>

</div>

</div>

<?php include "../includes/footer.php"; ?>