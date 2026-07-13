<?php

$current = basename($_SERVER['PHP_SELF']);

?>

<div
class="d-flex flex-column text-white position-fixed shadow"
style="
width:250px;
height:100vh;
left:0;
top:0;
background:#111827;
z-index:1000;
">

    <!-- LOGO -->

    <div class="px-4 py-4 border-bottom border-secondary border-opacity-25">

        <div class="d-flex align-items-center">

            <img
            src="../assets/image/logo-sidebar.png"
            width="45"
            class="me-3">

            <div>

                <h5 class="fw-bold mb-0">

                    Student Portal

                </h5>

                <small class="text-secondary">

                    LIBRARY SYSTEM

                </small>

            </div>

        </div>

    </div>



    <!-- MENU -->

    <div class="px-3 mt-4">

        <a
        href="dashboard.php"
        class="btn w-100 text-start mb-3 <?= ($current=="dashboard.php") ? "btn-primary" : "btn-dark"; ?>">

            <i class="bi bi-grid me-2"></i>

            Dashboard

        </a>



        <a
        href="katalog.php"
        class="btn w-100 text-start mb-3 <?= ($current=="katalog.php") ? "btn-primary" : "btn-dark"; ?>">

            <i class="bi bi-book me-2"></i>

            Katalog Buku

        </a>



        <a
        href="peminjaman.php"
        class="btn w-100 text-start mb-3 <?= ($current=="peminjaman.php") ? "btn-primary" : "btn-dark"; ?>">

            <i class="bi bi-journal-bookmark me-2"></i>

            Peminjaman

        </a>



        <a
        href="pengembalian.php"
        class="btn w-100 text-start mb-3 <?= ($current=="pengembalian.php") ? "btn-primary" : "btn-dark"; ?>">

            <i class="bi bi-arrow-return-left me-2"></i>

            Pengembalian

        </a>



        <a
        href="profile.php"
        class="btn w-100 text-start mb-3 <?= ($current=="profile.php") ? "btn-primary" : "btn-dark"; ?>">

            <i class="bi bi-person me-2"></i>

            Profile

        </a>

    </div>



    <!-- LOGOUT -->

    <div class="mt-auto p-3">

        <hr>

        <a
        href="../auth/logout.php"
        class="btn btn-outline-danger w-100">

            <i class="bi bi-box-arrow-right me-2"></i>

            Logout

        </a>

    </div>

</div>