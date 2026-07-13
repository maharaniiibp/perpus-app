<?php

session_start();

if(!isset($_SESSION['role'])){

    header("Location: ../auth/login.php");
    exit;

}

include "../config/koneksi.php";

$id_pinjam = $_POST['id_pinjam'];
$tanggal_kembali = $_POST['tanggal_kembali'];


// ==============================
// AMBIL DATA PEMINJAMAN
// ==============================

$q = mysqli_query($conn,"
SELECT *
FROM peminjaman
WHERE id_pinjam='$id_pinjam'
");

$pinjam = mysqli_fetch_assoc($q);

$id_buku = $pinjam['id_buku'];

$batas = strtotime($pinjam['batas_kembali']);
$kembali = strtotime($tanggal_kembali);


// ==============================
// HITUNG TERLAMBAT & DENDA
// ==============================

$terlambat = "Tidak";
$denda = 0;
$status = "Selesai";

if($kembali > $batas){

    $selisih = floor(($kembali - $batas) / (60*60*24));

    $terlambat = "Ya";

    $denda = $selisih * 1000;

    $status = "Terlambat";

}


// ==============================
// SIMPAN PENGEMBALIAN
// ==============================

$query = mysqli_query($conn,"

INSERT INTO pengembalian(

id_pinjam,
tanggal_kembali,
terlambat,
denda,
status

)

VALUES(

'$id_pinjam',
'$tanggal_kembali',
'$terlambat',
'$denda',
'$status'

)

");


// ==============================
// UPDATE PEMINJAMAN
// ==============================

if($query){

    mysqli_query($conn,"
    UPDATE peminjaman
    SET status='Dikembalikan'
    WHERE id_pinjam='$id_pinjam'
    ");

    mysqli_query($conn,"
    UPDATE buku
    SET stok = stok + 1
    WHERE id_buku='$id_buku'
    ");

?>

<script>

alert("Pengembalian berhasil diproses.");

window.location="pengembalian.php";

</script>

<?php

}else{

?>

<script>

alert("Pengembalian gagal diproses.");

window.history.back();

</script>

<?php

}

?>