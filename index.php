<?php
session_start();

if(isset($_SESSION['role'])){

    if($_SESSION['role']=="admin"){
        header("Location: admin/dashboard.php");
    }

    if($_SESSION['role']=="siswa"){
        header("Location: siswa/dashboard.php");
    }

}

header("Location: auth/login.php");
exit;