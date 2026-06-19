<?php
include 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $bahan_id = $_POST['bahan_id'];
    $jumlah = $_POST['jumlah'];
    $keterangan = $_POST['keterangan'];

    // 1. Update stok di tabel bahan (tambah jumlah)
    $update_stok = mysqli_query($koneksi, "UPDATE bahan SET stok_saat_ini = stok_saat_ini + $jumlah WHERE id = '$bahan_id'");

    // 2. Masukkan ke riwayat stok
    $insert_riwayat = mysqli_query($koneksi, "INSERT INTO riwayat_stok (bahan_id, tipe, jumlah, keterangan) VALUES ('$bahan_id', 'Masuk', '$jumlah', '$keterangan')");

    if ($update_stok && $insert_riwayat) {
        echo "<script>alert('Stok berhasil ditambah!'); window.location='index.php';</script>";
    } else {
        echo "<script>alert('Gagal menambah stok.'); window.history.back();</script>";
    }
}
?>