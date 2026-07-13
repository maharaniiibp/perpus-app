<?php

session_start();

if(!isset($_SESSION['role'])){

    header("Location: ../auth/login.php");
    exit;

}

include "../config/koneksi.php";


// ==========================
// FILTER
// ==========================

$kategori = isset($_GET['kategori']) ? $_GET['kategori'] : "";

$status = isset($_GET['status']) ? $_GET['status'] : "";


// ==========================
// QUERY
// ==========================

$sql = "

SELECT

buku.*,

kategori.nama_kategori

FROM buku

LEFT JOIN kategori

ON kategori.id_kategori=buku.id_kategori

WHERE 1=1

";


if($kategori!=""){

$sql .= " AND buku.id_kategori='$kategori' ";

}


if($status=="tersedia"){

$sql .= " AND buku.stok>0 ";

}

if($status=="dipinjam"){

$sql .= " AND buku.stok=0 ";

}


$sql .= " ORDER BY buku.judul ASC ";

$query = mysqli_query($conn,$sql);

$total = mysqli_num_rows($query);


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



<!-- HEADER -->

<div class="d-flex justify-content-between align-items-center mb-4">

<div>

<h2 class="fw-bold">

<i class="bi bi-book-half text-primary me-2"></i>

Katalog Buku

</h2>

<p class="text-secondary">

Temukan koleksi buku yang tersedia di perpustakaan sekolah.

</p>

</div>

<div class="badge bg-success fs-6 p-3">

<?= $total; ?>

 Buku Tersedia

</div>

</div>



<!-- FILTER -->

<div class="card border-0 shadow-sm rounded-4 mb-4">

<div class="card-body">

<form method="GET">

<div class="row">

<div class="col-lg-4">

<select
name="kategori"
class="form-select">

<option value="">

Semua Kategori

</option>

<?php

$listKategori=mysqli_query($conn,"
SELECT *
FROM kategori
ORDER BY nama_kategori
");

while($k=mysqli_fetch_assoc($listKategori)){

?>

<option

value="<?= $k['id_kategori']; ?>"

<?= ($kategori==$k['id_kategori']) ? "selected" : ""; ?>>

<?= $k['nama_kategori']; ?>

</option>

<?php

}

?>

</select>

</div>



<div class="col-lg-4">

<select
name="status"
class="form-select">

<option value="">

Semua Status

</option>

<option value="tersedia">

Tersedia

</option>

<option value="dipinjam">

Dipinjam

</option>

</select>

</div>



<div class="col-lg-4">

<button
class="btn btn-primary w-100">

Filter

</button>

</div>

</div>

</form>

</div>

</div>

<!-- LIST BUKU -->

<style>

.book-grid{

display:grid;

grid-template-columns:repeat(5,1fr);

gap:20px;

}

.book-card{

background:#fff;

border-radius:18px;

overflow:hidden;

box-shadow:0 5px 18px rgba(0,0,0,.08);

transition:.3s;

}

.book-card:hover{

transform:translateY(-8px);

box-shadow:0 15px 30px rgba(0,0,0,.15);

}

.book-cover{

height:260px;

width:100%;

object-fit:cover;

}

.badge-status{

position:absolute;

top:10px;

right:10px;

font-size:11px;

padding:6px 10px;

border-radius:20px;

}

.book-body{

padding:15px;

}

.book-title{

font-weight:700;

font-size:15px;

margin-bottom:4px;

line-height:1.4;

height:42px;

overflow:hidden;

}

.book-author{

font-size:13px;

color:#777;

margin-bottom:10px;

height:20px;

overflow:hidden;

}

@media(max-width:1200px){

.book-grid{

grid-template-columns:repeat(4,1fr);

}

}

@media(max-width:992px){

.book-grid{

grid-template-columns:repeat(3,1fr);

}

}

@media(max-width:768px){

.book-grid{

grid-template-columns:repeat(2,1fr);

}

}

@media(max-width:576px){

.book-grid{

grid-template-columns:1fr;

}

}

</style>



<div class="book-grid">

<?php

if(mysqli_num_rows($query)>0){

while($b=mysqli_fetch_assoc($query)){

?>



<div class="book-card">

<div class="position-relative">

<img

src="../assets/image/buku/<?= $b['cover']; ?>"

class="book-cover">



<?php

if($b['stok']>0){

?>

<span class="badge bg-success badge-status">

TERSEDIA

</span>

<?php

}else{

?>

<span class="badge bg-danger badge-status">

DIPINJAM

</span>

<?php

}

?>



</div>



<div class="book-body">

<small class="text-primary fw-semibold">

<?= strtoupper($b['nama_kategori']); ?>

</small>



<div class="book-title">

<?= $b['judul']; ?>

</div>



<div class="book-author">

<?= $b['penulis']; ?>

</div>



<a

href="detail_buku.php?id=<?= $b['id_buku']; ?>"

class="btn btn-primary w-100 rounded-3">

Lihat Detail

<i class="bi bi-arrow-right ms-1"></i>

</a>

</div>

</div>



<?php

}

}else{

?>

<div class="alert alert-warning">

Belum ada buku.

</div>

<?php

}

?>

</div>

<!-- FOOTER -->

<div class="d-flex justify-content-between align-items-center mt-4">

    <div>

        <small class="text-secondary">

            Menampilkan

            <strong>

                <?= $total; ?>

            </strong>

            Buku

        </small>

    </div>

    <div>

        <button

        class="btn btn-outline-primary btn-sm"

        onclick="window.scrollTo({

            top:0,

            behavior:'smooth'

        })">

            <i class="bi bi-arrow-up"></i>

            Kembali ke Atas

        </button>

    </div>

</div>

</div>



<?php include "../includes/footer.php"; ?>