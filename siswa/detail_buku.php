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

buku.*,

kategori.nama_kategori

FROM buku

LEFT JOIN kategori

ON kategori.id_kategori=buku.id_kategori

WHERE id_buku='$id'

");

$data = mysqli_fetch_assoc($query);

include "../includes/header.php";
include "../includes/sidebar_siswa.php";

?>

<div
class="container-fluid"
style="
margin-left:250px;
padding:25px;
background:#F5F7FB;
min-height:100vh;
">

<?php include "../includes/navbar_siswa.php"; ?>



<div class="d-flex justify-content-between align-items-center mb-4">

<div>

<h2 class="fw-bold">

Detail Buku

</h2>

<p class="text-secondary">

Informasi lengkap mengenai buku.

</p>

</div>

<a

href="katalog.php"

class="btn btn-outline-secondary">

<i class="bi bi-arrow-left me-2"></i>

Kembali

</a>

</div>



<div class="card border-0 shadow rounded-4">

<div class="card-body">

<div class="row">

<!-- COVER -->

<div class="col-lg-4 text-center">

<img

src="../assets/image/buku/<?= $data['cover']; ?>"

class="img-fluid rounded shadow"

style="max-height:500px;object-fit:cover;">

</div>



<!-- DETAIL -->

<div class="col-lg-8">
    <h2 class="fw-bold mb-3">

<?= $data['judul']; ?>

</h2>

<div class="row">

    <div class="col-md-6 mb-3">

        <label class="text-secondary">

            Penulis

        </label>

        <div class="fw-semibold">

            <?= $data['penulis']; ?>

        </div>

    </div>



    <div class="col-md-6 mb-3">

        <label class="text-secondary">

            Penerbit

        </label>

        <div class="fw-semibold">

            <?= $data['penerbit']; ?>

        </div>

    </div>



    <div class="col-md-6 mb-3">

        <label class="text-secondary">

            Tahun Terbit

        </label>

        <div class="fw-semibold">

            <?= $data['tahun_terbit']; ?>

        </div>

    </div>



    <div class="col-md-6 mb-3">

        <label class="text-secondary">

            Kategori

        </label>

        <div class="fw-semibold">

            <span class="badge bg-primary">

                <?= $data['nama_kategori']; ?>

            </span>

        </div>

    </div>



    <div class="col-md-6 mb-3">

        <label class="text-secondary">

            ISBN

        </label>

        <div class="fw-semibold">

            <?= $data['isbn']; ?>

        </div>

    </div>



    <div class="col-md-6 mb-3">

        <label class="text-secondary">

            Stok Buku

        </label>

        <div class="fw-semibold">

            <?php

            if($data['stok']>0){

            ?>

            <span class="badge bg-success">

                <?= $data['stok']; ?> Buku Tersedia

            </span>

            <?php

            }else{

            ?>

            <span class="badge bg-danger">

                Sedang Dipinjam

            </span>

            <?php

            }

            ?>

        </div>

    </div>



    <div class="col-12 mt-3">

        <label class="text-secondary">

            Deskripsi

        </label>

        <div class="border rounded-3 p-3 bg-light">

            <?= nl2br($data['deskripsi']); ?>

        </div>

    </div>

</div>

<hr class="my-4">

<div class="d-flex gap-2">

<?php

if($data['stok']>0){

?>

<a

href="pinjam_buku.php?id=<?= $data['id_buku']; ?>"

class="btn btn-primary px-4">

<i class="bi bi-journal-bookmark-fill me-2"></i>

Pinjam Buku

</a>

<?php

}else{

?>

<button

class="btn btn-danger px-4"

disabled>

<i class="bi bi-x-circle me-2"></i>

Stok Habis

</button>

<?php

}

?>

<a

href="katalog.php"

class="btn btn-outline-secondary px-4">

Kembali

</a>

</div>

</div>

</div>

</div>

</div>

<?php include "../includes/footer.php"; ?>