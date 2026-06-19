<?php
include 'config.php';

if(isset($_POST['submit'])){
    $id_bahan = $_POST['id_bahan'];
    $jumlah_keluar = $_POST['jumlah_keluar'];
    $tanggal = date('Y-m-d'); // Tanggal hari ini

    // 1. Cek stok menggunakan nama kolom 'stok_saat_ini'
    $cek_stok = mysqli_query($koneksi, "SELECT stok_saat_ini FROM bahan WHERE id = '$id_bahan'");
    $data_stok = mysqli_fetch_array($cek_stok);
    $stok_sekarang = $data_stok['stok_saat_ini'];

    // 2. Validasi stok
    if($stok_sekarang >= $jumlah_keluar) {
        
        // 3. Update (kurangi) stok_saat_ini
        $update_stok = mysqli_query($koneksi, "UPDATE bahan SET stok_saat_ini = stok_saat_ini - $jumlah_keluar WHERE id = '$id_bahan'");

        // 4. Catat ke tabel riwayat_stok
        // CATATAN: Pastikan kolom di tabel riwayat_stok kamu sesuai dengan query ini.
        // Jika nama kolomnya beda (misal 'bahan_id' atau 'tipe_transaksi'), silakan disesuaikan.
        $insert_riwayat = mysqli_query($koneksi, "INSERT INTO riwayat_stok (bahan_id, jumlah, jenis, tanggal) VALUES ('$id_bahan', '$jumlah_keluar', 'Keluar', '$tanggal')");

        if($update_stok && $insert_riwayat) {
            header("Location: index.php?pesan=sukses_keluar");
            exit;
        } else {
            echo "Error Database: " . mysqli_error($koneksi);
        }

    } else {
        header("Location: stok_keluar.php?pesan=stok_kurang");
        exit;
    }
} else {
    header("Location: stok_keluar.php");
    exit;
}
?>