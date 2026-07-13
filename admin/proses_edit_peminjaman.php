<?php

session_start();

if(!isset($_SESSION['role'])){

    header("Location: ../auth/login.php");
    exit;

}

include "../config/koneksi.php";

$id_pinjam       = $_POST['id_pinjam'];
$id_siswa        = $_POST['id_siswa'];
$id_buku_baru    = $_POST['id_buku'];
$id_admin        = $_POST['id_admin'];
$tanggal_pinjam  = $_POST['tanggal_pinjam'];
$batas_kembali   = $_POST['batas_kembali'];
$status_baru     = $_POST['status'];


// ===========================
// DATA LAMA
// ===========================

$q = mysqli_query($conn,"
SELECT *
FROM peminjaman
WHERE id_pinjam='$id_pinjam'
");

$lama = mysqli_fetch_assoc($q);

$id_buku_lama = $lama['id_buku'];
$status_lama  = $lama['status'];


// ===========================
// JIKA GANTI BUKU
// ===========================

if($id_buku_lama != $id_buku_baru){

    // kembalikan stok buku lama

    mysqli_query($conn,"
    UPDATE buku
    SET stok = stok + 1
    WHERE id_buku='$id_buku_lama'
    ");

    // kurangi stok buku baru

    mysqli_query($conn,"
    UPDATE buku
    SET stok = stok - 1
    WHERE id_buku='$id_buku_baru'
    ");

}


// ===========================
// JIKA STATUS BERUBAH
// ===========================

// Dipinjam -> Dikembalikan

if($status_lama=="Dipinjam" && $status_baru=="Dikembalikan"){

    mysqli_query($conn,"
    UPDATE buku
    SET stok = stok + 1
    WHERE id_buku='$id_buku_baru'
    ");

}


// Dikembalikan -> Dipinjam

if($status_lama=="Dikembalikan" && $status_baru=="Dipinjam"){

    mysqli_query($conn,"
    UPDATE buku
    SET stok = stok - 1
    WHERE id_buku='$id_buku_baru'
    ");

}


// ===========================
// UPDATE PEMINJAMAN
// ===========================

$query = mysqli_query($conn,"

UPDATE peminjaman SET

id_siswa='$id_siswa',
id_buku='$id_buku_baru',
id_admin='$id_admin',
tanggal_pinjam='$tanggal_pinjam',
batas_kembali='$batas_kembali',
status='$status_baru'

WHERE id_pinjam='$id_pinjam'

");


// ===========================
// HASIL
// ===========================

if($query){

?>

<script>

alert("Data peminjaman berhasil diperbarui.");

window.location="peminjaman.php";

</script>

<?php

}else{

?>

<script>

alert("Data peminjaman gagal diperbarui.");

window.history.back();

</script>

<?php

}

?>