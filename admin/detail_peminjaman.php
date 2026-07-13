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

peminjaman.*,

siswa.nama_siswa,
siswa.nis,
siswa.kelas,
siswa.foto,

buku.judul,
buku.penulis,
buku.cover,

admin.nama_admin

FROM peminjaman

INNER JOIN siswa
ON siswa.id_siswa=peminjaman.id_siswa

INNER JOIN buku
ON buku.id_buku=peminjaman.id_buku

INNER JOIN admin
ON admin.id_admin=peminjaman.id_admin

WHERE peminjaman.id_pinjam='$id'

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

Detail Peminjaman

</h2>

<p class="text-secondary">

Informasi lengkap transaksi peminjaman.

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

<div class="card-body">

<div class="row">

<!-- COVER -->

<div class="col-lg-3 text-center">

<?php

if(!empty($data['cover']) && file_exists("../assets/image/buku/".$data['cover'])){

?>

<img

src="../assets/image/buku/<?= $data['cover']; ?>"

class="img-fluid rounded shadow"

style="max-height:300px;object-fit:cover;">

<?php

}else{

?>

<img

src="../assets/image/no-book.png"

class="img-fluid rounded shadow"

style="max-height:300px;">

<?php

}

?>

</div>



<div class="col-lg-9">

<h3 class="fw-bold mb-4">

    <?= $data['judul']; ?>

</h3>

<div class="row">

    <!-- NAMA SISWA -->

    <div class="col-md-6 mb-3">

        <label class="text-secondary">

            Nama Siswa

        </label>

        <div class="fw-semibold">

            <?= $data['nama_siswa']; ?>

        </div>

    </div>



    <!-- NIS -->

    <div class="col-md-6 mb-3">

        <label class="text-secondary">

            NIS

        </label>

        <div class="fw-semibold">

            <?= $data['nis']; ?>

        </div>

    </div>



    <!-- KELAS -->

    <div class="col-md-6 mb-3">

        <label class="text-secondary">

            Kelas

        </label>

        <div class="fw-semibold">

            <?= $data['kelas']; ?>

        </div>

    </div>



    <!-- PENULIS -->

    <div class="col-md-6 mb-3">

        <label class="text-secondary">

            Penulis

        </label>

        <div class="fw-semibold">

            <?= $data['penulis']; ?>

        </div>

    </div>



    <!-- ADMIN -->

    <div class="col-md-6 mb-3">

        <label class="text-secondary">

            Admin

        </label>

        <div class="fw-semibold">

            <?= $data['nama_admin']; ?>

        </div>

    </div>



    <!-- TANGGAL PINJAM -->

    <div class="col-md-6 mb-3">

        <label class="text-secondary">

            Tanggal Pinjam

        </label>

        <div class="fw-semibold">

            <?= date('d F Y', strtotime($data['tanggal_pinjam'])); ?>

        </div>

    </div>



    <!-- BATAS KEMBALI -->

    <div class="col-md-6 mb-3">

        <label class="text-secondary">

            Batas Kembali

        </label>

        <div class="fw-semibold">

            <?= date('d F Y', strtotime($data['batas_kembali'])); ?>

        </div>

    </div>



    <!-- STATUS -->

    <div class="col-md-6 mb-3">

        <label class="text-secondary">

            Status

        </label>

        <div>

<?php

if($data['status']=="Dipinjam"){

    if(strtotime($data['batas_kembali']) < strtotime(date("Y-m-d"))){

?>

<span class="badge bg-danger">

    Terlambat

</span>

<?php

    }else{

?>

<span class="badge bg-success">

    Sedang Dipinjam

</span>

<?php

    }

}else{

?>

<span class="badge bg-primary">

    Dikembalikan

</span>

<?php

}

?>

        </div>

    </div>

</div>

<hr>

<div class="d-flex justify-content-end gap-2">

    <a

        href="peminjaman.php"

        class="btn btn-outline-secondary">

        <i class="bi bi-arrow-left me-2"></i>

        Kembali

    </a>

    <a

        href="edit_peminjaman.php?id=<?= $data['id_pinjam']; ?>"

        class="btn btn-warning">

        <i class="bi bi-pencil-square me-2"></i>

        Edit

    </a>

</div>

</div>

</div>

</div>

<?php include "../includes/footer.php"; ?>