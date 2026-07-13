<?php

session_start();

if(!isset($_SESSION['role'])){

    header("Location: ../auth/login.php");
    exit;

}

include "../config/koneksi.php";

if(!isset($_GET['id'])){

    header("Location: peminjaman.php");
    exit;

}

$id = $_GET['id'];


// ==========================
// AMBIL DATA PEMINJAMAN
// ==========================

$query = mysqli_query($conn,"
SELECT *
FROM peminjaman
WHERE id_pinjam='$id'
");

if(mysqli_num_rows($query)==0){

?>

<script>

alert("Data peminjaman tidak ditemukan.");

window.location="peminjaman.php";

</script>

<?php

exit;

}

$data = mysqli_fetch_assoc($query);

$id_buku = $data['id_buku'];


// ==========================
// KEMBALIKAN STOK
// ==========================

if($data['status']=="Dipinjam"){

    mysqli_query($conn,"
    UPDATE buku
    SET stok = stok + 1
    WHERE id_buku='$id_buku'
    ");

}


// ==========================
// HAPUS DATA
// ==========================

$hapus = mysqli_query($conn,"
DELETE FROM peminjaman
WHERE id_pinjam='$id'
");


// ==========================
// HASIL
// ==========================

if($hapus){

?>

<script>

alert("Data peminjaman berhasil dihapus.");

window.location="peminjaman.php";

</script>

<?php

}else{

?>

<script>

alert("Data peminjaman gagal dihapus.");

window.location="peminjaman.php";

</script>

<?php

}

?>