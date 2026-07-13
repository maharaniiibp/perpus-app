<?php

session_start();

if(!isset($_SESSION['role']) || $_SESSION['role']!="siswa"){

    header("Location: ../auth/login.php");
    exit;

}

include "../config/koneksi.php";

$idSiswa = $_SESSION['id'];

$query = mysqli_query($conn,"
SELECT *
FROM siswa
WHERE id_siswa='$idSiswa'
");

if(mysqli_num_rows($query)==0){

    echo "<script>

    alert('Data siswa tidak ditemukan.');

    window.location='profile.php';

    </script>";

    exit;

}

$data=mysqli_fetch_assoc($query);

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

<!-- ===================================== -->
<!-- HEADER -->
<!-- ===================================== -->

<div class="mb-4">

    <h2 class="fw-bold">

        Edit Profil

    </h2>

    <p class="text-secondary">

        Perbarui informasi akun kamu.

    </p>

</div>


<form
action="proses_edit_profile.php"
method="POST"
enctype="multipart/form-data">

<input
type="hidden"
name="id_siswa"
value="<?= $data['id_siswa']; ?>">

<div class="row">

    <!-- FOTO -->

    <div class="col-lg-4">

        <div class="card border-0 shadow-sm rounded-4">

            <div class="card-body text-center">

                <?php

                if(!empty($data['foto'])){

                ?>

                <img

                src="../assets/image/siswa/<?= $data['foto']; ?>"

                class="rounded-circle shadow mb-3"

                style="width:170px;height:170px;object-fit:cover;">

                <?php

                }else{

                ?>

                <img

                src="../assets/image/default-user.png"

                class="rounded-circle shadow mb-3"

                style="width:170px;height:170px;object-fit:cover;">

                <?php

                }

                ?>

                <input
                type="file"
                name="foto"
                class="form-control mt-3">

                <small class="text-secondary">

                    Kosongkan jika tidak ingin mengganti foto.

                </small>

            </div>

        </div>

    </div>


    <!-- FORM -->

    <div class="col-lg-8">

        <div class="card border-0 shadow-sm rounded-4">

            <div class="card-body">

                <h5 class="fw-bold mb-4">

                    Informasi Pribadi

                </h5>

                <div class="row">

                    <div class="col-md-6 mb-3">

                        <label class="form-label">

                            Nama Lengkap

                        </label>

                        <input
                        type="text"
                        name="nama_siswa"
                        class="form-control"
                        value="<?= $data['nama_siswa']; ?>"
                        required>

                    </div>


                    <div class="col-md-6 mb-3">

                        <label class="form-label">

                            Email

                        </label>

                        <input
                        type="email"
                        name="email"
                        class="form-control"
                        value="<?= $data['email']; ?>">

                    </div>


                    <div class="col-md-6 mb-3">

                        <label class="form-label">

                            No HP

                        </label>

                        <input
                        type="text"
                        name="no_hp"
                        class="form-control"
                        value="<?= $data['no_hp']; ?>">

                    </div>


                    <div class="col-md-6 mb-3">

                        <label class="form-label">

                            Password Baru

                        </label>

                        <input
                        type="password"
                        name="password"
                        class="form-control"
                        placeholder="Kosongkan jika tidak diganti">

                    </div>


                    <div class="col-12 mb-3">

                        <label class="form-label">

                            Alamat

                        </label>

                        <textarea
                        name="alamat"
                        rows="4"
                        class="form-control"><?= $data['alamat']; ?></textarea>

                    </div>
                                        <div class="d-flex justify-content-end gap-2 mt-4">

                        <a
                        href="profile.php"
                        class="btn btn-outline-secondary">

                            <i class="bi bi-arrow-left me-2"></i>

                            Batal

                        </a>

                        <button
                        type="submit"
                        class="btn btn-primary">

                            <i class="bi bi-check-circle me-2"></i>

                            Simpan Perubahan

                        </button>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>

</form>

</div>

<?php include "../includes/footer.php"; ?>