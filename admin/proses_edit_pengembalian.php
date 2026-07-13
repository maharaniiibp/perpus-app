<?php

session_start();

if(!isset($_SESSION['role'])){

    header("Location: ../auth/login.php");
    exit;

}

include "../config/koneksi.php";

$id_pengembalian = $_POST['id_pengembalian'];
$tanggal_kembali = $_POST['tanggal_kembali'];


// ===========================
// AMBIL DATA PENGEMBALIAN
// ===========================

$query = mysqli_query($conn,"

SELECT

pengembalian.id_pinjam,

peminjaman.batas_kembali

FROM pengembalian

INNER JOIN peminjaman
ON peminjaman.id_pinjam=pengembalian.id_pinjam

WHERE pengembalian.id_pengembalian='$id_pengembalian'

");

$data = mysqli_fetch_assoc($query);


// ===========================
// HITUNG KETERLAMBATAN
// ===========================

$batas = strtotime($data['batas_kembali']);
$kembali = strtotime($tanggal_kembali);

$terlambat = "Tidak";
$denda = 0;
$status = "Selesai";

if($kembali > $batas){

    $hari = floor(($kembali - $batas) / (60 * 60 * 24));

    $terlambat = "Ya";

    $denda = $hari * 1000;

    $status = "Terlambat";

}


// ===========================
// UPDATE DATA
// ===========================

$update = mysqli_query($conn,"

UPDATE pengembalian SET

tanggal_kembali='$tanggal_kembali',
terlambat='$terlambat',
denda='$denda',
status='$status'

WHERE id_pengembalian='$id_pengembalian'

");


// ===========================
// HASIL
// ===========================

if($update){

?>

<script>

alert("Data pengembalian berhasil diperbarui.");

window.location="pengembalian.php";

</script>

<?php

}else{

?>

<script>

alert("Data pengembalian gagal diperbarui.");

window.history.back();

</script>

<?php

}

?>  