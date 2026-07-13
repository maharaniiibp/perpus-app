<?php

$id = $_SESSION['id'];

$dataNavbar = mysqli_fetch_assoc(mysqli_query($conn,"
SELECT *
FROM siswa
WHERE id_siswa='$id'
"));

?>

<div class="card border-0 shadow-sm rounded-4 mb-4">

<div class="card-body">

<div class="d-flex justify-content-between align-items-center">

<!-- SEARCH -->

<div style="width:55%;">

<div class="input-group">

<span class="input-group-text bg-white border-0">

<i class="bi bi-search"></i>

</span>

<input

type="text"

class="form-control border-0"

placeholder="Cari judul buku...">

</div>

</div>



<!-- PROFILE -->

<div class="d-flex align-items-center">

<i class="bi bi-bell fs-5 me-4"></i>

<div class="text-end me-3">

<div class="fw-bold">

<?= $dataNavbar['nama_siswa']; ?>

</div>

<small class="text-secondary">

<?= $dataNavbar['kelas']; ?>

</small>

</div>

<img

src="../assets/image/siswa/<?= $dataNavbar['foto']; ?>"

width="50"

height="50"

class="rounded-circle border">

</div>

</div>

</div>

</div>