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



<!-- HEADER -->

<div class="d-flex justify-content-between align-items-center mb-4">

<div>

<h2 class="fw-bold">

Detail Siswa

</h2>

<p class="text-secondary">

Informasi lengkap data siswa.

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

<div class="row">

<!-- FOTO -->

<div class="col-lg-3 text-center">

<?php

if(!empty($data['foto']) && file_exists("../assets/image/siswa/".$data['foto'])){

?>

<img

src="../assets/image/siswa/<?= $data['foto']; ?>"

class="img-fluid rounded shadow"

style="max-height:300px;object-fit:cover;">

<?php

}else{

?>

<img

src="../assets/image/default-user.png"

class="img-fluid rounded shadow"

style="max-height:300px;">

<?php

}

?>

</div>

<div class="col-lg-9">

<h3 class="fw-bold mb-4">

    <?= $data['nama_siswa']; ?>

</h3>

<div class="row">

<div class="col-md-6 mb-3">

<label class="text-secondary">

NIS

</label>

<div class="fw-semibold">

<?= $data['nis']; ?>

</div>

</div>



<div class="col-md-6 mb-3">

<label class="text-secondary">

Kelas

</label>

<div class="fw-semibold">

<?= $data['kelas']; ?>

</div>

</div>



<div class="col-md-6 mb-3">

<label class="text-secondary">

Jenis Kelamin

</label>

<div class="fw-semibold">

<?php

echo ($data['jenis_kelamin']=="L") ? "Laki-laki" : "Perempuan";

?>

</div>

</div>



<div class="col-md-6 mb-3">

<label class="text-secondary">

Email

</label>

<div class="fw-semibold">

<?= $data['email']; ?>

</div>

</div>



<div class="col-md-6 mb-3">

<label class="text-secondary">

No. HP

</label>

<div class="fw-semibold">

<?= $data['no_hp']; ?>

</div>

</div>



<div class="col-md-12 mb-3">

<label class="text-secondary">

Alamat

</label>

<div class="fw-semibold">

<?= $data['alamat']; ?>

</div>

</div>

</div>

<hr>

<div class="d-flex justify-content-end gap-2">

<a

href="siswa.php"

class="btn btn-outline-secondary">

<i class="bi bi-arrow-left me-2"></i>

Kembali

</a>

<a

href="edit_siswa.php?id=<?= $data['id_siswa']; ?>"

class="btn btn-warning">

<i class="bi bi-pencil-square me-2"></i>

Edit

</a>

</div>

</div>

</div>

</div>

<?php include "../includes/footer.php"; ?>