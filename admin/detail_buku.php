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

kategori.nama_kategori,

lokasi.nama_lokasi

FROM buku

LEFT JOIN kategori
ON kategori.id_kategori=buku.id_kategori

LEFT JOIN lokasi
ON lokasi.id_lokasi=buku.id_lokasi

WHERE buku.id_buku='$id'

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

Detail Buku

</h2>

<p class="text-secondary mb-0">

Informasi lengkap buku perpustakaan

</p>

</div>

<a

href="buku.php"

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

style="max-height:350px;object-fit:cover;">

<?php

}else{

?>

<img

src="../assets/image/no-book.png"

class="img-fluid rounded shadow"

style="max-height:350px;">

<?php

}

?>

</div>



<!-- DATA -->

<div class="col-lg-9">

<h3 class="fw-bold mb-4">

    <?= $data['judul']; ?>

</h3>

<div class="row">

    <!-- ISBN -->

    <div class="col-md-6 mb-3">

        <label class="text-secondary">

            ISBN

        </label>

        <div class="fw-semibold">

            <?= $data['isbn']; ?>

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

    <!-- PENERBIT -->

    <div class="col-md-6 mb-3">

        <label class="text-secondary">

            Penerbit

        </label>

        <div class="fw-semibold">

            <?= $data['penerbit']; ?>

        </div>

    </div>

    <!-- TAHUN -->

    <div class="col-md-6 mb-3">

        <label class="text-secondary">

            Tahun Terbit

        </label>

        <div class="fw-semibold">

            <?= $data['tahun_terbit']; ?>

        </div>

    </div>

    <!-- KATEGORI -->

    <div class="col-md-6 mb-3">

        <label class="text-secondary">

            Kategori

        </label>

        <div>

            <span class="badge bg-primary">

                <?= $data['nama_kategori']; ?>

            </span>

        </div>

    </div>

    <!-- LOKASI -->

    <div class="col-md-6 mb-3">

        <label class="text-secondary">

            Lokasi Rak

        </label>

        <div class="fw-semibold">

            <?= $data['nama_lokasi']; ?>

        </div>

    </div>

    <!-- STOK -->

    <div class="col-md-6 mb-3">

        <label class="text-secondary">

            Stok

        </label>

        <div>

            <?php

            if($data['stok']>10){

            ?>

                <span class="badge bg-success">

                    <?= $data['stok']; ?> Buku

                </span>

            <?php

            }elseif($data['stok']>0){

            ?>

                <span class="badge bg-warning text-dark">

                    <?= $data['stok']; ?> Buku

                </span>

            <?php

            }else{

            ?>

                <span class="badge bg-danger">

                    Stok Habis

                </span>

            <?php

            }

            ?>

        </div>

    </div>

    <!-- STATUS -->

    <div class="col-md-6 mb-3">

        <label class="text-secondary">

            Status

        </label>

        <div>

<?php

$cek = mysqli_query($conn,"
SELECT *
FROM peminjaman
WHERE id_buku='".$data['id_buku']."'
AND status='Dipinjam'
");

if(mysqli_num_rows($cek)>0){

?>

<span class="badge bg-primary">

Sedang Dipinjam

</span>

<?php

}else{

?>

<span class="badge bg-success">

Tersedia

</span>

<?php

}

?>

        </div>

    </div>

</div>

<hr>

<div class="mb-4">

    <label class="text-secondary">

        Deskripsi

    </label>

    <div class="mt-2">

        <?= nl2br($data['deskripsi']); ?>

    </div>

</div>

<!-- ===========================
BUTTON
=========================== -->

<hr>

<div class="d-flex justify-content-end gap-2">

    <a

        href="buku.php"

        class="btn btn-outline-secondary px-4">

        <i class="bi bi-arrow-left me-2"></i>

        Kembali

    </a>

    <a

        href="edit_buku.php?id=<?= $data['id_buku']; ?>"

        class="btn btn-warning px-4">

        <i class="bi bi-pencil-square me-2"></i>

        Edit Buku

    </a>

</div>

</div>

</div>

</div>

<?php include "../includes/footer.php"; ?>