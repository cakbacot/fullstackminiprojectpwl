<?php

$host = "localhost";
$user = "root";     
$pass = "";         
$db   = "db_kuro_inventaris";

// Membuat Koneksi
$koneksi = mysqli_connect($host, $user, $pass, $db);

// Cek Koneksi
if (!$koneksi) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

// Set timezone agar tanggal di database sinkron dengan waktu lokal (Indonesia)
date_default_timezone_set('Asia/Jakarta');

?>