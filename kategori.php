<?php
include 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $bahan_id = $_POST['bahan_id'];
    $jumlah = $_POST['jumlah'];
    $keterangan = $_POST['keterangan'];

    // 1. Cek stok saat ini
    $cek_stok = mysqli_query($koneksi, "SELECT stok_saat_ini FROM bahan WHERE id = '$bahan_id'");
    $data = mysqli_fetch_assoc($cek_stok);

    if ($data['stok_saat_ini'] >= $jumlah) {
        // 2. Update stok di tabel bahan
        mysqli_query($koneksi, "UPDATE bahan SET stok_saat_ini = stok_saat_ini - $jumlah WHERE id = '$bahan_id'");

        // 3. Masukkan ke riwayat stok
        mysqli_query($koneksi, "INSERT INTO riwayat_stok (bahan_id, tipe, jumlah, keterangan) VALUES ('$bahan_id', 'Keluar', '$jumlah', '$keterangan')");

        echo "<script>alert('Stok berhasil dikurangi!'); window.location='index.php';</script>";
    } else {
        echo "<script>alert('Gagal! Stok tidak mencukupi.'); window.history.back();</script>";
    }
}
?>