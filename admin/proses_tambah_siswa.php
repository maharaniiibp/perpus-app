<?php

session_start();

if(!isset($_SESSION['role'])){

    header("Location: ../auth/login.php");
    exit;

}

include "../config/koneksi.php";

$nis             = mysqli_real_escape_string($conn,$_POST['nis']);
$nama_siswa      = mysqli_real_escape_string($conn,$_POST['nama_siswa']);
$kelas           = mysqli_real_escape_string($conn,$_POST['kelas']);
$jenis_kelamin   = mysqli_real_escape_string($conn,$_POST['jenis_kelamin']);
$email           = mysqli_real_escape_string($conn,$_POST['email']);
$no_hp           = mysqli_real_escape_string($conn,$_POST['no_hp']);
$alamat          = mysqli_real_escape_string($conn,$_POST['alamat']);
$password        = password_hash($_POST['password'], PASSWORD_DEFAULT);



// ==========================
// CEK NIS
// ==========================

$cek = mysqli_query($conn,"
SELECT *
FROM siswa
WHERE nis='$nis'
");

if(mysqli_num_rows($cek)>0){

?>

<script>

alert("NIS sudah digunakan!");

window.history.back();

</script>

<?php

exit;

}



// ==========================
// UPLOAD FOTO
// ==========================

$foto = "";

if(isset($_FILES['foto']) && $_FILES['foto']['error']==0){

    $ext = strtolower(pathinfo($_FILES['foto']['name'],PATHINFO_EXTENSION));

    $allowed = ['jpg','jpeg','png'];

    if(in_array($ext,$allowed)){

        $foto = time()."_".$_FILES['foto']['name'];

        move_uploaded_file(

            $_FILES['foto']['tmp_name'],

            "../assets/image/siswa/".$foto

        );

    }

}



// ==========================
// SIMPAN DATA
// ==========================

$query = mysqli_query($conn,"

INSERT INTO siswa(

nis,
nama_siswa,
kelas,
jenis_kelamin,
email,
no_hp,
alamat,
password,
foto

)

VALUES(

'$nis',
'$nama_siswa',
'$kelas',
'$jenis_kelamin',
'$email',
'$no_hp',
'$alamat',
'$password',
'$foto'

)

");



// ==========================
// HASIL
// ==========================

if($query){

?>

<script>

alert("Data siswa berhasil ditambahkan.");

window.location="siswa.php";

</script>

<?php

}else{

?>

<script>

alert("Data siswa gagal ditambahkan.");

window.history.back();

</script>

<?php

}

?>