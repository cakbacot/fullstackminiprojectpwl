<?php
/**
 * File: config.php
 * Deskripsi: Pusat konfigurasi database untuk sistem inventaris Kuro
 */

// Konfigurasi Database
$host = "localhost";
$user = "root";     // Default user Laragon
$pass = "";         // Default password Laragon kosong
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