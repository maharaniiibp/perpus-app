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
FROM buku
WHERE id_buku='$id'
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

            Edit Buku

        </h2>

        <p class="text-secondary mb-0">

            Perbarui informasi buku perpustakaan

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

<div class="card-body p-4">

<form

action="proses_edit_buku.php"

method="POST"

enctype="multipart/form-data">

<input
type="hidden"
name="id_buku"
value="<?= $data['id_buku']; ?>">

<div class="row">

<!-- ISBN -->

<div class="col-md-6 mb-3">

<label class="form-label fw-semibold">

ISBN

</label>

<input

type="text"

name="isbn"

class="form-control"

value="<?= $data['isbn']; ?>"

required>

</div>



<!-- JUDUL -->

<div class="col-md-6 mb-3">

<label class="form-label fw-semibold">

Judul Buku

</label>

<input

type="text"

name="judul"

class="form-control"

value="<?= $data['judul']; ?>"

required>

</div>



<!-- PENULIS -->

<div class="col-md-6 mb-3">

<label class="form-label fw-semibold">

Penulis

</label>

<input

type="text"

name="penulis"

class="form-control"

value="<?= $data['penulis']; ?>"

required>

</div>



<!-- PENERBIT -->

<div class="col-md-6 mb-3">

<label class="form-label fw-semibold">

Penerbit

</label>

<input

type="text"

name="penerbit"

class="form-control"

value="<?= $data['penerbit']; ?>"

required>

</div>

<!-- ===========================
KATEGORI
=========================== -->

<div class="col-md-6 mb-3">

    <label class="form-label fw-semibold">

        Kategori

    </label>

    <select
        name="id_kategori"
        class="form-select"
        required>

        <?php

        $kategori = mysqli_query($conn,"
        SELECT *
        FROM kategori
        ORDER BY nama_kategori ASC
        ");

        while($k=mysqli_fetch_assoc($kategori)){

        ?>

        <option

            value="<?= $k['id_kategori']; ?>"

            <?= ($data['id_kategori']==$k['id_kategori']) ? "selected" : ""; ?>>

            <?= $k['nama_kategori']; ?>

        </option>

        <?php

        }

        ?>

    </select>

</div>



<!-- ===========================
LOKASI
=========================== -->

<div class="col-md-6 mb-3">

    <label class="form-label fw-semibold">

        Lokasi Rak

    </label>

    <select
        name="id_lokasi"
        class="form-select"
        required>

        <?php

        $lokasi = mysqli_query($conn,"
        SELECT *
        FROM lokasi
        ORDER BY nama_lokasi ASC
        ");

        while($l=mysqli_fetch_assoc($lokasi)){

        ?>

        <option

            value="<?= $l['id_lokasi']; ?>"

            <?= ($data['id_lokasi']==$l['id_lokasi']) ? "selected" : ""; ?>>

            <?= $l['nama_lokasi']; ?>

        </option>

        <?php

        }

        ?>

    </select>

</div>



<!-- ===========================
TAHUN TERBIT
=========================== -->

<div class="col-md-6 mb-3">

    <label class="form-label fw-semibold">

        Tahun Terbit

    </label>

    <input

        type="number"

        name="tahun_terbit"

        class="form-control"

        value="<?= $data['tahun_terbit']; ?>"

        required>

</div>



<!-- ===========================
STOK
=========================== -->

<div class="col-md-6 mb-3">

    <label class="form-label fw-semibold">

        Stok

    </label>

    <input

        type="number"

        name="stok"

        class="form-control"

        value="<?= $data['stok']; ?>"

        required>

</div>



<!-- ===========================
COVER LAMA
=========================== -->

<div class="col-md-12 mb-3">

    <label class="form-label fw-semibold">

        Cover Saat Ini

    </label>

    <br>

    <?php

    if(!empty($data['cover']) && file_exists("../assets/image/buku/".$data['cover'])){

    ?>

        <img

            src="../assets/image/buku/<?= $data['cover']; ?>"

            width="120"

            class="rounded shadow-sm mb-3">

    <?php

    }else{

    ?>

        <img

            src="../assets/image/no-book.png"

            width="120"

            class="rounded shadow-sm mb-3">

    <?php

    }

    ?>

</div>



<!-- ===========================
UPLOAD COVER BARU
=========================== -->

<div class="col-md-12 mb-3">

    <label class="form-label fw-semibold">

        Ganti Cover (Opsional)

    </label>

    <input

        type="file"

        name="cover"

        class="form-control"

        accept=".jpg,.jpeg,.png">

    <small class="text-secondary">

        Kosongkan jika tidak ingin mengganti cover.

    </small>

</div>
<!-- ===========================
DESKRIPSI
=========================== -->

<div class="col-md-12 mb-4">

    <label class="form-label fw-semibold">

        Deskripsi Buku

    </label>

    <textarea

        name="deskripsi"

        rows="5"

        class="form-control"

        placeholder="Masukkan deskripsi buku..."><?= $data['deskripsi']; ?></textarea>

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

        <i class="bi bi-x-circle me-2"></i>

        Batal

    </a>

    <button

        type="submit"

        class="btn btn-primary px-4">

        <i class="bi bi-check-circle me-2"></i>

        Update Buku

    </button>

</div>

</form>

</div>

</div>

</div>

<?php include "../includes/footer.php"; ?>