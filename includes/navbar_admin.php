<?php

include "../config/koneksi.php";

$id_admin = $_SESSION['id'];

$queryAdmin = mysqli_query($conn,"
SELECT *
FROM admin
WHERE id_admin='$id_admin'
");

$admin = mysqli_fetch_assoc($queryAdmin);

// keyword search
$keyword = isset($_GET['search']) ? $_GET['search'] : "";

?>

<!-- NAVBAR -->

<nav class="navbar bg-white shadow-sm rounded-4 px-4 py-3 mb-4">

    <div class="container-fluid">

        <!-- SEARCH -->

        <form
            class="col-lg-7"
            method="GET"
            action="">

            <div class="input-group">

                <span
                    class="input-group-text
                    bg-light
                    border-0
                    rounded-start-pill
                    px-4">

                    <i class="bi bi-search text-secondary"></i>

                </span>

                <input
                    type="text"
                    name="search"
                    class="form-control border-0 bg-light rounded-end-pill"
                    placeholder="Cari buku, siswa, atau transaksi..."
                    value="<?= htmlspecialchars($keyword); ?>">

            </div>

        </form>



        <!-- PROFILE -->

        <div class="d-flex align-items-center">

            <!-- Notification -->

            <button
                class="btn border-0 bg-transparent position-relative me-4">

                <i class="bi bi-bell fs-5"></i>

                <!-- titik merah -->

                <span
                    class="position-absolute
                    top-0
                    start-100
                    translate-middle
                    p-2
                    bg-danger
                    border
                    border-light
                    rounded-circle">

                </span>

            </button>



            <!-- Divider -->

            <div
                class="vr mx-2"
                style="height:40px;"></div>



            <!-- Admin -->

            <div class="d-flex align-items-center ms-2">

                <div class="text-end me-3">

                    <h6 class="mb-0 fw-bold">

                        <?= $admin['nama_admin']; ?>

                    </h6>

                    <small class="text-secondary">

                        Super Admin

                    </small>

                </div>

                <img
    src="../assets/image/default-user.png"
    alt="Admin"
    width="50"
    height="50"
    class="rounded-circle border border-3 border-primary"
    style="object-fit:cover;">
            </div>

        </div>

    </div>

</nav>