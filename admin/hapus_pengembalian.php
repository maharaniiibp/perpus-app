<?php

session_start();

if(!isset($_SESSION['role'])){

    header("Location: ../auth/login.php");
    exit;

}

include "../config/koneksi.php";

if(!isset($_GET['id'])){

    header("Location: pengembalian.php");
    exit;

}

$id = $_GET['id'];


// ===========================
// CEK DATA
// ===========================

$query = mysqli_query($conn,"
SELECT *
FROM pengembalian
WHERE id_pengembalian='$id'
");

if(mysqli_num_rows($query)==0){

?>

<script>

alert("Data pengembalian tidak ditemukan.");

window.location="pengembalian.php";

</script>

<?php

exit;

}

$data = mysqli_fetch_assoc($query);


// ===========================
// KEMBALIKAN STATUS PEMINJAMAN
// ===========================

mysqli_query($conn,"
UPDATE peminjaman
SET status='Dipinjam'
WHERE id_pinjam='".$data['id_pinjam']."'
");


// ===========================
// AMBIL ID BUKU
// ===========================

$peminjaman = mysqli_query($conn,"
SELECT id_buku
FROM peminjaman
WHERE id_pinjam='".$data['id_pinjam']."'
");

$pinjam = mysqli_fetch_assoc($peminjaman);


// ===========================
// KURANGI STOK LAGI
// Karena sebelumnya sudah ditambah
// saat proses pengembalian
// ===========================

mysqli_query($conn,"
UPDATE buku
SET stok = stok - 1
WHERE id_buku='".$pinjam['id_buku']."'
");


// ===========================
// HAPUS DATA
// ===========================

$hapus = mysqli_query($conn,"
DELETE FROM pengembalian
WHERE id_pengembalian='$id'
");


// ===========================
// HASIL
// ===========================

if($hapus){

?>

<script>

alert("Data pengembalian berhasil dihapus.");

window.location="pengembalian.php";

</script>

<?php

}else{

?>

<script>

alert("Data pengembalian gagal dihapus.");

window.location="pengembalian.php";

</script>

<?php

}

?>