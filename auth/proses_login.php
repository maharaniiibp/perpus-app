<?php

session_start();
include "../config/koneksi.php";

$username = $_POST['username'];
$password = $_POST['password'];


// ====================
// LOGIN ADMIN
// ====================

$queryAdmin = mysqli_query($conn,
"SELECT * FROM admin
WHERE username='$username'
AND password='$password'");

if(mysqli_num_rows($queryAdmin) > 0){

    $data = mysqli_fetch_assoc($queryAdmin);

    $_SESSION['id'] = $data['id_admin'];
    $_SESSION['nama'] = $data['nama_admin'];
    $_SESSION['role'] = "admin";

    header("Location: ../admin/dashboard.php");
    exit;
}


// ====================
// LOGIN SISWA
// ====================

$querySiswa = mysqli_query($conn,"
SELECT *
FROM siswa
WHERE nis='$username'
");

if(mysqli_num_rows($querySiswa) > 0){

    $data = mysqli_fetch_assoc($querySiswa);

    if(password_verify($password, $data['password'])){

        $_SESSION['id'] = $data['id_siswa'];
        $_SESSION['nama'] = $data['nama_siswa'];
        $_SESSION['role'] = "siswa";

        header("Location: ../siswa/dashboard.php");
        exit;

    }

}

echo "<script>

alert('Username atau Password Salah');

window.location='login.php';

</script>";

?>