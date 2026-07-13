<?php

session_start();

if (!isset($_SESSION['role'])) {

    header("Location: ../auth/login.php");
    exit;

}

include "../config/koneksi.php";

$id_buku       = $_POST['id_buku'];
$isbn          = mysqli_real_escape_string($conn,$_POST['isbn']);
$judul         = mysqli_real_escape_string($conn,$_POST['judul']);
$penulis       = mysqli_real_escape_string($conn,$_POST['penulis']);
$penerbit      = mysqli_real_escape_string($conn,$_POST['penerbit']);
$tahun_terbit  = $_POST['tahun_terbit'];
$stok          = $_POST['stok'];
$deskripsi     = mysqli_real_escape_string($conn,$_POST['deskripsi']);
$id_kategori   = $_POST['id_kategori'];
$id_lokasi     = $_POST['id_lokasi'];



// ================================
// CEK COVER LAMA
// ================================

$q = mysqli_query($conn,"
SELECT cover
FROM buku
WHERE id_buku='$id_buku'
");

$data = mysqli_fetch_assoc($q);

$cover = $data['cover'];



// ================================
// JIKA UPLOAD COVER BARU
// ================================

if($_FILES['cover']['name']!=""){

    // hapus cover lama

    if($cover!=""){

        $fileLama = "../assets/image/buku/".$cover;

        if(file_exists($fileLama)){

            unlink($fileLama);

        }

    }

    // upload cover baru

    $cover = $_FILES['cover']['name'];

    $tmp = $_FILES['cover']['tmp_name'];

    move_uploaded_file(

        $tmp,

        "../assets/image/buku/".$cover

    );

}



// ================================
// UPDATE DATABASE
// ================================

$query = mysqli_query($conn,"

UPDATE buku SET

isbn='$isbn',

judul='$judul',

penulis='$penulis',

penerbit='$penerbit',

tahun_terbit='$tahun_terbit',

stok='$stok',

cover='$cover',

deskripsi='$deskripsi',

id_kategori='$id_kategori',

id_lokasi='$id_lokasi'

WHERE id_buku='$id_buku'

");



// ================================
// HASIL
// ================================

if($query){

?>

<script>

alert("Data buku berhasil diperbarui.");

window.location="buku.php";

</script>

<?php

}else{

?>

<script>

alert("Data buku gagal diperbarui.");

window.history.back();

</script>

<?php

}

?>