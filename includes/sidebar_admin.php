<?php

$current = basename($_SERVER['PHP_SELF']);

?>

<!-- SIDEBAR -->

<div
class="d-flex flex-column text-white position-fixed shadow"
style="
width:250px;
height:100vh;
background:#111827;
left:0;
top:0;
z-index:1050;
">

    <!-- Logo -->

    <div class="px-4 py-4 border-bottom border-secondary border-opacity-25">

        <div class="d-flex align-items-center">

            <img
                src="../assets/image/logo-sidebar.png"
                alt="Logo"
                width="42"
                height="42"
                class="me-3">

            <div>

                <h5 class="fw-bold mb-0">

                    Admin Portal

                </h5>

                <small class="text-secondary">

                    LIBRARY SYSTEM

                </small>

            </div>

        </div>

    </div>

<!-- Menu -->

<div class="px-3 mt-4">

    <!-- Dashboard -->

    <a
        href="dashboard.php"
        class="btn w-100 text-start mb-3 <?= ($current=="dashboard.php") ? "btn-primary" : "btn-dark"; ?>"
        style="border-radius:14px;padding:13px;">

        <i class="bi bi-grid me-2"></i>

        Dashboard

    </a>



    <!-- Buku -->

    <a
        href="buku.php"
        class="btn w-100 text-start mb-3 <?= ($current=="buku.php" || $current=="tambah_buku.php" || $current=="edit_buku.php" || $current=="detail_buku.php") ? "btn-primary" : "btn-dark"; ?>"
        style="border-radius:14px;padding:13px;">

        <i class="bi bi-book me-2"></i>

        Data Buku

    </a>



    <!-- Siswa -->

    <a
        href="siswa.php"
        class="btn w-100 text-start mb-3 <?= ($current=="siswa.php" || $current=="tambah_siswa.php" || $current=="edit_siswa.php" || $current=="detail_siswa.php") ? "btn-primary" : "btn-dark"; ?>"
        style="border-radius:14px;padding:13px;">

        <i class="bi bi-people me-2"></i>

        Data Siswa

    </a>



    <!-- Peminjaman -->

    <a
        href="peminjaman.php"
        class="btn w-100 text-start mb-3 <?= ($current=="peminjaman.php" || $current=="tambah_peminjaman.php" || $current=="edit_peminjaman.php" || $current=="detail_peminjaman.php") ? "btn-primary" : "btn-dark"; ?>"
        style="border-radius:14px;padding:13px;">

        <i class="bi bi-arrow-left-right me-2"></i>

        Data Peminjaman

    </a>



    <!-- Pengembalian -->

    <a
        href="pengembalian.php"
        class="btn w-100 text-start mb-3 <?= ($current=="pengembalian.php" || $current=="tambah_pengembalian.php" || $current=="edit_pengembalian.php" || $current=="detail_pengembalian.php") ? "btn-primary" : "btn-dark"; ?>"
        style="border-radius:14px;padding:13px;">

        <i class="bi bi-journal-check me-2"></i>

        Data Pengembalian

    </a>



    <!-- Laporan -->

    <a
        href="laporan.php"
        class="btn w-100 text-start mb-3 <?= ($current=="laporan.php") ? "btn-primary" : "btn-dark"; ?>"
        style="border-radius:14px;padding:13px;">

        <i class="bi bi-bar-chart me-2"></i>

        Laporan

    </a>

</div>

    <!-- Logout -->

    <div class="mt-auto p-3">

        <hr class="border-secondary">

        <button
            class="btn btn-outline-danger w-100 rounded-3"
            data-bs-toggle="modal"
            data-bs-target="#logoutModal">

            <i class="bi bi-box-arrow-left me-2"></i>

            Logout

        </button>

    </div>

</div>



<!-- MODAL LOGOUT -->

<div
class="modal fade"
id="logoutModal"
tabindex="-1">

<div class="modal-dialog modal-dialog-centered">

<div class="modal-content border-0 rounded-4">

<div class="modal-body text-center p-5">

<i
class="bi bi-box-arrow-right text-danger"
style="font-size:60px;"></i>

<h4 class="fw-bold mt-3">

Logout

</h4>

<p class="text-secondary">

Apakah kamu yakin ingin keluar dari sistem?

</p>

<div class="mt-4">

<button
class="btn btn-secondary px-4"
data-bs-dismiss="modal">

Batal

</button>

<a
href="../auth/logout.php"
class="btn btn-danger px-4">

Ya, Logout

</a>

</div>

</div>

</div>

</div>

</div>