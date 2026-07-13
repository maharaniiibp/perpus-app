<?php

session_start();

if (!isset($_SESSION['role'])) {

    header("Location: ../auth/login.php");
    exit;

}

include "../config/koneksi.php";

if(!isset($_GET['id'])){

    header("Location: buku.php");
    exit;

}

$id = $_GET['id'];


// ============================
// AMBIL DATA BUKU
// ============================

$query = mysqli_query($conn,"
SELECT *
FROM buku
WHERE id_buku='$id'
");

if(mysqli_num_rows($query)==0){

    echo "<script>

    alert('Data buku tidak ditemukan.');

    window.location='buku.php';

    </script>";

    exit;

}

$data = mysqli_fetch_assoc($query);


// ============================
// HAPUS COVER
// ============================

if(!empty($data['cover'])){

    $file = "../assets/image/buku/".$data['cover'];

    if(file_exists($file)){

        unlink($file);

    }

}


// ============================
// HAPUS DATA
// ============================

$hapus = mysqli_query($conn,"
DELETE FROM buku
WHERE id_buku='$id'
");


// ============================
// HASIL
// ============================

if($hapus){

?>

<script>

alert("Data buku berhasil dihapus.");

window.location="buku.php";

</script>

<?php

}else{

?>

<script>

alert("Data buku gagal dihapus.");

window.location="buku.php";

</script>

<?php

}

?>