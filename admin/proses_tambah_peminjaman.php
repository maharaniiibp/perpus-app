<?php

session_start();

if(!isset($_SESSION['role'])){

    header("Location: ../auth/login.php");
    exit;

}

include "../config/koneksi.php";

$id_siswa        = $_POST['id_siswa'];
$id_buku         = $_POST['id_buku'];
$id_admin        = $_POST['id_admin'];
$tanggal_pinjam  = $_POST['tanggal_pinjam'];
$batas_kembali   = $_POST['batas_kembali'];
$status          = $_POST['status'];


// ==========================
// CEK STOK BUKU
// ==========================

$cek = mysqli_query($conn,"
SELECT stok
FROM buku
WHERE id_buku='$id_buku'
");

$buku = mysqli_fetch_assoc($cek);

if($buku['stok'] <= 0){

?>

<script>

alert("Stok buku habis.");

window.location="tambah_peminjaman.php";

</script>

<?php

exit;

}



// ==========================
// SIMPAN PEMINJAMAN
// ==========================

$query = mysqli_query($conn,"

INSERT INTO peminjaman(

id_siswa,
id_buku,
id_admin,
tanggal_pinjam,
batas_kembali,
status

)

VALUES(

'$id_siswa',
'$id_buku',
'$id_admin',
'$tanggal_pinjam',
'$batas_kembali',
'$status'

)

");



// ==========================
// KURANGI STOK
// ==========================

if($query){

    mysqli_query($conn,"
    UPDATE buku
    SET stok = stok - 1
    WHERE id_buku='$id_buku'
    ");

?>

<script>

alert("Peminjaman berhasil ditambahkan.");

window.location="peminjaman.php";

</script>

<?php

}else{

?>

<script>

alert("Gagal menambahkan peminjaman.");

window.history.back();

</script>

<?php

}

?>