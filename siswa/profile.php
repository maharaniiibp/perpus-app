<?php

session_start();

if (!isset($_SESSION['role']) || $_SESSION['role'] != "siswa") {

    header("Location: ../auth/login.php");
    exit;

}

include "../config/koneksi.php";

$idSiswa = $_SESSION['id'];

$query = mysqli_query($conn, "

SELECT *

FROM siswa

WHERE id_siswa='$idSiswa'

");

if(mysqli_num_rows($query)==0){

    echo "<script>

    alert('Data siswa tidak ditemukan.');

    window.location='dashboard.php';

    </script>";

    exit;

}

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
<!-- ===================================== -->
<!-- HEADER -->
<!-- ===================================== -->

<div class="mb-4">

    <h2 class="fw-bold">

        Profil Saya

    </h2>

    <p class="text-secondary">

        Informasi lengkap akun siswa.

    </p>

</div>

<div class="row">

    <!-- ========================= -->
    <!-- FOTO PROFILE -->
    <!-- ========================= -->

    <div class="col-lg-4">

        <div class="card border-0 shadow-sm rounded-4">

            <div class="card-body text-center">

                <?php

                if(!empty($data['foto'])){

                ?>

                <img

                src="../assets/image/siswa/<?= $data['foto']; ?>"

                class="rounded-circle shadow mb-3"

                style="width:160px;height:160px;object-fit:cover;">

                <?php

                }else{

                ?>

                <img

                src="../assets/image/default-user.png"

                class="rounded-circle shadow mb-3"

                style="width:160px;height:160px;object-fit:cover;">

                <?php

                }

                ?>

                <h4 class="fw-bold">

                    <?= $data['nama_siswa']; ?>

                </h4>

                <p class="text-secondary mb-2">

                    <?= $data['kelas']; ?>

                </p>

                <span class="badge bg-primary px-3 py-2">

                    Siswa

                </span>

            </div>

        </div>

    </div>



    <!-- ========================= -->
    <!-- INFORMASI SISWA -->
    <!-- ========================= -->

    <div class="col-lg-8">

        <div class="card border-0 shadow-sm rounded-4">

            <div class="card-body">

                <h5 class="fw-bold mb-4">

                    Informasi Pribadi

                </h5>

                <div class="row">

                    <div class="col-md-6 mb-3">

                        <label class="text-secondary">

                            Nama Lengkap

                        </label>

                        <input
                        type="text"
                        class="form-control"
                        value="<?= $data['nama_siswa']; ?>"
                        readonly>

                    </div>

                    <div class="col-md-6 mb-3">

                        <label class="text-secondary">

                            NIS

                        </label>

                        <input
                        type="text"
                        class="form-control"
                        value="<?= $data['nis']; ?>"
                        readonly>

                    </div>

                    <div class="col-md-6 mb-3">

                        <label class="text-secondary">

                            Kelas

                        </label>

                        <input
                        type="text"
                        class="form-control"
                        value="<?= $data['kelas']; ?>"
                        readonly>

                    </div>

                    <div class="col-md-6 mb-3">

                        <label class="text-secondary">

                            Jenis Kelamin

                        </label>

                        <input
                        type="text"
                        class="form-control"
                        value="<?= $data['jenis_kelamin']; ?>"
                        readonly>

                    </div>

                    <div class="col-md-6 mb-3">

                        <label class="text-secondary">

                            Email

                        </label>

                        <input
                        type="email"
                        class="form-control"
                        value="<?= $data['email']; ?>"
                        readonly>

                    </div>

                    <div class="col-md-6 mb-3">

                        <label class="text-secondary">

                            No. HP

                        </label>

                        <input
                        type="text"
                        class="form-control"
                        value="<?= $data['no_hp']; ?>"
                        readonly>

                    </div>

                    <div class="col-12 mb-3">

                        <label class="text-secondary">

                            Alamat

                        </label>

                        <textarea
                        class="form-control"
                        rows="3"
                        readonly><?= $data['alamat']; ?></textarea>

                    </div>
                                        <div class="col-md-6 mb-3">

                        <label class="text-secondary">

                            Password

                        </label>

                        <input
                        type="password"
                        class="form-control"
                        value="********"
                        readonly>

                    </div>

                    <div class="col-md-6 mb-3">

                        <label class="text-secondary">

                            Tanggal Bergabung

                        </label>

                        <input
                        type="text"
                        class="form-control"
                        value="<?= date('d F Y', strtotime($data['created_at'])); ?>"
                        readonly>

                    </div>

                </div>

                <hr>

                <div class="d-flex justify-content-end gap-2">

                    <a
                    href="edit_profile.php"
                    class="btn btn-primary">

                        <i class="bi bi-pencil-square me-2"></i>

                        Edit Profil

                    </a>

                </div>

            </div>

        </div>

    </div>

</div>

</div>

<?php include "../includes/footer.php"; ?>