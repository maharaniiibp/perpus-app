<?php

$host = "127.0.0.1";
$user = "u116389202_perpus";
$pass = "perpusjaya2A";
$db   = "u116389202_perpustakaan";

$conn = mysqli_connect($host, $user, $pass, $db);

if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}
?>