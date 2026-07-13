<?php

session_start();

if(!isset($_SESSION['role']) || $_SESSION['role']!="siswa"){

    header("Location: ../auth/login.php");
    exit;

}

include "../config/koneksi.php";

$idSiswa = $_SESSION['id'];

$nama = mysqli_real_escape_string($conn,$_POST['nama_siswa']);
$email = mysqli_real_escape_string($conn,$_POST['email']);
$no_hp = mysqli_real_escape_string($conn,$_POST['no_hp']);
$alamat = mysqli_real_escape_string($conn,$_POST['alamat']);
$password = $_POST['password'];


// ==============================
// AMBIL DATA LAMA
// ==============================

$query = mysqli_query($conn,"
SELECT *
FROM siswa
WHERE id_siswa='$idSiswa'
");

$data = mysqli_fetch_assoc($query);

$foto = $data['foto'];

// ==============================
// UPLOAD FOTO BARU
// ==============================

if(isset($_FILES['foto']) && $_FILES['foto']['name'] != ""){

    $namaFoto = time()."_".$_FILES['foto']['name'];

    $tmp = $_FILES['foto']['tmp_name'];

    $tujuan = "../assets/image/siswa/".$namaFoto;

    if(move_uploaded_file($tmp,$tujuan)){

        // Hapus foto lama (jika ada)
        if(!empty($foto) && file_exists("../assets/image/siswa/".$foto)){

            unlink("../assets/image/siswa/".$foto);

        }

        $foto = $namaFoto;

    }

}


// ==============================
// PASSWORD
// ==============================

if(!empty($password)){

    // Menggunakan password biasa agar sesuai dengan sistem login kamu saat ini
    $passwordBaru = mysqli_real_escape_string($conn,$password);

}else{

    $passwordBaru = $data['password'];

}

// ==============================
// UPDATE DATA SISWA
// ==============================

$update = mysqli_query($conn, "

UPDATE siswa SET

nama_siswa='$nama',
email='$email',
no_hp='$no_hp',
alamat='$alamat',
password='$passwordBaru',
foto='$foto'

WHERE id_siswa='$idSiswa'

");


// ==============================
// HASIL UPDATE
// ==============================

if($update){

?>

<script>

alert("Profil berhasil diperbarui.");

window.location="profile.php";

</script>

<?php

}else{

?>

<script>

alert("Profil gagal diperbarui.");

window.history.back();

</script>

<?php

}

?>