<?php

session_start();

if (!isset($_SESSION['role'])) {

    header("Location: ../auth/login.php");
    exit;
}

include "../config/koneksi.php";


// ===========================
// AMBIL DATA
// ===========================

$isbn          = mysqli_real_escape_string($conn, $_POST['isbn']);
$judul         = mysqli_real_escape_string($conn, $_POST['judul']);
$penulis       = mysqli_real_escape_string($conn, $_POST['penulis']);
$penerbit      = mysqli_real_escape_string($conn, $_POST['penerbit']);
$tahun_terbit  = mysqli_real_escape_string($conn, $_POST['tahun_terbit']);
$stok          = mysqli_real_escape_string($conn, $_POST['stok']);
$deskripsi     = mysqli_real_escape_string($conn, $_POST['deskripsi']);
$id_kategori   = mysqli_real_escape_string($conn, $_POST['id_kategori']);
$id_lokasi     = mysqli_real_escape_string($conn, $_POST['id_lokasi']);


// ===========================
// UPLOAD COVER
// ===========================

$cover = "";

if(isset($_FILES['cover']) && $_FILES['cover']['error'] == 0){

    $namaFile = $_FILES['cover']['name'];
    $tmpFile  = $_FILES['cover']['tmp_name'];
    $ukuran   = $_FILES['cover']['size'];

    $ext = strtolower(pathinfo($namaFile, PATHINFO_EXTENSION));

    $allowed = ['jpg','jpeg','png'];

    if(in_array($ext,$allowed)){

        if($ukuran <= 2 * 1024 * 1024){

            $cover = time().".".$ext;

            move_uploaded_file(
                $tmpFile,
                "../assets/image/buku/".$cover
            );

        }else{

            echo "<script>

            alert('Ukuran gambar maksimal 2 MB.');

            window.history.back();

            </script>";

            exit;

        }

    }else{

        echo "<script>

        alert('Format gambar harus JPG, JPEG, atau PNG.');

        window.history.back();

        </script>";

        exit;

    }

}


// ===========================
// SIMPAN DATABASE
// ===========================

$query = mysqli_query($conn,"

INSERT INTO buku(

isbn,
judul,
penulis,
penerbit,
tahun_terbit,
stok,
cover,
deskripsi,
id_kategori,
id_lokasi

)

VALUES(

'$isbn',
'$judul',
'$penulis',
'$penerbit',
'$tahun_terbit',
'$stok',
'$cover',
'$deskripsi',
'$id_kategori',
'$id_lokasi'

)

");


// ===========================
// HASIL
// ===========================

if($query){

    echo "<script>

    alert('Data buku berhasil ditambahkan.');

    window.location='buku.php';

    </script>";

}else{

    echo "<script>

    alert('Gagal menambahkan data buku.');

    window.history.back();

    </script>";

}

?>