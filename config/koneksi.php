<?php

$host = "tokaido.proxy.rlwy.net";
$user = "root";
$pass = "gXnyGymUNJEtOFtgpphhKkpHjFphLMEP";
$db   = "railway";
$port = 37659;

$conn = mysqli_connect($host, $user, $pass, $db, $port);

if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}
?>