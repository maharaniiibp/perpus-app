<?php

session_start();

if(!isset($_SESSION['role'])){

    header("Location: ../auth/login.php");
    exit;

}

include "../config/koneksi.php";

$id_siswa       = $_POST['id_siswa'];
$nis            = mysqli_real_escape_string($conn,$_POST['nis']);
$nama_siswa     = mysqli_real_escape_string($conn,$_POST['nama_siswa']);
$kelas          = mysqli_real_escape_string($conn,$_POST['kelas']);
$jenis_kelamin  = mysqli_real_escape_string($conn,$_POST['jenis_kelamin']);
$email          = mysqli_real_escape_string($conn,$_POST['email']);
$no_hp          = mysqli_real_escape_string($conn,$_POST['no_hp']);
$alamat         = mysqli_real_escape_string($conn,$_POST['alamat']);
$password       = $_POST['password'];


// ==============================
// AMBIL DATA LAMA
// ==============================

$get = mysqli_query($conn,"
SELECT *
FROM siswa
WHERE id_siswa='$id_siswa'
");

$data = mysqli_fetch_assoc($get);

$foto = $data['foto'];


// ==============================
// UPLOAD FOTO BARU
// ==============================

if(isset($_FILES['foto']) && $_FILES['foto']['error']==0){

    if(!empty($foto) && file_exists("../assets/image/siswa/".$foto)){

        unlink("../assets/image/siswa/".$foto);

    }

    $ext = strtolower(pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION));

    $namaFoto = time()."_".$_FILES['foto']['name'];

    move_uploaded_file(

        $_FILES['foto']['tmp_name'],

        "../assets/image/siswa/".$namaFoto

    );

    $foto = $namaFoto;

}


// ==============================
// UPDATE PASSWORD
// ==============================

if(!empty($password)){

    $password = password_hash($password,PASSWORD_DEFAULT);

    $query = mysqli_query($conn,"

    UPDATE siswa SET

    nis='$nis',
    nama_siswa='$nama_siswa',
    kelas='$kelas',
    jenis_kelamin='$jenis_kelamin',
    email='$email',
    no_hp='$no_hp',
    alamat='$alamat',
    password='$password',
    foto='$foto'

    WHERE id_siswa='$id_siswa'

    ");

}else{

    $query = mysqli_query($conn,"

    UPDATE siswa SET

    nis='$nis',
    nama_siswa='$nama_siswa',
    kelas='$kelas',
    jenis_kelamin='$jenis_kelamin',
    email='$email',
    no_hp='$no_hp',
    alamat='$alamat',
    foto='$foto'

    WHERE id_siswa='$id_siswa'

    ");

}


// ==============================
// HASIL
// ==============================

if($query){

?>

<script>

alert("Data siswa berhasil diperbarui.");

window.location="siswa.php";

</script>

<?php

}else{

?>

<script>

alert("Data siswa gagal diperbarui.");

window.history.back();

</script>

<?php

}

?>